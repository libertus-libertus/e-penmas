<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PatientDetail; // Import model PatientDetail - TETAPKAN INI UNTUK MIGRASI DAN MODEL
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// Hapus atau komen baris ini jika tidak menggunakan Yajra Datatables
// use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mengambil semua data pengguna (admin dan staff) untuk ditampilkan di tabel Datatables client-side.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil semua data pengguna dengan role 'admin' atau 'staff' saja
        $users = User::whereIn('role', ['admin', 'staff']) // <-- FILTER ROLE
                    ->select('id', 'name', 'email', 'role', 'position', 'created_at')
                    ->latest()
                    ->get();

        // Kirimkan koleksi pengguna ke view
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk menambah pengguna baru (hanya admin/staff).
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Mendefinisikan pilihan role hanya untuk admin dan staff
        $roles = ['admin', 'staff']; // <-- HANYA ADMIN DAN STAFF
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan pengguna baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|in:admin,staff', // <-- HANYA ADMIN DAN STAFF
            'position' => 'nullable|string|max:255', // Position sekarang nullable
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Buat pengguna baru di tabel users
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                // Position hanya diisi jika role adalah admin atau staff, jika tidak, set null
                'position' => in_array($request->role, ['admin', 'staff']) ? $request->position : null,
                'password' => Hash::make($request->password),
            ]);

            // HAPUS LOGIKA PEMBUATAN PATIENTDETAIL DI SINI
            // PatientDetail hanya dibuat melalui modul Manajemen Data Pasien
            // if ($user->role === 'patient') { ... }

            return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail pengguna (admin dan staff).
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // Pastikan hanya admin/staff yang bisa dilihat di sini
        if (!in_array($user->role, ['admin', 'staff'])) {
            return redirect()->route('users.index')->with('error', 'User ini bukan admin atau staff.');
        }
        // HAPUS LOGIKA LOADEAGER UNTUK PATIENTDETAIL
        // if ($user->hasRole('patient')) { $user->load('patientDetail'); }
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit pengguna (admin dan staff).
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // Pastikan hanya admin/staff yang bisa diedit dari sini
        if (!in_array($user->role, ['admin', 'staff'])) {
            return redirect()->route('users.index')->with('error', 'User ini bukan admin atau staff, tidak bisa diedit dari modul ini.');
        }
        $roles = ['admin', 'staff']; // <-- HANYA ADMIN DAN STAFF
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data pengguna di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // Pastikan hanya admin/staff yang bisa diedit dari sini
        if (!in_array($user->role, ['admin', 'staff'])) {
            return redirect()->route('users.index')->with('error', 'User ini bukan admin atau staff, tidak bisa diperbarui dari modul ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,staff', // <-- HANYA ADMIN DAN STAFF
            'position' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            // Set position null jika role bukan admin/staff, atau gunakan input
            $user->position = in_array($request->role, ['admin', 'staff']) ? $request->position : null;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // HAPUS LOGIKA PEMBUATAN/PENGHAPUSAN PATIENTDETAIL DI SINI
            // if ($user->role === 'patient' && !$user->patientDetail) { ... }
            // elseif (!$user->hasRole('patient') && $user->patientDetail) { ... }


            return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus pengguna (admin dan staff) dari database.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Pastikan hanya admin/staff yang bisa dihapus dari sini
        if (!in_array($user->role, ['admin', 'staff'])) {
            return redirect()->route('users.index')->with('error', 'User ini bukan admin atau staff, tidak bisa dihapus dari modul ini.');
        }
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }
}