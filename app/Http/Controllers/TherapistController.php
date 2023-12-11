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
use Carbon\Carbon;

class TherapistController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function therapistDasboardMain() {
        $user = Auth::user();
        $bookings = Bookings::groupBy('bookings.status')
        ->select('bookings.status', DB::raw('count(bookings.id) as count'))
        ->join('users','users.id','=','bookings.therapist_id')
        ->where('users.id','=',$user->id)
        ->get();

        foreach($bookings as $booking) {
            $result[$booking->status] = $booking->count;
        }

        $booking_history = Bookings::select(
            DB::raw("concat(users.fname,' ',users.lname) as client_name"),
            'users.picture as client_picture',
            'bookings.amount_paid',
            'spa.name as spa_name',
            'services.name as services',
            'bookings.start_date',
            'bookings.status'
        )
        ->leftJoin('spa','spa.id','=','bookings.spa_id')
        ->leftJoin('services','services.id','=','bookings.service_id')
        ->leftJoin('users','users.id','=','bookings.client_id')
        ->join('users as therapist','therapist.id','=','bookings.therapist_id')
        ->where('therapist.id','=',$user->id)
        ->orderBy('bookings.updated_at','desc')
        ->paginate(4);

        $date_start_future = date('Y-m-d', strtotime(Carbon::now()));
        $date_end_future = date('Y-m-d', strtotime(Carbon::now()->addDays(22)));
        
        $linechart = DB::table(DB::raw("(SELECT date(bookings.start_date) as date, count(distinct bookings.id) as value
                FROM massage.bookings
                JOIN users on users.id = bookings.therapist_id
                WHERE bookings.start_date BETWEEN '$date_start_future' AND '$date_end_future'
                AND users.id = '$user->id'
                GROUP BY date(bookings.start_date)

                UNION

                SELECT date, 0 as value 
                FROM (
                    SELECT ADDDATE('1970-01-01', t4*10000 + t3*1000 + t2*100 + t1*10 + t0) as date 
                    FROM (
                        SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
                    ) t0,
                    (
                        SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
                    ) t1,
                    (
                        SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
                    ) t2,
                    (
                        SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
                    ) t3,
                    (
                        SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
                    ) t4
                ) v 
                WHERE date BETWEEN '$date_start_future' AND '$date_end_future'
                GROUP BY date) t"))
                ->groupBy('date')
                ->select('date', DB::raw('SUM(value) as value'))
                ->get();
        

        return view('therapist.dashboard_main',[
            "bookings" => isset($result) ? $result : [],
            "booking_history" => $booking_history,
            "linechart" => $linechart
        ]);
    }

    public function therapistView() {
        $user = Auth::user();
        $therapists = User::where('roles', 'THERAPIST')->where('id', $user->id)->first();
        return view('therapist.profile', [
            "therapists" => $therapists
        ]);
    }

    public function addTherapist(Request $request) {
       $validateData = Validator::make($request->all(),[
            'fname' => ['required', 'string', 'max:255'],
           /*  'lname' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], */
           /*  'password' => ['required', 'string', 'min:8', 'confirmed'], */
       ])/* ->validate() */;

       if($validateData->fails()) {
            session()->flash('error_save', true);
            return redirect()->back();
       } else {
        
        $therapist_profile = $request->file('picture');
      
        if($therapist_profile) {
            $therapistFileName = 'therapist' .uniqid() . '.' . $therapist_profile->getClientOriginalExtension();
            $uploadPath = public_path('/fileupload/therapist/profile/');
            $therapist_profile->move($uploadPath, $therapistFileName);

            Image::Make($uploadPath . $therapistFileName)
            ->resize(255,366)->save(); 
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
            $user->is_deleted = 0;
            $user->save();

            
            session()->flash('therapist_save', true);
            return redirect()->back();
        }
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
            
            if($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }
         

            if($request->hasFile('picture')) {
                $therapistProfile = $request->file('picture');
                $therapistFileName = 'therapist' .uniqid() . '.' . $therapistProfile->getClientOriginalExtension();
                $uploadPath = public_path('/fileupload/therapist/profile/');
                $therapistProfile->move($uploadPath, $therapistFileName);
                
                Image::make($uploadPath . $therapistFileName)
                        ->resize(255,366)
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
    
    public function booking(Request $request) {
        $user = Auth::user();
        if($request->has('reset_button')) {
            return redirect()->route('therapist.booking');
        }
        $query = Bookings::select(
                        'bookings.id',
                        'spa.name as spa',
                        'services.name as services',
                        DB::raw("concat(users.fname,' ',users.lname) as client"),
                        'bookings.booking_type',
                        'bookings.start_date',
                        'bookings.start_time',
                        'bookings.amount_paid',
                        'bookings.status',
                        'bookings.payment_picture',
                        'bookings.client_no',
                        'bookings.client_location',
                        'bookings.landmark'
                    )
                    ->where('therapist_id',$user->id)
                    ->leftJoin('spa','spa.id','=','bookings.spa_id')
                    ->leftJoin('services','services.id','=','bookings.id')
                    ->leftJoin('users','users.id','=','bookings.client_id');

                    if($request->has('search')) {
                        $search = $request->input('search');
                        $query->where('users.fname', 'like', "%$search%")
                               ->orWhere('users.lname', 'like', "%$search%")
                               ->orWhere('spa.name', 'like', "%$search%");
                    }
        $bookings = $query->paginate(15);
        
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

        $therapist = User::find($booking->therapist_id);
        $therapist->booking_status = $booking->status;
        $therapist->save();

        $notification = new Notifications();
        $notification->booking_id = $booking->id;
        $notification->booked_by = $booking->client_id;
        $notification->notifier_id = $user->id;                       
        if($booking->status !== 'Rejected') {
            $notification->message = $booking->status.' your booking';
        } else {
            $notification->message = $booking->status.' your booking,'.'   '.' Reason: '.$request->message;
        }
        $notification->save();

        session()->flash('booking_update_status', true);
        return redirect()->back();
    }
   

    public function bookingHistory(Request $request) {
        $user = Auth::user();
        $query = Bookings::select(
                        'bookings.id',
                        'spa.id as spa_id',
                        'spa.name as spa_name',
                        'services.name as services',
                        DB::raw("concat(users.fname,' ',users.lname) as client"),
                        'bookings.booking_type',
                        'bookings.start_date',
                        'bookings.start_time',
                        'bookings.amount_paid',
                        'bookings.status',
                        'bookings.payment_picture',
                    )
                    ->where('therapist_id',$user->id)
                    ->leftJoin('spa','spa.id','=','bookings.spa_id')
                    ->leftJoin('services','services.id','=','bookings.service_id')
                    ->leftJoin('users','users.id','=','bookings.client_id');

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
                    $bookings = $query->orderBy('bookings.id','desc')
                                ->paginate(15);
        return view('therapist.booking_history', [
            "bookings" => $bookings,
        ]);
    }
}
