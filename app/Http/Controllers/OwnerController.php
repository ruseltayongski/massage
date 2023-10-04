<?php

namespace App\Http\Controllers;

use App\Models\Spa;
use App\Models\User;
use App\Models\Contracts;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class OwnerController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function dashboard() {
        return view('owner.dashboard');
    }

    public function spa(Request $request) {
       /*  dd($request->all()); */
        $user = Auth::user();
        $query = Spa::where('owner_id', $user->id);
        $usersList = User::where('roles', 'THERAPIST')->where('owner_id', $user->id)->get();
      
  
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
        }
        $spas = $query->paginate(15);
     /*    dd($specificTherapist, \DB::getQueryLog()); */
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

        return response()->json($specificTherapists);
    }
    

    public function therapist() {
        $user = Auth::user();
        $therapists = User::where('roles','THERAPIST')->where('owner_id',$user->id)->paginate(15);
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
        $contract->status = 'Active';
        $contract->active_date = date('Y-m-d H:i:s');
        $contract->save();

        $user = User::find($user->id);
        $user->contract_type = $request->contract_type;
        $user->contract_end = $end_date;
        $user->save();

        session()->flash('contract_save', true);
        
        return true;
        #return response()->json(['message' => 'Signature uploaded and made transparent.']);
    }

    function calculateEndDate($startDate,$contract_type) {
        $startDateObj = date_create_from_format('m/d/Y', $startDate);
    
        if ($startDateObj === false) {
            return "Invalid start date format. Please use 'mm/dd/yyyy' format.";
        }
    
        $endDateObj = clone $startDateObj;
        if($contract_type == 'monthly') {
            $endDateObj->modify('+1 month');
        } else if($contract_type == 'yearly') {
            $endDateObj->modify('+13 month');
        }
    
        $nextMonth = date_format($endDateObj, 'm');
        $nextYear = date_format($endDateObj, 'Y');
    
        if ($nextMonth == '02' && $nextYear % 4 == 0 && ($nextYear % 100 != 0 || $nextYear % 400 == 0)) {
            $endDateObj->setDate($nextYear, 2, 29);
        } else {
            $endDateObj->setDate($nextYear, $nextMonth, 1);
        }
    
        return date_format($endDateObj, 'm/d/Y');
    }


    public function addSpa(Request $request) {
        $user = Auth::user();
        //check subscription
        $countSpa = Spa::where('owner_id',$user->id)->count();
        if($user->contract_type == 'monthly' && $countSpa > 5) {
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
                    $uploadPath = public_path('/fileupload/owner/picture/');
                    $spaImage->move($uploadPath, $spaFileName);
                    Image::Make($uploadPath . $spaFileName)
                    ->resize(255,340)->save(); 
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
                    $uploadPath = base_path() . '/public/fileupload/owner/picture/';
                    $spaImage->move($uploadPath, $spaFileName);

                    

                    Image::make($uploadPath . $spaFileName)
                          ->resize(255,340)->save();
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

            $user->save();
        }
        return redirect()->back();
    }
  
   /*  public function specificTherapist(Request $request) {
        dd($request->all());
        $spa_id = $request->input('id');
        $users = User::where('id', $spa_id)->get();
    
        // Now $users contains all users with the specified spa_id
    
        dd($users);

    } */

    
    public function clearSpaUpdateFlash() {
        session()->forget('spa_save');
        session()->forget('spa_update');
        return response()->json(['success' => true]);
    }
}
