<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// Hapus atau komen baris ini jika tidak menggunakan Yajra Datatables
// use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mengambil semua data pengguna untuk ditampilkan di tabel Datatables client-side.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil semua data pengguna dari database, diurutkan berdasarkan terbaru
        $users = User::select('id', 'name', 'email', 'position', 'created_at')->latest()->get();

        // Kirimkan koleksi pengguna ke view
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk menambah pengguna baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
            'email' => 'required|string|email|max:255|unique:users,email', // Email harus unik
            'position' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed', // Password minimal 8 karakter dan harus dikonfirmasi
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'position' => $request->position,
                'password' => Hash::make($request->password), // Hash password sebelum disimpan
            ]);
            // Pesan sukses yang akan ditangkap oleh Toastr
            return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Tangani error jika terjadi masalah saat menyimpan
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail pengguna.
     *
     * @param  \App\Models\User  $user (Laravel otomatis mengikat model User)
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit pengguna.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
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
        // Validasi data input untuk update
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id, // Email unik kecuali untuk ID yang sedang diupdate
            'position' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed', // Password bisa kosong jika tidak ingin diubah
        ]);

        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->position = $request->position;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            // Pesan sukses yang akan ditangkap oleh Toastr
            return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui!');
        } catch (\Exception $e) {
            // Tangani error jika terjadi masalah saat memperbarui
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus pengguna dari database.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete(); // Menggunakan delete() method dari model Eloquent
            // Pesan sukses yang akan ditangkap oleh Toastr
            return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            // Tangani error jika terjadi masalah saat menghapus
            return redirect()->route('users.index')->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }
}