<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Check if the route is /dashboard (default redirect after login)
            if ($request->is('dashboard')) {
                if (Auth::user()->isAdmin()) {
                    return redirect()->route('admin.dashboard');
                } elseif (Auth::user()->hasRole('lawyer')) {
                    return redirect()->route('lawyer.dashboard');
                } else {
                    return redirect()->route('user.dashboard');
                }
            }
        }

        return $next($request);
    }
}