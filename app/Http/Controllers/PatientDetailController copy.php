<?php

namespace App\Http\Controllers;

use App\Models\PatientDetail;
use App\Models\User; // Pastikan ini di-import
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientDetailController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk melengkapi detail pasien.
     *
     * @param  \App\Models\User  $user (Laravel otomatis mengikat model User dari parameter {user} di URL)
     * @return \Illuminate\Http\Response
     */
    public function create(User $user) // <--- PERUBAHAN UTAMA DI SINI
    {
        // Objek $user sudah tersedia di sini karena Route Model Binding.
        // Tidak perlu lagi mengambil user_id dari $request atau melakukan findOrFail di sini.

        // Pastikan user ini adalah pasien dan belum punya patient_detail
        if (!$user->hasRole('patient')) {
            return redirect()->route('users.index')->with('error', 'User ini bukan dengan role pasien.');
        }
        if ($user->patientDetail) {
            return redirect()->route('users.index')->with('error', 'Detail pasien untuk user ini sudah ada.');
        }

        $genders = ['Laki-laki', 'Perempuan']; // Pilihan jenis kelamin
        return view('patient_details.create', compact('user', 'genders'));
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan detail pasien baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nik' => 'required|string|size:16|unique:patient_details,nik',
            'address' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'phone_number' => 'required|string|max:15',
            'gender' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'bpjs_status' => 'required|boolean',
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar di sistem.',
            'nik.size' => 'NIK harus 16 digit.',
        ]);

        try {
            $user = User::findOrFail($request->user_id); // Tetap ambil user di sini untuk validasi lanjut
            if (!$user->hasRole('patient')) {
                 return redirect()->back()->withInput()->with('error', 'User ini bukan dengan role pasien.');
            }
            if ($user->patientDetail) {
                 return redirect()->back()->withInput()->with('error', 'Detail pasien untuk user ini sudah ada.');
            }

            PatientDetail::create($request->all());
            return redirect()->route('users.show', $user->id)->with('success', 'Detail pasien berhasil dilengkapi!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal melengkapi detail pasien: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit detail pasien.
     *
     * @param  \App\Models\PatientDetail  $patientDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(PatientDetail $patientDetail)
    {
        $genders = ['Laki-laki', 'Perempuan'];
        $patientDetail->load('user'); // Pastikan user di-load untuk akses nama di view
        return view('patient_details.edit', compact('patientDetail', 'genders'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui detail pasien.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PatientDetail  $patientDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PatientDetail $patientDetail)
    {
        $request->validate([
            'nik' => ['required', 'string', 'size:16', Rule::unique('patient_details', 'nik')->ignore($patientDetail->id)],
            'address' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'phone_number' => 'required|string|max:15',
            'gender' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'bpjs_status' => 'required|boolean',
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar di sistem.',
            'nik.size' => 'NIK harus 16 digit.',
        ]);

        try {
            $patientDetail->update($request->all());
            return redirect()->route('users.show', $patientDetail->user_id)->with('success', 'Detail pasien berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui detail pasien: ' . $e->getMessage());
        }
    }
}