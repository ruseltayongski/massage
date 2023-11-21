<?php

namespace App\Http\Controllers;

use App\Models\Spa;
use App\Models\User;
use App\Models\Ratings;
use App\Models\Bookings;
use App\Models\Services;
use App\Models\Testimonials;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

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

    public function updateProfile(Request $request) {
        if($request->has('id')) {
            $userId = $request->input('id');
            $user = User::find($userId);
            $user->fname = $request->input('fname');
            $user->lname = $request->input('lname');
            $user->address = $request->input('address');
            $user->mobile = $request->input('mobile');
            $user->email = $request->input('email');
            $user->is_deleted = $request->input('is_deleted');
            
            if($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }
        
            if($request->hasFile('picture')) {
                $userProfile = $request->file('picture');
                $userFileName = 'picture' .uniqid() . '.' . $userProfile->getClientOriginalExtension();
                $uploadPath = public_path('/fileupload/client/profile/');
                $userProfile->move($uploadPath, $userFileName);
                
                Image::make($uploadPath . $userFileName)
                        ->resize(255,366)
                        ->save();

                $user->picture = $userFileName;
 
            }
            $user->save(); 
            session()->flash('profile_update', true);
            if($user->is_deleted) {
                Session::flush();
                Auth::logout();
            }  
        }
        return redirect()->back();
    }
    public function services(Request $request) {
        $spa_id = $request->spa;

        if(isset($spa_id)) {
            session(['spa_id' => $spa_id]);
        }

        $services = Services::where('spa_id',session('spa_id'))->get();
        
        return view('client.services',[
            'services' => $services
        ]);
    }

    public function therapist(Request $request) {
        $service_id = $request->service;
        $price = $request->price;
        
        if(isset($service_id)) {
            session([
                'service_id' => $service_id,
                'price' => $price
            ]);
        }

        $therapists = User::select(
            DB::raw('ROUND((SELECT AVG(ratings.rate) FROM ratings WHERE ratings.therapist_id = users.id)) as ratings_therapist'),
            'users.*'
        )
        ->where('users.spa_id', session('spa_id'))
        ->where('roles', 'THERAPIST')
        ->where(function($q) {
            $q->where('users.is_deleted', 0)
            ->orWhereNull('users.is_deleted');
        })
        ->get();

        //return $therapists;
        return view('client.therapist',[
            'therapists' => $therapists,
            'price' => $request->price
        ]);
    }

    public function booking(Request $request) {
        $therapist_id = $request->therapist;
        if(isset($therapist_id)) {
            session(['therapist_id' => $therapist_id]);
        }
        return view('client.booking',[
            'spa_id' => session('spa_id'),
            'service_id' => session('service_id'),
            'therapist_id' => session('therapist_id')
        ]);
    }

    public function bookingSave(Request $request) {
        $user = Auth::user();
        if ($request->hasFile('payment_picture')) {
            $image = $request->file('payment_picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('fileupload/client/payment'), $imageName);
        }
        $receiptNumber = time() . '_' . $user->id;
    
        // Create a new booking record
        $booking = new Bookings();
        $booking->client_id = $user->id;
        $booking->spa_id = $request->spa_id;
        $booking->receipt_number = $receiptNumber;
        $booking->client_location = $request->client_location;
        $booking->client_no = $request->client_no;
        $booking->landmark = $request->landmark;
        $booking->service_id = $request->service_id;
        $booking->therapist_id = $request->therapist_id;
        $booking->start_date = date('Y-m-d', strtotime($request->start_date));
        $booking->start_time = date('H:i:s',strtotime($request->start_time));
        $booking->amount_paid = $request->amount_paid;
        $booking->payment_picture = $imageName;
        $booking->booking_type = $request->booking_type;
        $booking->status = 'Pending';
        $booking->save();

        $notification = new Notifications();
        $notification->booking_id = $booking->id;
        $notification->booked_by = $booking->client_id;
        $notification->notifier_id = $user->id;                       
        $notification->message = "A new booking is pending";
        $notification->save();

        session()->flash('booking_save', true);
        return redirect()->route('client.booking.history');;
    }

    public function bookingEdit(Request $request) {
        $booking = Bookings::find($request->id);
        return view('client.booking_update',[
            'booking' => $booking
        ]);
    }

    public function bookingEditSave(Request $request) {
        $user = Auth::user();
        $user->id;
        if ($request->hasFile('payment_picture')) {
            $image = $request->file('payment_picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('fileupload/client/payment'), $imageName);
        }
        $receiptNumber = time() . '_' . $user->id;
    
        // Create a new booking record
        $booking = Bookings::find($request->id);
        $booking->client_id = $user->id;
        $booking->spa_id = $request->spa_id;
        $booking->receipt_number = $receiptNumber;
        $booking->service_id = $request->service_id;
        $booking->therapist_id = $request->therapist_id;
        $booking->start_date = date('Y-m-d', strtotime($request->start_date));
        $booking->start_time = date('H:i:s',strtotime($request->start_time));
        $booking->amount_paid = $request->amount_paid;
        $booking->payment_picture = $request->hasFile('payment_picture') ? $imageName : $request->existing_image_path;
        $booking->booking_type = $request->booking_type;
        $booking->status = 'Pending';
        $booking->save();

        session()->flash('booking_edit_save', true);
        return redirect()->route('client.booking.history');;
    }

    public function bookingHistory(Request $request) {
        $user = Auth::user();
        $query = Bookings::select(
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
                    ->leftJoin('users','users.id','=','bookings.therapist_id');

                    if($request->has('status')) {
                        $status = $request->status;
                        $query->where('bookings.status', $status);
                    }
                    if ($request->has('datetimes')) {
                        $dateRange = explode(' - ', $request->input('datetimes'));
                        $startDate = date('Y-m-d', strtotime($dateRange[0]));
                        $endDate = date('Y-m-d', strtotime($dateRange[1]));
                
                        // Adjust the query to filter by the date range
                        $query->whereBetween('bookings.start_date', [$startDate, $endDate]);
                    }
                    $bookings = $query->paginate(15);
        
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
        $rating->therapist_feedback = $request->therapist_feedback;
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

    public function updateBookingStatus(Request $request) {
        //return $request->all();
        $user = Auth::user();
        $booking = Bookings::find($request->booking_id);
        $booking->status = $request->booking_status;
        if($request->booking_status == 'Approved') {
            $booking->approved_date = date('Y-m-d H:i:s');
        }
        $booking->save();

        $notification = new Notifications();
        $notification->booking_id = $booking->id;
        $notification->booked_by = $booking->client_id;
        $notification->notifier_id = $user->id;                       
        $notification->message = $booking->status.' the booking';
        $notification->save();

        return true;
    }

}
