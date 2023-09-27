<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spa;
use App\Models\Services;

class ClientController extends Controller
{
    public function dashboard() {
        $spas = Spa::get();
        $services = Services::get();
        #return base_path().'/public/fileupload/owner/profile/';
        return view('client.dashboard',[
            'spas' => $spas,
            'services' => $services
        ]);
    }
}
