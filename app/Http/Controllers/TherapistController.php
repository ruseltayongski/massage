<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class TherapistController extends Controller
{
    public function therapistView() {
        $user = Auth::user();
        $therapists = User::where('roles', 'THERAPIST')->where('id', $user->id)->first();
        return view('therapist.dashboard', [
            "therapists" => $therapists
        ]);
    }

    public function therapist() {
        $user = Auth::user();
        $therapists = User::where('roles','THERAPIST')->where('owner_id',$user->id)->paginate(15);
        return view('owner.therapist',[
            "therapists" => $therapists
        ]);
    }
    public function addTherapist(Request $request) {
        $therapist_profile = $request->file('picture');
      
        if($therapist_profile) {
            $therapistFileName = 'therapist' .uniqid() . '.' . $therapist_profile->getClientOriginalExtension();
            $uploadPath = public_path('/fileupload/owner/therapist/');
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
}
