<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PatientDetail;
use App\Models\Registration;
use App\Models\PatientVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PatientDashboardController extends Controller
{
    /**
     * Display the patient's dashboard.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user();

        // Pastikan user adalah pasien (ini sudah ditangani oleh middleware role.patient)
        if (!$user || $user->role !== 'patient') {
            abort(403, 'Akses tidak diizinkan.');
        }

        // Muat patientDetail untuk user yang sedang login
        $user->load('patientDetail');
        $patientDetail = $user->patientDetail;

        // Cek apakah data detail pasien sudah lengkap
        $isProfileComplete = $this->checkPatientProfileComplete($patientDetail);

        // Ambil data aktivitas pasien HANYA jika patientDetail tidak null
        $upcomingRegistrations = collect(); // Default to empty collection
        $recentVisits = collect(); // Default to empty collection

        if ($patientDetail) {
            $upcomingRegistrations = Registration::where('patient_detail_id', $patientDetail->id)
                                                ->where('visit_date', '>=', today())
                                                ->whereHas('queue', function($query) {
                                                    $query->whereIn('status', ['waiting', 'called']);
                                                })
                                                ->orderBy('visit_date', 'asc')
                                                ->orderBy('queue_number', 'asc')
                                                ->limit(5)
                                                ->get();

            $recentVisits = PatientVisit::where('patient_detail_id', $patientDetail->id)
                                        ->latest('visit_date')
                                        ->limit(5)
                                        ->get();
        }

        return view('patient_dashboard.index', compact('user', 'patientDetail', 'isProfileComplete', 'upcomingRegistrations', 'recentVisits'));
    }

    /**
     * Check if patient's demographic data is complete.
     *
     * @param PatientDetail|null $patientDetail
     * @return bool
     */
    private function checkPatientProfileComplete(?PatientDetail $patientDetail): bool
    {
        if (!$patientDetail) {
            return false; // No patient detail record, so profile is not complete
        }

        // Define required fields for a complete profile
        // Sesuaikan dengan kolom yang Anda anggap wajib di patient_details
        return !empty($patientDetail->nik) &&
               !empty($patientDetail->address) &&
               !empty($patientDetail->birth_date) &&
               !empty($patientDetail->phone_number) &&
               !empty($patientDetail->gender) &&
               ($patientDetail->bpjs_status !== null); // bpjs_status bisa true/false
    }
}
