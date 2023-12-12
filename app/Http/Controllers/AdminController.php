<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Bookings;
use App\Models\Contracts;
use Illuminate\Http\Request;
use App\Models\Notifications;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(Request $request) {
        $startmonth_bar = $request->start_month_bar . '-01';
        $endmonth_bar = date('Y-m-t', strtotime($request->end_month_bar . '-01'));
        $profits = Contracts::
        select(DB::raw('MONTH(contracts.active_date) as month'), DB::raw('SUM(contracts.amount_paid) as total_profit'))
        ->where('contracts.status', '=', 'Approved')
        ->groupBy(DB::raw('MONTH(contracts.active_date)'));
        if($startmonth_bar && $endmonth_bar) {
            $profits = $profits->whereBetween('contracts.active_date', [$startmonth_bar, $endmonth_bar]);
        }
        Session::put("start_month_bar",$startmonth_bar);
        Session::put("end_month_bar",$endmonth_bar);
        $profits = $profits->get();

        $barchart = [];
        $barchart_grandtotal = 0;
        for ($month = 1; $month <= 12; $month++) {
            $label = date('M', mktime(0, 0, 0, $month, 1));
            $totalProfit = 0;

            $foundMonth = $profits->firstWhere('month', $month);
            if ($foundMonth) {
                $totalProfit = $foundMonth->total_profit;
            }

            $barchart[] = ['label' => $label, 'y' => (float)$totalProfit];
            $barchart_grandtotal += (float)$totalProfit;
        }

        $bookings = Bookings::groupBy('status')
        ->select('status', DB::raw('count(*) as count'))
        ->get();
        $contractsCount = Contracts::select(
                        DB::raw('SUM(CASE WHEN type = "weekly" THEN 1 ELSE 0 END) AS Weekly'),
                        DB::raw('SUM(CASE WHEN type = "yearly" THEN 1 ELSE 0 END) AS Yearly'),
                        DB::raw('SUM(CASE WHEN type = "monthly" THEN 1 ELSE 0 END) AS Monthly'),
                        DB::raw('SUM(1) AS Total'),
                    )->get();

        foreach($bookings as $booking) {
            $result[$booking->status] = $booking->count;
        }

        $contracts = Contracts::groupBy('type')
        ->select('type', DB::raw('count(*) as count'))
        ->get();
        
        foreach($contracts as $contract) {
            $resultContracts[$contract->type] = $contract->count;
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

        $date1 = date('Y-m-d', strtotime(Carbon::now()));
        $date2 = date('Y-m-d', strtotime(Carbon::now()->subDays(22)));
        
        $linechart = DB::table(DB::raw("(SELECT date(bookings.start_date) as date, count(distinct bookings.id) as value
                FROM massage.bookings
                WHERE bookings.start_date BETWEEN '$date2' AND '$date1'
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
                WHERE date BETWEEN '$date2' AND '$date1'
                GROUP BY date) t"))
                ->groupBy('date')
                ->select('date', DB::raw('SUM(value) as value'))
                ->get();
        

        return view('admin.dashboard',[
            "bookings" => isset($result) ? $result : [],
            "contracts" => isset($resultContracts) ? $resultContracts : [],
            "booking_history" => $booking_history,
            "linechart" => $linechart,
            "contractsCount" => $contractsCount,
            "barchart" => $barchart,
            "barchart_grandtotal" => $barchart_grandtotal,
            "start_month_bar" => $request->start_month_bar,
            "end_month_bar" => $request->end_month_bar
        ]);
    }

    public function exportBarchartProfit(Request $request) {
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=barchart_export_profit_contracts.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        $contracts = Contracts::
            select(
                'contracts.active_date', 
                'contracts.start_date',
                'contracts.end_date',
                DB::raw("concat(users.fname,' ',users.lname) as customer_name"),
                'contracts.type as contract_type',
                'contracts.amount_paid'
            )
            ->where('contracts.status','=','Approved')
            ->join('users','users.id','=','contracts.owner_id')
            ->orderBy('contracts.active_date','desc');

        $startmonth_bar = Session::get("start_month_bar");
        $endmonth_bar = Session::get("end_month_bar");        
        if($startmonth_bar && $endmonth_bar) {
            $contracts = $contracts->whereBetween('contracts.active_date', [$startmonth_bar, $endmonth_bar]);
        }        
        $contracts = $contracts->get();

        return view('admin.barchart_export_profit',[
            'contracts' => $contracts
        ]);
    }

    public function ownerProfile() {
        $user = Auth::user();
        $adminDetails = User::where('roles', 'ADMIN')
                             ->where('id', $user->id)
                             ->first();
        return view('admin.profile', [
            "adminDetails" => $adminDetails,
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
            
            if($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }
         

            if($request->hasFile('picture')) {
                $userProfile = $request->file('picture');
                $userFileName = 'picture' .uniqid() . '.' . $userProfile->getClientOriginalExtension();
                $uploadPath = public_path('/fileupload/admin/profile/');
                $userProfile->move($uploadPath, $userFileName);
                
                Image::make($uploadPath . $userFileName)
                        ->resize(255,366)
                        ->save();

                $user->picture = $userFileName;
 
            }
            session()->flash('admin_profile_update', true);
            $user->save(); 
        }  
        return redirect()->back();

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
