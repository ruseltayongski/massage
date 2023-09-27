<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard() {
        
        return view('admin.dashboard');
    }

    public function owner() {
        $users = User::where('roles','OWNER')->paginate(15);
        return view('admin.owner',[
            'users' => $users
        ]);
    }
}
