<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\PatientDetail; // Untuk daftar pasien
use App\Models\Service; // Untuk daftar jenis layanan
use App\Models\Queue; // Untuk membuat antrean
use App\Models\User; // Untuk mengakses user dari patientDetail
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Untuk transaksi database

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar pendaftaran dan antrean.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Eager load relasi untuk menampilkan data di tabel
        $registrations = Registration::with(['patientDetail.user', 'service', 'queue'])
                                         ->latest()
                                         ->get();
        return view('registrations.index', compact('registrations'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat pendaftaran baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Ambil semua pasien (user dengan role 'patient') yang memiliki detail pasien lengkap
        // Ini memastikan hanya pasien yang sudah punya detail lengkap yang bisa didaftarkan
        $patients = User::where('role', 'patient')
                            ->whereHas('patientDetail')
                            ->with('patientDetail')
                            ->orderBy('name')
                            ->get();
        // Ambil semua jenis layanan
        $services = Service::orderBy('name')->get();

        // Variabel $genders tidak diperlukan di sini karena tidak ada input gender di form pendaftaran
        // Jika ada, tambahkan lagi seperti sebelumnya.
        $genders = ['Laki-laki', 'Perempuan']; // <--- MENAMBAHKAN KEMBALI INI UNTUK MENGHINDARI ERROR UNDEFINED VARIABLE DI VIEW JIKA ANDA MEMAKAINYA

        return view('registrations.create', compact('patients', 'services', 'genders'));
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan pendaftaran baru dan membuat nomor antrean.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // --- DEBUG POINT A: Lihat semua data yang dikirim dari form ---
        // dd($request->all());

        $request->validate([
            'patient_detail_id' => 'required|exists:patient_details,id',
            'service_id' => 'required|exists:services,id',
            'visit_date' => 'required|date|after_or_equal:today', // Tanggal kunjungan hari ini atau setelahnya
        ], [
            'patient_detail_id.required' => 'Pasien wajib dipilih.',
            'patient_detail_id.exists' => 'Pasien tidak valid.',
            'service_id.required' => 'Jenis pelayanan wajib dipilih.',
            'service_id.exists' => 'Jenis pelayanan tidak valid.',
            'visit_date.required' => 'Tanggal kunjungan wajib diisi.',
            'visit_date.date' => 'Format tanggal kunjungan tidak valid.',
            'visit_date.after_or_equal' => 'Tanggal kunjungan tidak bisa di masa lalu.',
        ]);

        // --- DEBUG POINT B: Jika kode mencapai sini, validasi berhasil. ---
        // dd('Validasi berhasil. Data siap disimpan.');

        DB::beginTransaction();

        try {
            // Tentukan nomor antrean
            $today = $request->visit_date;
            $lastQueueNumber = Registration::whereDate('visit_date', $today)
                                            ->max('queue_number');

            $newQueueNumber = $lastQueueNumber ? ($lastQueueNumber + 1) : 1;
            $formattedQueueNumber = str_pad($newQueueNumber, 3, '0', STR_PAD_LEFT);

            // --- DEBUG POINT C: Cek data sebelum membuat Registration ---
            // dd([
            //     'patient_detail_id' => $request->patient_detail_id,
            //     'service_id' => $request->service_id,
            //     'visit_date' => $request->visit_date,
            //     'queue_number' => $newQueueNumber,
            //     'status' => 'pending',
            // ]);

            // Buat Pendaftaran (Registration)
            $registration = Registration::create([
                'patient_detail_id' => $request->patient_detail_id,
                'service_id' => $request->service_id,
                'visit_date' => $request->visit_date,
                'queue_number' => $newQueueNumber, // Simpan sebagai integer untuk memudahkan max()
                'status' => 'pending', // Status awal pendaftaran
            ]);

            // --- DEBUG POINT D: Cek objek Registration yang baru dibuat ---
            // dd($registration);

            // Buat Antrean (Queue)
            Queue::create([
                'registration_id' => $registration->id,
                'queue_number' => $newQueueNumber,
                'status' => 'waiting', // Status awal antrean
            ]);

            // --- DEBUG POINT E: Cek objek Queue yang baru dibuat ---
            // dd('Queue created: ', Queue::latest()->first());


            DB::commit(); // Commit transaksi

            // --- DEBUG POINT F: Jika kode mencapai sini, transaksi berhasil di-commit ---
            // dd('Data berhasil disimpan dan di-commit. Siap redirect.');

            // Dapatkan nama pasien dan layanan untuk pesan sukses
            $patientName = $registration->patientDetail->user->name ?? 'Pasien Tidak Dikenal';
            $serviceName = $registration->service->name ?? 'Layanan Tidak Dikenal';

            return redirect()->route('registrations.index')
                             ->with('success', "Pendaftaran pasien {$patientName} untuk layanan {$serviceName} pada tanggal " . $registration->visit_date->format('d M Y') . " berhasil! Nomor Antrean Anda: <strong>{$formattedQueueNumber}</strong>.")
                             ->with('queue_number_display', $formattedQueueNumber)
                             ->with('patient_name_display', $patientName)
                             ->with('service_name_display', $serviceName);

        } catch (\Exception $e) {
            DB::rollBack();
            // --- DEBUG POINT G: Cek pesan error jika terjadi exception ---
            // dd('Terjadi error: ' . $e->getMessage(), $e->getTraceAsString());
            return redirect()->back()->withInput()->with('error', 'Gagal membuat pendaftaran: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail pendaftaran.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function show(Registration $registration)
    {
        $registration->load(['patientDetail.user', 'service', 'queue']);
        return view('registrations.show', compact('registration'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit pendaftaran (opsional, karena pendaftaran biasanya sekali).
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function edit(Registration $registration)
    {
        $patients = User::where('role', 'patient')->whereHas('patientDetail')->with('patientDetail')->orderBy('name')->get();
        $services = Service::orderBy('name')->get();
        $registration->load(['patientDetail.user', 'service', 'queue']);

        // Variabel $genders ditambahkan kembali di sini juga
        $genders = ['Laki-laki', 'Perempuan'];

        return view('registrations.edit', compact('registration', 'patients', 'services', 'genders'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui pendaftaran (opsional).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registration $registration)
    {
        $request->validate([
            'patient_detail_id' => 'required|exists:patient_details,id',
            'service_id' => 'required|exists:services,id',
            'visit_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'queue_status' => 'required|in:waiting,called,completed,skipped',
        ]);

        DB::beginTransaction();
        try {
            $registration->update([
                'patient_detail_id' => $request->patient_detail_id,
                'service_id' => $request->service_id,
                'visit_date' => $request->visit_date,
                'status' => $request->status,
            ]);

            $registration->queue->update(['status' => $request->queue_status]);

            DB::commit();
            return redirect()->route('registrations.index')->with('success', 'Pendaftaran berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui pendaftaran: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus pendaftaran.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registration $registration)
    {
        DB::beginTransaction();
        try {
            $registration->delete();
            DB::commit();
            return redirect()->route('registrations.index')->with('success', 'Pendaftaran berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('registrations.index')->with('error', 'Gagal menghapus pendaftaran: ' . $e->getMessage());
        }
    }
}