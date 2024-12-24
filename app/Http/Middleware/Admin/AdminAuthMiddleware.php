<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    // Check if user is authenticated with either 'web' or 'patient' guard
    if (Auth::guard('patient')->check()) {
      return $next($request); // Proceed if 'patient' guard is authenticated
    }

    // If 'patient' guard isn't authenticated, check 'web' guard
    if (Auth::guard('web')->check()) {
      return redirect()->route('patient.login'); // Redirect to 'patient.login' if 'web' guard is authenticated but not 'patient'
    }

    // If neither guard is authenticated, redirect to login
    return redirect()->route('patient.login');
  }

}
