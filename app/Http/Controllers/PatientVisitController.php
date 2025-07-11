<?php

namespace App\Http\Controllers;

use App\Models\PatientVisit;
use App\Models\PatientDetail; // To filter by patient
use App\Models\Service;      // To filter by service
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth; // WAJIB: Import Auth facade

class PatientVisitController extends Controller
{
    /**
     * Display a listing of the patient visits.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = PatientVisit::with(['patientDetail.user', 'service']);

        // Filter by patient
        if ($request->filled('patient_id')) {
            $query->where('patient_detail_id', $request->patient_id);
        }

        // Filter by service
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        // Filter by status (e.g., 'completed', 'canceled')
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by visit date
        if ($request->filled('visit_date')) {
            $query->whereDate('visit_date', $request->visit_date);
        }

        $patientVisits = $query->latest('visit_date')->get(); // Order by most recent visit date

        // Data for filters dropdowns
        $patientDetails = PatientDetail::with('user')->get();
        $services = Service::all();

        return view('patient_visits.index', compact('patientVisits', 'patientDetails', 'services'));
    }

    /**
     * Display the specified patient visit.
     * Digunakan oleh Admin/Staff (untuk semua riwayat) dan Pasien (untuk riwayat sendiri).
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $patientVisit = PatientVisit::with(['patientDetail.user', 'service'])->findOrFail($id);

        // Otorisasi: Admin/Staff bisa lihat semua. Pasien hanya bisa lihat riwayatnya sendiri.
        if (Auth::user()->role === 'patient') {
            if (Auth::id() !== ($patientVisit->patientDetail->user_id ?? null)) {
                abort(403, 'Anda tidak memiliki akses untuk melihat riwayat kunjungan pasien lain.');
            }
            // Jika pasien melihat riwayatnya sendiri, gunakan view khusus pasien
            return view('patient_dashboard.visit_detail', compact('patientVisit'));
        }

        // Jika Admin/Staff, gunakan view umum
        return view('patient_visits.show', compact('patientVisit'));
    }

    /**
     * Show the form for editing the specified patient visit's status.
     * This is only for updating the *status* of the visit, not other details.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Otorisasi: Hanya Admin/Staff yang boleh mengedit status riwayat kunjungan
        if (Auth::user()->role === 'patient') {
            abort(403, 'Anda tidak memiliki hak akses untuk mengedit riwayat kunjungan.');
        }

        $patientVisit = PatientVisit::with(['patientDetail.user', 'service'])->findOrFail($id);
        $statuses = ['completed', 'canceled']; // Allowed statuses for patient visit

        return view('patient_visits.edit', compact('patientVisit', 'statuses'));
    }

    /**
     * Update the specified patient visit's status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Otorisasi: Hanya Admin/Staff yang boleh mengupdate status riwayat kunjungan
        if (Auth::user()->role === 'patient') {
            abort(403, 'Anda tidak memiliki hak akses untuk memperbarui riwayat kunjungan.');
        }

        $request->validate([
            'status' => 'required|in:completed,canceled',
        ]);

        try {
            $patientVisit = PatientVisit::findOrFail($id);
            $patientVisit->status = $request->status;
            $patientVisit->save();

            return redirect()->route('patient_visits.index')->with('success', 'Status riwayat kunjungan berhasil diperbarui.');
        } catch (ValidationException $e) {
            Log::error('Validation failed during patient visit status update: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: ' . $e->getMessage())->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Failed to update patient visit status: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui status riwayat kunjungan: ' . $e->getMessage());
        }
    }
}
