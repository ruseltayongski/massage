<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function dashboard() {
        return base_path().'/public/fileupload/owner/profile/';
        return view('client.dashboard');
    }
}
