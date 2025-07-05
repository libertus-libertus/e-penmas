<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PatientDetail; // Import PatientDetail model

class CheckPatientProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Pastikan pengguna adalah pasien
        if ($user && $user->role === 'patient') {
            $patientDetail = $user->patientDetail;

            // Cek kelengkapan profil (sesuai logika di PatientDashboardController)
            $isProfileComplete = false;
            if ($patientDetail) {
                $isProfileComplete = !empty($patientDetail->nik) &&
                                     !empty($patientDetail->address) &&
                                     !empty($patientDetail->birth_date) &&
                                     !empty($patientDetail->phone_number) &&
                                     !empty($patientDetail->gender) &&
                                     ($patientDetail->bpjs_status !== null);
            }

            if (!$isProfileComplete) {
                // Jika profil belum lengkap, alihkan ke halaman edit profil
                return redirect()->route('patient.profile.edit')->with('error', 'Mohon lengkapi profil Anda terlebih dahulu untuk mengakses fitur ini.');
            }
        }

        return $next($request);
    }
}
