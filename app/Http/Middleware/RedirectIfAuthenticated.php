<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        //return response()->json($request, 400);
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (auth()->user()->roles == 'ADMIN') {
                    return redirect(RouteServiceProvider::ADMIN);
                } elseif (auth()->user()->roles == 'OWNER') {
                    return redirect(RouteServiceProvider::OWNER);
                } elseif (auth()->user()->roles == 'THERAPIST') {
                    return redirect(RouteServiceProvider::THERAPIST);
                } elseif (auth()->user()->roles == 'CLIENT') {
                    return redirect(RouteServiceProvider::CLIENT);
                }
                //return redirect(RouteServiceProvider::HOME);
                // $user = Auth::guard($guard)->user();
                // if ($user->roles == 'admin') {
                //     return redirect(RouteServiceProvider::ADMIN);
                // } else if($user->roles == 'spa_owner') {
                //     return redirect(RouteServiceProvider::HOME);
                // }
            }
        }

        return $next($request);
    }
}
