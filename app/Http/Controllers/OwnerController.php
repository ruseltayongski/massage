<?php

namespace App\Http\Controllers;

use PDF;
use Exception;
use App\Models\Spa;
use App\Models\User;
use App\Models\Bookings;
use App\Models\Contracts;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class OwnerController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function dashboard() {
        $user = Auth::user();
        $bookings = Bookings::groupBy('bookings.status')
        ->select('bookings.status', DB::raw('count(bookings.id) as count'))
        ->join('users','users.id','=','bookings.therapist_id')
        ->where('users.owner_id','=',$user->id)
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
        ->where('therapist.owner_id','=',$user->id)
        ->orderBy('bookings.updated_at','desc')
        ->paginate(4);

        $date_start_future = date('Y-m-d', strtotime(Carbon::now()));
        $date_end_future = date('Y-m-d', strtotime(Carbon::now()->addDays(22)));
        
        $linechart = DB::table(DB::raw("(SELECT date(bookings.start_date) as date, count(distinct bookings.id) as value
                FROM massage.bookings
                JOIN users on users.id = bookings.therapist_id
                WHERE bookings.start_date BETWEEN '$date_start_future' AND '$date_end_future'
                AND users.owner_id = '$user->id'
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
        

        return view('owner.dashboard',[
            "bookings" => isset($result) ? $result : [],
            "booking_history" => $booking_history,
            "linechart" => $linechart
        ]);
    }

    public function dashboard1() {
        $user = Auth::user();
        $completedCount = Bookings::whereHas('ownerWithSpecificTherapist', function ($query) use ($user) {
            $query->where('users.owner_id', $user->id);
        })->where('status', 'completed')->count();
        $cancelCount = Bookings::whereHas('ownerWithSpecificTherapist', function ($query) use ($user) {
            $query->where('users.owner_id', $user->id);
        })->where('status', 'cancel')->count();

     
        $list = User::where('roles', 'OWNER')
                     ->where('id', $user->id)
                     ->withCount('spas', 'services', 'therapist')
                     ->get();

       /*  dd($list->toJson()); */
        return view('owner.dashboard', [
            "user" => $user,
            "list" => $list,
            "completedCount" => $completedCount,
            "cancelCount" => $cancelCount
        ]);
    }

    public function spa(Request $request) {
        $user = Auth::user();
        $query = Spa::where('owner_id', $user->id);
        $usersList = User::where('roles', 'THERAPIST')->where('owner_id', $user->id)->get();
      
        if ($request->has('reset_button')) {
            return redirect()->route('owner/spa');
        }
  
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
        }
        $spas = $query->paginate(15);
    
        return view('owner.spa', [
            "spas" => $spas,
            "usersList" => $usersList
        ]);
    }
    
    public function getTherapists(Request $request) {
        $user = Auth::user();
        $spaId = $request->input('spa_id');
    
        $specificTherapists = User::where('roles', 'THERAPIST')
            ->where('owner_id', $user->id)
            ->where('spa_id', $spaId)
            ->get();
    
      /*   return response()->json([
            'data' => $specificTherapists->items(),
        ]); */

        return response()->json($specificTherapists);   
    }
    

    public function therapist(Request $request) {
        $user = Auth::user();
        $query = User::where('roles','THERAPIST')->where('owner_id',$user->id);

        if($request->has('reset_button')) {
            return redirect()->route('owner/therapist');
        }

        if($request->has('search')) {
            $search = $request->input('search');
            $query->where('fname', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
        }

       
        
        $therapists = $query->paginate(15);

        return view('owner.therapist',[
            "therapists" => $therapists
        ]);
    }

    public function contract() {
        $user = Auth::user();
        $contracts = Contracts::where('owner_id',$user->id)->paginate(15);
        return view('owner.contract',[
            'contracts' => $contracts
        ]);
    }

    public function contractSave(Request $request) {
        $user = Auth::user();
        //amountPicture
        $amountImage = $request->file('amount_picture');
        $amountFileName = 'payment'.uniqid() . '.' . $amountImage->getClientOriginalExtension();
        $amountImage->move(base_path().'/public/fileupload/owner/payment/', $amountFileName);

        //signature
        $imageData = $request->signature; 
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = base64_decode($imageData);
        $signatureFileName = 'signature_' . uniqid() . '.png';
        $signaturePath = '/fileupload/owner/signature/'.$signatureFileName;
        file_put_contents(base_path().'/public'.$signaturePath, $imageData);

        $start_date = date('m/d/Y');
        $end_date = $this->calculateEndDate($start_date,$request->contract_type);
        $end_date = date('Y-m-d',strtotime($end_date));
        $contract = new Contracts();
        $contract->owner_id = $user->id;
        $contract->start_date = date('Y-m-d',strtotime($start_date));
        $contract->end_date = $end_date;
        $contract->type = $request->contract_type;
        $contract->amount_paid = $request->amount_paid;
        $contract->payment_proof = $amountFileName;
        $contract->owner_signature = $signatureFileName;
        $contract->status = 'Pending';
        $contract->active_date = date('Y-m-d H:i:s');
        $contract->save();

        $user = User::find($user->id);
        $user->status = 'Pending';
        $user->contract_type = $request->contract_type;
        $user->contract_end = $end_date;
        $user->save();

        
        $notification = new Notifications();
        $notification->contract_owner = $user->id;
        $notification->notifier_id = $user->id;                       
        $notification->message = ' was signed a contract';
        $notification->save();

        session()->flash('contract_save', true);
        return true;
        #return response()->json(['message' => 'Signature uploaded and made transparent.']);
    }

    function calculateEndDate($startDate, $contract_type) {
        $startDateObj = date_create_from_format('m/d/Y', $startDate);
    
        if ($startDateObj === false) {
            return "Invalid start date format. Please use 'mm/dd/yyyy' format.";
        }

        $endDateObj = clone $startDateObj;
        if ($contract_type == 'weekly') {
            $endDateObj->modify('next ' . date_format($startDateObj, 'l'));
        } else if ($contract_type == 'monthly') {
            $endDateObj->setDate(date_format($startDateObj, 'Y'), date_format($startDateObj, 'm') + 1, date_format($startDateObj, 'd'));
        } else if ($contract_type == 'yearly') {
            $endDateObj->setDate(date_format($startDateObj, 'Y') + 1, date_format($startDateObj, 'm'), date_format($startDateObj, 'd'));
        }
    
        return date_format($endDateObj, 'm/d/Y');
    }


    public function addSpa(Request $request) {
        $user = Auth::user();
        $countSpa = Spa::where('owner_id',$user->id)->count();
        if($user->contract_type == 'weekly' && $countSpa >= 1) {
            session()->flash('insuficient_spa', true);
            return redirect()->back();
        }
        else if($user->contract_type == 'monthly' && $countSpa >= 5) {
            session()->flash('insuficient_spa', true);
            return redirect()->back();
        }
        else if($user->contract_type == 'yearly' && $countSpa > 20) {
            session()->flash('insuficient_spa', true);
            return redirect()->back();
        }
        
        try {
            $spaImage = $request->file('picture');

            if ($spaImage) {
                try {
                    $spaFileName = 'picture' . uniqid() . '.' . $spaImage->getClientOriginalExtension();         
                    $uploadPath = public_path('/fileupload/spa/');
                    $spaImage->move($uploadPath, $spaFileName);
                    Image::Make($uploadPath . $spaFileName)
                    ->resize(255,366)->save(); 
                } catch (Exception $ex) {
                    // Handle exception if needed
                    dd($ex->getMessage());
                }
            }
            // Create and save the Spa model
            $spa = new Spa();
            $spa->owner_id = $user->id;
            $spa->name = $request->name;
            $spa->description = $request->description;
            $spa->picture = $spaFileName;
            $spa->save();
    
            session()->flash('spa_save', true);

            return redirect()->back();
        } catch (\Exception $e) {
            // Handle exceptions
        }
    }


    public function updateSpa(Request $request) {
        try {
            if ($request->has('id')) {
                $spaId = $request->input('id');
                $spa = Spa::find($spaId);
                $spa->name = $request->input('name');
                $spa->description = $request->input('description');
    
                if ($request->hasFile('picture')) {
                    $spaImage = $request->file('picture');
                    $spaFileName = 'picture' . uniqid() . '.' . $spaImage->getClientOriginalExtension();
                    $uploadPath = public_path() . '/fileupload/spa/';
                    $spaImage->move($uploadPath, $spaFileName);

                    

                    Image::make($uploadPath . $spaFileName)
                          ->resize(255,366)->save();
                    // Check if the new picture is different from the existing one
                    if ($spa->picture != $spaFileName) {
                        // Delete the old picture
                        $oldPicturePath = $uploadPath . $spa->picture;
                        if (file_exists($oldPicturePath)) {
                            unlink($oldPicturePath);
                        }
    
                        // Set the new picture
                        $spa->picture = $spaFileName;
                    
                    }
                }
                session()->flash('spa_update', true);
                $spa->save();
                
                return redirect()->back();
            }
    
        } catch (\Exception $e) {
            // Handle exceptions
        }
    }


    public function assignTherapist(Request $request) {
     
       /*  dd($request->all()); */
        if ($request->has('id') && $request->has('therapist_id')) {
            $spa_id = $request->input('id');
            $therapist_id = $request->input('therapist_id');
            $user = User::find($therapist_id);
            $user->spa_id = $spa_id;

            session()->flash('assign_therapist', true);
            $user->save();
        }
        return redirect()->back();
    }
  
    public function ownerProfile() {
        $user = Auth::user();
        $userProfile = User::where('roles', 'OWNER')
                            ->where('id', $user->id)
                            ->first();

        return view('owner.profile', [
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
            
            if($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }
         

            if($request->hasFile('picture')) {
                $userProfile = $request->file('picture');
                $userFileName = 'picture' .uniqid() . '.' . $userProfile->getClientOriginalExtension();
                $uploadPath = public_path('/fileupload/owner/profile/');
                $userProfile->move($uploadPath, $userFileName);
                
                Image::make($uploadPath . $userFileName)
                        ->resize(255,366)
                        ->save();

                $user->picture = $userFileName;
 
            }
            session()->flash('profile_update', true);
            $user->save(); 
        }  
        return redirect()->back();

    }

    public function transactionsView() {
        $user = Auth::user();
    
        $transactions = Bookings::select(
                        'bookings.id',
                        'spa.name as spa_name',
                        'services.name as services_name',
                        DB::raw("concat(therapist.fname, ' ', therapist.lname) as therapist_name"),
                        DB::raw("concat(client.fname, ' ', client.lname) as client_name"),
                        'bookings.status',
                        'bookings.approved_date',
                        'bookings.start_date'
                        )               
                        ->whereHas('ownerWithSpecificTherapist', function ($query) use ($user) {
                            // Add a condition to ensure only the authenticated user's bookings are retrieved
                            $query->where('users.owner_id', $user->id);
                        })
                       ->leftJoin('spa', 'spa.id', '=', 'bookings.spa_id')
                       ->leftJoin('services', 'services.id', '=', 'bookings.service_id')
                       ->leftJoin('users as therapist', 'therapist.id', '=', 'bookings.therapist_id')
                       ->leftJoin('users as client', 'client.id', '=', 'bookings.client_id')
                     
                       ->get();
    
   /*      dd($transactions); */
        return view('owner.transactions', [
            "transactions" => $transactions
        ]);
    }
    
    
    
    public function clearSpaUpdateFlash() {
        session()->forget('spa_save');
        session()->forget('spa_update');
        return response()->json(['success' => true]);
    }
}
