<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spa;
use App\Models\User;
use App\Models\Contracts;
use Illuminate\Support\Facades\Auth;

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
        
        #return response()->json(['message' => 'Signature uploaded and made transparent.']);
    }
}
