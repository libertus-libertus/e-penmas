<?php

namespace App\Http\Controllers;

use App\Models\PatientDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PatientDetailController extends Controller
{
    /**
     * Display a listing of the patients.
     * Hanya bisa diakses oleh Admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Otorisasi sudah ditangani di rute melalui middleware role.admin
        // if (Auth::user()->role !== 'admin') {
        //      abort(403, 'Anda tidak memiliki hak akses untuk melihat daftar pasien.');
        // }
        // Ambil semua user dengan role 'patient' dan muat relasi patientDetail.
        // User yang di-soft delete tidak akan diambil oleh where('role', 'patient') kecuali withTrashed() dipanggil pada User.
        $patients = User::where('role', 'patient')
                         ->with('patientDetail') // Cukup muat relasi patientDetail
                         ->latest()->get();

        return view('patient_details.index', compact('patients'));
    }

    /**
     * Show the form for creating a new patient.
     * Hanya bisa diakses oleh Admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patient_details.create');
    }

    /**
     * Store a newly created patient in storage.
     * Hanya bisa diakses oleh Admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Otorisasi sudah ditangani di rute melalui middleware role.admin
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nik' => 'required|string|digits:16|unique:patient_details,nik',
            'address' => 'required|string',
            'birth_date' => 'required|date',
            'phone_number' => 'required|string|max:15',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'bpjs_status' => 'required|boolean',
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar di sistem.',
            'nik.digits' => 'NIK harus 16 digit.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'patient',
                'position' => null,
            ]);

            PatientDetail::create([
                'user_id' => $user->id,
                'nik' => $request->nik,
                'address' => $request->address,
                'birth_date' => $request->birth_date,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'bpjs_status' => $request->bpjs_status,
            ]);

            DB::commit();

            return redirect()->route('patients.index')->with('success', 'Data pasien berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create patient: ' . $e->getMessage(), ['exception' => $e, 'request' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan pasien: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * Dapat diakses oleh Admin, Staff, dan Pasien itu sendiri.
     *
     * @param  \App\Models\User  $patient // Binding ke User model
     * @return \Illuminate\Http\Response
     */
    public function show(User $patient) // $patient sekarang adalah instance User
    {
        // Pastikan user adalah 'patient'
        if (!$patient->hasRole('patient')) {
            abort(403, 'User ini bukan pasien.');
        }
        // WAJIB: Memuat relasi patientDetail, dan di dalamnya, muat relasi user (yang mungkin di-soft delete)
        $patient->load(['patientDetail.user' => function($query) {
            $query->withTrashed();
        }]);

        // --- Logika Otorisasi untuk Show ---
        if (Auth::user()->role === 'patient' && Auth::id() !== $patient->id) {
            abort(403, 'Anda tidak memiliki akses untuk melihat detail pasien lain.');
        }

        // Final validasi: Pastikan detail pasien ini terkait dengan user ber-role 'patient' dan user itu ada
        // JIKA patientDetail TIDAK ADA, JANGAN REDIRECT. Biarkan view yang menanganinya.
        // Cukup cek jika patientDetail ada TAPI user di dalamnya tidak ada atau role-nya bukan pasien.
        if ($patient->patientDetail && (!$patient->patientDetail->user || $patient->patientDetail->user->role !== 'patient')) {
             return redirect()->route('patients.index')->with('error', 'Detail pasien tidak valid: Akun pengguna tidak ditemukan atau bukan role pasien.');
        }

        return view('patient_details.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     * Dapat diakses oleh Admin, Staff, dan Pasien itu sendiri.
     *
     * @param  \App\Models\User  $patient // Binding ke User model
     * @return \Illuminate\Http\Response
     */
    public function edit(User $patient) // $patient sekarang adalah instance User
    {
        // Pastikan user adalah 'patient'
        if (!$patient->hasRole('patient')) {
            abort(403, 'User ini bukan pasien.');
        }
        // WAJIB: Memuat relasi patientDetail, dan di dalamnya, muat relasi user (yang mungkin di-soft delete)
        $patient->load(['patientDetail.user' => function($query) {
            $query->withTrashed();
        }]);

        // --- Logika Otorisasi untuk Edit ---
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'staff') {
            // Admin/Staff bisa edit semua pasien
        } elseif (Auth::user()->role === 'patient') {
            // Pasien hanya bisa edit jika user_id mereka sama dengan user_id pasien ini
            if (Auth::id() !== $patient->id) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak diizinkan mengedit detail pasien lain.');
            }
        } else {
            // Role tidak dikenal atau tidak diizinkan
            abort(403, 'Anda tidak memiliki hak akses untuk mengedit halaman ini.');
        }

        // Final validasi: Pastikan detail pasien ini terkait dengan user ber-role 'patient' dan user itu ada
        // JIKA patientDetail TIDAK ADA, JANGAN REDIRECT. Biarkan form yang menanganinya.
        // Cukup cek jika patientDetail ada TAPI user di dalamnya tidak ada atau role-nya bukan pasien.
        if ($patient->patientDetail && (!$patient->patientDetail->user || $patient->patientDetail->user->role !== 'patient')) {
            return redirect()->route('patients.index')->with('error', 'Detail pasien tidak valid: Akun pengguna tidak ditemukan atau bukan role pasien.');
        }

        return view('patient_details.edit', compact('patient'));
    }

    /**
     * Update the specified patient (User model) in storage.
     * Dapat diakses oleh Admin, Staff, dan Pasien itu sendiri.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $patient // Binding ke User model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $patient) // $patient adalah instance User
    {
        // Pastikan user adalah 'patient'
        if (!$patient->hasRole('patient')) {
            abort(403, 'User ini bukan pasien.');
        }
        // WAJIB: Memuat relasi patientDetail, dan di dalamnya, muat relasi user (yang mungkin di-soft delete)
        $patient->load(['patientDetail.user' => function($query) {
            $query->withTrashed();
        }]);

        // --- Logika Otorisasi untuk Update ---
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'staff') {
            // Admin/Staff bisa update semua
        } elseif (Auth::user()->role === 'patient') {
            if (Auth::id() !== $patient->id) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak diizinkan memperbarui detail pasien lain.');
            }
        } else {
            abort(403, 'Anda tidak memiliki hak akses untuk memperbarui halaman ini.');
        }

        // Final validasi: Pastikan detail pasien ini terkait dengan user ber-role 'patient' dan user itu ada
        // (Ini akan digunakan untuk validasi NIK/email unik)
        // Jika patientDetail tidak ada, maka NIK dan lainnya akan dianggap baru dan tidak perlu ignore ID.
        $patientDetailId = $patient->patientDetail->id ?? null;
        $userId = $patient->id;

        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => 'nullable|string|min:8|confirmed',
            // NIK unik kecuali untuk patientDetail ini, jika patientDetail ada
            'nik' => ['nullable', 'string', 'digits:16', Rule::unique('patient_details', 'nik')->ignore($patientDetailId)],
            'address' => 'nullable|string', // Perbolehkan nullable jika belum lengkap
            'birth_date' => 'nullable|date', // Perbolehkan nullable jika belum lengkap
            'phone_number' => 'nullable|string|max:15', // Perbolehkan nullable jika belum lengkap
            'gender' => 'nullable|in:Laki-laki,Perempuan', // Perbolehkan nullable jika belum lengkap
            'bpjs_status' => 'nullable|boolean', // Perbolehkan nullable jika belum lengkap
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar di sistem.',
            'nik.digits' => 'NIK harus 16 digit.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
        ]);

        try {
            DB::beginTransaction();

            $patient->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->filled('password') ? Hash::make($request->password) : $patient->password,
            ]);

            // Update atau Buat PatientDetail
            if ($patient->patientDetail) {
                // Jika patientDetail sudah ada, update
                $patient->patientDetail->update([
                    'nik' => $request->nik,
                    'address' => $request->address,
                    'birth_date' => $request->birth_date,
                    'phone_number' => $request->phone_number,
                    'gender' => $request->gender,
                    'bpjs_status' => $request->bpjs_status,
                ]);
            } else {
                // Jika patientDetail belum ada, buat baru
                // Pastikan semua field yang required di PatientDetail terisi dari request
                PatientDetail::create([
                    'user_id' => $patient->id,
                    'nik' => $request->nik,
                    'address' => $request->address,
                    'birth_date' => $request->birth_date,
                    'phone_number' => $request->phone_number,
                    'gender' => $request->gender,
                    'bpjs_status' => $request->bpjs_status,
                ]);
            }

            DB::commit();

            // Redirect ke halaman detail pasien itu sendiri setelah update
            return redirect()->route('patients.show', $patient->id)->with('success', 'Data pasien berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update patient: ' . $e->getMessage(), ['exception' => $e, 'request' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data pasien: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * Hanya bisa diakses oleh Admin.
     *
     * @param  \App\Models\User  $patient // Binding ke User model
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $patient) // $patient adalah instance User
    {
        // Otorisasi sudah ditangani di rute melalui middleware role.admin.
        if (Auth::user()->role !== 'admin') {
             abort(403, 'Anda tidak memiliki hak akses untuk menghapus data pasien.');
        }

        try {
            DB::beginTransaction();

            // Pastikan user adalah pasien sebelum menghapus
            if (!$patient->hasRole('patient')) {
                abort(403, 'User ini bukan pasien, tidak bisa dihapus dari modul ini.');
            }

            // Soft delete User (ini akan otomatis menghapus PatientDetail berkat onDelete('cascade'))
            $patient->delete();

            DB::commit();
            return redirect()->route('patients.index')->with('success', 'Data pasien berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete patient: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data pasien: ' . $e->getMessage());
        }
    }
}
