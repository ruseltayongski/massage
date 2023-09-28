<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spa;
use App\Models\User;
use App\Models\Contracts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class OwnerController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function dashboard() {
        return view('owner.dashboard');
    }

    public function spa() {
        $user = Auth::user();
        $spas = Spa::where('owner_id',$user->id)->paginate(15);
        return view('owner.spa',[
            "spas" => $spas
        ]);
    }

    public function contractSave(Request $request) {
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

        $contract = new Contracts();
        $contract->owner_id = Auth::user()->id;
        $contract->type = $request->contract_type;
        $contract->amount_paid = $request->amount_paid;
        $contract->amount_picture = $amountFileName;
        $contract->spa_owner_signature = $signatureFileName;
        $contract->save();

        session()->flash('contract_save', true);
        
        return true;
        #return response()->json(['message' => 'Signature uploaded and made transparent.']);
    }

    public function addSpa(Request $request) {
        try {
            if ($request->hasFile('picture')) {
                // File exists in the request
                $spaImage = $request->file('picture');
                $spaFileName = 'picture' . uniqid() . '.' . $spaImage->getClientOriginalExtension();
                $spaImage->move(base_path() . '/public/fileupload/owner/picture/', $spaFileName);
    
                $spa = new Spa();
                $spa->owner_id = Auth::user()->id;
                $spa->name = $request->name;
                $spa->description = $request->description;
                $spa->picture = $spaFileName;
                $spa->save();
                
                $user = Auth::user();
                $spas = Spa::where('owner_id',$user->id)->paginate(15);
                return view('owner.spa',[
                    "spas" => $spas
                ]);
                // Return a JSON response indicating success
               /*  return response()->json(['message' => 'Spa added successfully'], Response::HTTP_CREATED); */
            } else {
              /*   return response()->json(['error' => 'No file uploaded'], Response::HTTP_BAD_REQUEST); */
            }
        } catch (\Exception $e) {
            // Handle any exceptions and return an error JSON response
           /*  return response()->json(['error' => 'Failed to add spa'], Response::HTTP_INTERNAL_SERVER_ERROR); */
        }
    }
    
}