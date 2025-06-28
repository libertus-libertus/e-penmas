<?php

namespace App\Http\Controllers;

use App\Models\PatientDetail;
use App\Models\User; // Pastikan ini di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Untuk hashing password
use Illuminate\Validation\Rule; // Untuk validasi unique kompleks

class PatientDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua user dengan role 'patient' (untuk Datatables).
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil semua user dengan role 'patient' beserta detail pasiennya
        $patients = User::where('role', 'patient')->with('patientDetail')->latest()->get();
        return view('patient_details.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource (Pasien baru).
     * Menampilkan form untuk menambah pasien baru (role otomatis 'patient').
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genders = ['Laki-laki', 'Perempuan']; // Pilihan jenis kelamin
        // Tidak perlu mengirim variabel $user karena ini untuk membuat user baru
        return view('patient_details.create', compact('genders'));
    }

    /**
     * Store a newly created resource in storage (Menyimpan pasien baru).
     * Membuat user baru dengan role 'patient' dan detail pasien terkait.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data untuk tabel users dan patient_details
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nik' => 'required|string|size:16|unique:patient_details,nik', // NIK harus 16 digit dan unik
            'address' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'phone_number' => 'required|string|max:15',
            'gender' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'bpjs_status' => 'required|boolean',
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar di sistem.',
            'nik.size' => 'NIK harus 16 digit.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
        ]);

        try {
            // 1. Buat user baru dengan role 'patient'
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'patient', // Otomatis diset sebagai 'patient'
                'position' => null, // Pasien tidak punya jabatan
            ]);

            // 2. Buat detail pasien terkait
            PatientDetail::create([
                'user_id' => $user->id,
                'nik' => $request->nik,
                'address' => $request->address,
                'birth_date' => $request->birth_date,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'bpjs_status' => $request->bpjs_status,
            ]);

            return redirect()->route('patients.index')->with('success', 'Data pasien berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data pasien: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail seorang pasien.
     *
     * @param  \App\Models\User  $patient (Menggunakan Route Model Binding ke User dengan role patient)
     * @return \Illuminate\Http\Response
     */
    public function show(User $patient) // Menggunakan $patient untuk objek User dengan role patient
    {
        // Pastikan user yang diakses benar-benar pasien
        if (!$patient->hasRole('patient')) {
            return redirect()->route('patients.index')->with('error', 'User ini bukan pasien.');
        }

        $patient->load('patientDetail'); // Eager load detail pasiennya
        return view('patient_details.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit detail seorang pasien.
     *
     * @param  \App\Models\User  $patient (Menggunakan Route Model Binding ke User dengan role patient)
     * @return \Illuminate\Http\Response
     */
    public function edit(User $patient) // Menggunakan $patient untuk objek User dengan role patient
    {
        // Pastikan user yang diakses benar-benar pasien dan memiliki patientDetail
        if (!$patient->hasRole('patient') || !$patient->patientDetail) {
            return redirect()->route('patients.index')->with('error', 'User ini bukan pasien atau detail pasien tidak ditemukan.');
        }

        $genders = ['Laki-laki', 'Perempuan'];
        $patient->load('patientDetail'); // Eager load detail pasiennya
        return view('patient_details.edit', compact('patient', 'genders'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui detail seorang pasien.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $patient (Menggunakan Route Model Binding ke User dengan role patient)
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $patient) // Menggunakan $patient untuk objek User dengan role patient
    {
        // Pastikan user yang diakses benar-benar pasien dan memiliki patientDetail
        if (!$patient->hasRole('patient') || !$patient->patientDetail) {
            return redirect()->route('patients.index')->with('error', 'User ini bukan pasien atau detail pasien tidak ditemukan.');
        }

        // Validasi data untuk tabel users dan patient_details
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($patient->id)], // Email unik kecuali untuk user ini
            'nik' => ['required', 'string', 'size:16', Rule::unique('patient_details', 'nik')->ignore($patient->patientDetail->id)], // NIK unik kecuali untuk detail pasien ini
            'address' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'phone_number' => 'required|string|max:15',
            'gender' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'bpjs_status' => 'required|boolean',
            'password' => 'nullable|string|min:8|confirmed', // Password bisa kosong jika tidak diubah
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar di sistem.',
            'nik.size' => 'NIK harus 16 digit.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
        ]);

        try {
            // 1. Update data user dasar
            $patient->name = $request->name;
            $patient->email = $request->email;
            if ($request->filled('password')) {
                $patient->password = Hash::make($request->password);
            }
            $patient->save();

            // 2. Update detail pasien
            $patient->patientDetail->update([
                'nik' => $request->nik,
                'address' => $request->address,
                'birth_date' => $request->birth_date,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'bpjs_status' => $request->bpjs_status,
            ]);

            return redirect()->route('patients.show', $patient->id)->with('success', 'Data pasien berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data pasien: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus pasien (user dengan role patient) dan detailnya.
     *
     * @param  \App\Models\User  $patient (Menggunakan Route Model Binding ke User dengan role patient)
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $patient) // Menggunakan $patient untuk objek User dengan role patient
    {
        // Pastikan user yang dihapus adalah pasien
        if (!$patient->hasRole('patient')) {
            return redirect()->route('patients.index')->with('error', 'User ini bukan pasien, tidak bisa dihapus dari modul ini.');
        }

        try {
            $patient->delete(); // Ini akan otomatis menghapus patientDetail berkat onDelete('cascade')
            return redirect()->route('patients.index')->with('success', 'Data pasien berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('patients.index')->with('error', 'Gagal menghapus data pasien: ' . $e->getMessage());
        }
    }
}