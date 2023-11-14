<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contracts;
use App\Models\Bookings;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard() {
        $bookings = Bookings::groupBy('status')
        ->select('status', DB::raw('count(*) as count'))
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
        ->orderBy('bookings.updated_at','desc')
        ->paginate(4);

        $date_start_future = date('Y-m-d', strtotime(Carbon::now()));
        $date_end_future = date('Y-m-d', strtotime(Carbon::now()->addDays(22)));
        
        $linechart = DB::table(DB::raw("(SELECT date(bookings.start_date) as date, sum(bookings.amount_paid) as value
                FROM massage.bookings
                WHERE bookings.start_date BETWEEN '$date_start_future' AND '$date_end_future'
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
        

        return view('admin.dashboard',[
            "bookings" => $result,
            "booking_history" => $booking_history,
            "linechart" => $linechart
        ]);
    }

    public function owner() {
        $ownerContracts = User::select(
                            'users.id',
                            'contracts.payment_proof as payment_proof',
                            DB::raw("concat(users.fname,' ',users.lname) as username"),
                            'users.mobile',
                            'users.picture',
                            'users.status',
                            'users.contract_type',
                            'users.is_deleted'
                        )
                        ->withCount('spas', 'therapist')
                        ->where('roles', 'OWNER')
                        ->leftJoin('contracts', 'contracts.owner_id', '=', 'users.id')
                        ->paginate(15);
        return view('admin.owner',[
            'ownerContracts' => $ownerContracts,
        ]);
    }

    public function updateOwnerStatus(Request $request) {
        $user = User::find($request->user_id);
        $user->status = $request->contract_status;
        $user->save();

        $contracts = Contracts::where('owner_id', $user->id)->first();
        if($contracts) {
            $contracts->status = $request->contract_status;
            $contracts->save();
        }

        $notification = new Notifications();
        $notification->contract_owner = $user->id;
        $notification->notifier_id = Auth::user()->id; //admin account                
        $notification->message = $request->contract_status.' your contract';
        $notification->save();
        
        session()->flash('owner_status', true);
        return redirect()->back();
    }
}
