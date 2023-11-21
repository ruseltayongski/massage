<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


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

    // protected function credentials(Request $request)
    // {
    //     $credentials = $request->only($this->username(), 'password');
    //     $credentials['is_deleted'] = 0; // Check if the user is not deleted

    //     return $credentials;
    // }

    protected function authenticated(Request $request, $user)
    {
        if ($user->is_deleted == 1) {
            auth()->logout(); // Log the user out
            throw ValidationException::withMessages([
                $this->username() => 'Your account has been deactivated.',
            ]);
        }

        if (auth()->user()->roles == 'ADMIN') {
            $route = RouteServiceProvider::ADMIN;
        } elseif (auth()->user()->roles == 'OWNER') {
            $route = RouteServiceProvider::OWNER;
        } elseif (auth()->user()->roles == 'THERAPIST') {
            $route = RouteServiceProvider::THERAPIST;
        } elseif (auth()->user()->roles == 'CLIENT') {
            $route = RouteServiceProvider::CLIENT;
        }
        return redirect($route);
        //return redirect()->intended($this->redirectPath());
    }

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
