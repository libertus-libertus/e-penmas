<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PatientRedirectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika pengguna sudah login dan memiliki role 'patient'
        if (Auth::check() && Auth::user()->role === 'patient') {
            // WAJIB: Alihkan pasien ke dashboard pasien khusus
            return redirect()->route('patient.dashboard');
        }
        return $next($request);
    }
}
