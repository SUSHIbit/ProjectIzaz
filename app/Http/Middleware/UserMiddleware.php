<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in to access this page.');
        }

        if (!Auth::user()->isUser()) {
            // If user is logged in but not a regular user (likely an admin), 
            // redirect to admin dashboard
            return redirect()->route('admin.dashboard')
                ->with('error', 'This area is for regular users only.');
        }

        return $next($request);
    }
}