<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spa;
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
}
