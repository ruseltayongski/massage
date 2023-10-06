<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bookings;
use App\Models\Spa;
use App\Models\Notifications;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TherapistController extends Controller
{
    public function therapistView() {
        $user = Auth::user();
        $therapists = User::where('roles', 'THERAPIST')->where('id', $user->id)->first();
        return view('therapist.dashboard', [
            "therapists" => $therapists
        ]);
    }

    public function addTherapist(Request $request) {
        $therapist_profile = $request->file('picture');
      
        if($therapist_profile) {
            $therapistFileName = 'therapist' .uniqid() . '.' . $therapist_profile->getClientOriginalExtension();
            $uploadPath = public_path('/fileupload/therapist/');
            $therapist_profile->move($uploadPath, $therapistFileName);

            Image::Make($uploadPath . $therapistFileName)
            ->resize(315,315)->save(); 
        }


        $user = new User();
        $user->owner_id = Auth::user()->id;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->address = $request->address;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->picture = $therapistFileName;
        $user->roles = "THERAPIST";
        $user->save();

        
        session()->flash('therapist_save', true);

       /*  $therapists = User::where('roles','THERAPIST')->where('owner_id',$user->id);
        return redirect('owner/therapist')->with([
            "therapists" => $therapists
        ]); */
        
        return redirect()->route('owner/therapist');
    }

    public function updateTherapist(Request $request) {
        
      /*   dd($request->all()); */
    
        if($request->has('id')) {
            $therapistId = $request->input('id');
            $user = User::find($therapistId);
            $user->fname = $request->input('fname');
            $user->lname = $request->input('lname');
            $user->address = $request->input('address');
            $user->mobile = $request->input('mobile');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
         

            if($request->hasFile('picture')) {
                $therapistProfile = $request->file('picture');
                $therapistFileName = 'therapist' .uniqid() . '.' . $therapistProfile->getClientOriginalExtension();
                $uploadPath = public_path('/fileupload/therapist/');
                $therapistProfile->move($uploadPath, $therapistFileName);
                
                Image::make($uploadPath . $therapistFileName)
                        ->resize(355,355)
                        ->save();

                if($user->picture != $therapistFileName) {
                    $old_picure = $uploadPath . $user->picture;

                    if(file_exists($old_picure)) {
                        unlink($old_picure);
                    }

                    
                    $user->picture = $therapistFileName;
                  
                }
               
            }
            session()->flash('therapist_update', true);
            $user->save(); 
        }  
        return redirect()->route('therapist/dashboard');
    }
    
    public function booking() {
        $user = Auth::user();
        $bookings = Bookings::select(
                        'bookings.id',
                        'spa.name as spa',
                        'services.name as services',
                        DB::raw("concat(users.fname,' ',users.lname) as client"),
                        'bookings.booking_type',
                        'bookings.start_date',
                        'bookings.start_time',
                        'bookings.amount_paid',
                        'bookings.status',
                        'bookings.payment_picture'
                    )
                    ->where('therapist_id',$user->id)
                    ->leftJoin('spa','spa.id','=','bookings.spa_id')
                    ->leftJoin('services','services.id','=','bookings.id')
                    ->leftJoin('users','users.id','=','bookings.client_id')
                    ->paginate(15);
        
        return view('therapist.booking',[
            'bookings' => $bookings
        ]);
    }

    public function updateBookingStatus(Request $request) {
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
        $notification->message = $booking->status.' you booking';
        $notification->save();

        session()->flash('booking_update_status', true);
        return redirect()->back();
    }
   
}
