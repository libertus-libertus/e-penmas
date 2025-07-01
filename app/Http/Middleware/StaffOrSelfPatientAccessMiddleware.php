<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PatientDetail; // Import PatientDetail model

class StaffOrSelfPatientAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Admin dan Staff selalu punya akses
            if ($user->role === 'admin' || $user->role === 'staff') {
                return $next($request);
            }

            // Jika role adalah 'patient', cek apakah mereka mencoba mengakses data mereka sendiri
            if ($user->role === 'patient') {
                // Ambil ID pasien dari rute (misal: patients/{patient} atau patient_details/{patient_detail})
                // Ini akan memerlukan Route Model Binding di rute itu sendiri atau di controller
                // Untuk kesederhanaan, kita bisa cek user_id dari PatientDetail di controller
                // Middleware ini hanya akan memastikan user adalah admin/staff/patient,
                // Logika "pasien hanya bisa edit/lihat dirinya sendiri" akan tetap di controller.

                // Jika rute saat ini adalah patient_details.show, patients.edit, atau patients.update,
                // dan memiliki parameter model PatientDetail
                if ($request->route()->hasParameter('patient')) { // Untuk patients/{patient}
                    $patientDetail = $request->route('patient');
                } elseif ($request->route()->hasParameter('patient_detail')) { // Untuk patient_details/{patient_detail}
                    $patientDetail = $request->route('patient_detail');
                } else {
                    // Jika tidak ada parameter model PatientDetail di rute,
                    // maka ini bukan rute yang relevan untuk otorisasi "self-patient".
                    // Biarkan request lewat ke controller untuk otorisasi lebih lanjut jika perlu.
                    return $next($request);
                }

                // Pastikan $patientDetail adalah instance PatientDetail
                if ($patientDetail instanceof PatientDetail && $user->id === $patientDetail->user_id) {
                    return $next($request);
                }
            }
        }

        // Jika tidak ada kondisi di atas yang terpenuhi, akses ditolak
        abort(403, 'Anda tidak memiliki hak akses untuk mengakses halaman ini.');
    }
}
