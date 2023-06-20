<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // admin is_admin = 1
        // user is_admin = 0
        if (Auth::check()) {
            if (Auth::user()->is_admin == '1') {
                return $next($request);
            } else {
                return redirect('/')->with('message', 'Acesso negado!');
            }
        } else {
            return redirect('/login');
        }

        return $next($request);
    }
}
