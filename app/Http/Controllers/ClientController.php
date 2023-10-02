<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spa;
use App\Models\Services;
use App\Models\User;
use App\Models\Bookings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard() {
        $spas = Spa::get();
        $services = Services::get();
        return view('client.dashboard',[
            'spas' => $spas,
            'services' => $services
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
        $therapists = User::where('spa_id',$spa_id)->get();
        return view('client.therapist',[
            'spa_id' => $spa_id,
            'service_id' => $service_id,
            'therapists' => $therapists
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
        return redirect(route('booking.history'));
    }

    public function bookingHistory(Request $request) {
        $user = Auth::user();
        $bookings = Bookings::select(
                        'bookings.id',
                        'spa.name as spa',
                        'services.name as services',
                        DB::raw("concat(users.fname,' ',users.lname) as therapist"),
                        'bookings.booking_type',
                        'bookings.start_date',
                        'bookings.start_time',
                        'bookings.amount_paid',
                        'bookings.status',
                        'bookings.payment_picture'
                    )
                    ->where('client_id',$user->id)
                    ->leftJoin('spa','spa.id','=','bookings.spa_id')
                    ->leftJoin('services','services.id','=','bookings.id')
                    ->leftJoin('users','users.id','=','bookings.therapist_id')
                    ->paginate(2);

        
        return view('client.booking_history',[
            'bookings' => $bookings
        ]);
    }
}
