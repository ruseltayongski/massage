<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spa;
use App\Models\Services;
use App\Models\User;
use App\Models\Bookings;
use App\Models\Ratings;
use App\Models\Testimonials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard() {
        $spas = Spa::select(DB::raw('ROUND((SELECT AVG(ratings.rate) FROM ratings WHERE ratings.spa_id = spa.id)) as ratings_spa'),'spa.*')->get();
        $services = Services::get();
        return view('client.dashboard',[
            'spas' => $spas,
            'services' => $services
        ]);
    }

    public function clientProfile() {
        $user = Auth::user();
        $userProfile = User::where('roles', 'CLIENT')
                            ->where('id', $user->id)
                            ->first();
        return view('client.profile', [
            "userProfile" => $userProfile
        ]);
    }
    public function services(Request $request) {
        $spa_id = $request->spa;
        $services = Services::where('spa_id',$spa_id)->get();
        return view('client.services',[
            'spa_id' => $spa_id,
            'services' => $services
        ]);
    }

    public function therapist(Request $request) {
        $spa_id = $request->spa;
        $service_id = $request->service;
        $therapists = User::select(
            DB::raw('ROUND((SELECT AVG(ratings.rate) FROM ratings WHERE ratings.therapist_id = users.id)) as ratings_therapist')
            ,'users.*'
        )
        ->where('users.spa_id',$spa_id)
        ->get();

        return view('client.therapist',[
            'spa_id' => $spa_id,
            'service_id' => $service_id,
            'therapists' => $therapists,
            'price' => $request->price
        ]);
    }

    public function booking(Request $request) {
        $spa_id = $request->spa;
        $service_id = $request->service;
        $therapist_id = $request->therapist;
        return view('client.booking',[
            'spa_id' => $spa_id,
            'service_id' => $service_id,
            'therapist_id' => $therapist_id
        ]);
    }

    public function bookingSave(Request $request) {
        $user = Auth::user();
        if ($request->hasFile('payment_picture')) {
            $image = $request->file('payment_picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('fileupload/client/payment'), $imageName);
        }
    
        // Create a new booking record
        $booking = new Bookings();
        $booking->client_id = $user->id;
        $booking->spa_id = $request->spa_id;
        $booking->service_id = $request->service_id;
        $booking->therapist_id = $request->therapist_id;
        $booking->start_date = date('Y-m-d');
        $booking->start_time = date('H:i:s',strtotime($request->start_time));
        $booking->amount_paid = $request->amount_paid;
        $booking->payment_picture = $imageName;
        $booking->booking_type = $request->booking_type;
        $booking->status = 'Pending';
        $booking->save();

        session()->flash('booking_save', true);
        return redirect(route('client.booking.history'));
    }

    public function bookingHistory(Request $request) {
        $user = Auth::user();
        $bookings = Bookings::select(
                        'bookings.id',
                        'users.id as therapist_id',
                        'spa.id as spa_id',
                        'spa.name as spa_name',
                        'services.name as services',
                        DB::raw("concat(users.fname,' ',users.lname) as therapist"),
                        'bookings.booking_type',
                        'bookings.start_date',
                        'bookings.start_time',
                        'bookings.amount_paid',
                        'bookings.status',
                        'bookings.payment_picture',
                        DB::raw('ROUND((SELECT AVG(ratings.rate) FROM ratings WHERE ratings.spa_id = spa.id)) as ratings_spa'),
                        DB::raw('ROUND((SELECT AVG(ratings.rate) FROM ratings WHERE ratings.therapist_id = users.id)) as ratings_therapist')
                    )
                    ->where('client_id',$user->id)
                    ->leftJoin('spa','spa.id','=','bookings.spa_id')
                    ->leftJoin('services','services.id','=','bookings.service_id')
                    ->leftJoin('users','users.id','=','bookings.therapist_id')
                    ->paginate(15);
        
        return view('client.booking_history',[
            'bookings' => $bookings
        ]);
    }

    public function rateSpa(Request $request) {
        $spa = Spa::find($request->spa_id);
        $ratings = Ratings::where('spa_id',$request->spa_id)->avg('rate');
        $feedbacks = Ratings::
                    select(
                        DB::raw("concat(users.fname,' ',users.lname,':') as feedback_by"),
                        'ratings.feedback'
                    )
                    ->where('ratings.spa_id',$request->spa_id)
                    ->leftJoin('users','users.id','=','ratings.feedback_by')
                    ->get();
        return view('client.rate_spa', [
            'spa' => $spa,
            'ratings' => round($ratings),
            'feedbacks' => $feedbacks
        ]);
    }

    public function rateSpaSave(Request $request) {
        $user = Auth::user();
        $rating = new Ratings();
        $rating->spa_id = $request->spa_id;
        $rating->feedback_by = $user->id;
        $rating->feedback = $request->feedback;
        $rating->rate = $request->rate;
        $rating->save();

        session()->flash('rate_spa_save', true);
        return true;
    }

    public function rateTherapist(Request $request) {
        $therapist = User::find($request->therapist_id);
        $ratings = Ratings::where('therapist_id',$request->therapist_id)->avg('rate');
        $feedbacks = Ratings::
                    select(
                        DB::raw("concat(users.fname,' ',users.lname,':') as feedback_by"),
                        'ratings.feedback'
                    )
                    ->where('therapist_id',$request->therapist_id)
                    ->leftJoin('users','users.id','=','ratings.feedback_by')
                    ->get();
        return view('client.rate_therapist', [
            'therapist' => $therapist,
            'ratings' => round($ratings),
            'feedbacks' => $feedbacks
        ]);
    }

    public function rateTherapistSave(Request $request) {
        $user = Auth::user();
        $rating = new Ratings();
        $rating->therapist_id = $request->therapist_id;
        $rating->feedback_by = $user->id;
        $rating->feedback = $request->feedback;
        $rating->rate = $request->rate;
        $rating->save();

        session()->flash('rate_therapist_save', true);
        return true;
    }

    public function testimonial() {
        return view('client.testimonial');
    }

    public function testimonialSave(Request $request) {
        $user = Auth::user();
        $testimonial = new Testimonials();
        $testimonial->user_id = $user->id;
        $testimonial->description = $request->description;
        $testimonial->save();

        session()->flash('testimonial_save', true);
        return redirect()->back();
    }

}
