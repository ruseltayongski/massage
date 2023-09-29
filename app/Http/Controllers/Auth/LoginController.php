<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = auth()->user()->roles == 'admin' ? RouteServiceProvider::ADMIN : RouteServiceProvider::HOME;
    protected function redirectTo()
    {
        if (auth()->user()->roles == 'ADMIN') {
            return RouteServiceProvider::ADMIN;
        } elseif (auth()->user()->roles == 'OWNER') {
            return RouteServiceProvider::OWNER;
        } elseif (auth()->user()->roles == 'THERAPIST') {
            return RouteServiceProvider::THERAPIST;
        } elseif (auth()->user()->roles == 'CLIENT') {
            return RouteServiceProvider::CLIENT;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
