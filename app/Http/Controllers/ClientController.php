<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spa;
use App\Models\Services;
use App\Models\User;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard() {
        $spas = Spa::get();
        $services = Services::get();
        return view('client.dashboard',[
            'spas' => $spas,
            'services' => $services
        ]);
    }

    public function services(Request $request) {
        $spa_id = $request->spa;
        $services = Services::where('spa_id',$spa_id)->get();
        return view('client.services',[
            'spa_id' => $spa_id,
            'services' => $services
        ]);
    }

    public function therapist(Request $request) {
        $spa_id = $request->spa;
        $service_id = $request->service;
        $therapists = User::where('spa_id',$spa_id)->get();
        return view('client.therapist',[
            'spa_id' => $spa_id,
            'service_id' => $service_id,
            'therapists' => $therapists
        ]);
    }

    public function booking(Request $request) {
        $spa_id = $request->spa;
        $service_id = $request->service;
        $therapist_id = $request->therapist;
        return view('client.booking',[
            'spa_id' => $spa_id,
            'service_id' => $service_id,
            'therapist_id' => $therapist_id
        ]);
    }
}
