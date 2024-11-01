<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated and if the role is 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Allow the request to proceed
        }

        // If the user is not an admin, redirect or return an error
        return redirect('search')->with('error', 'You do not have admin access.');
    }
}
