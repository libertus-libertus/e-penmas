<?php

namespace App\Http\Controllers;

use App\Models\Service; // Import model Service
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mengambil semua data jenis pelayanan untuk ditampilkan di tabel Datatables client-side.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::latest()->get(); // Ambil semua data jenis pelayanan, diurutkan terbaru
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk menambah jenis pelayanan baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan jenis pelayanan baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:services,name', // Nama pelayanan harus unik
            'description' => 'nullable|string',
        ]);

        try {
            Service::create($request->all()); // Simpan data menggunakan mass assignment
            return redirect()->route('services.index')->with('success', 'Jenis pelayanan berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan jenis pelayanan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail jenis pelayanan.
     *
     * @param  \App\Models\Service  $service (Laravel otomatis mengikat model Service)
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit jenis pelayanan.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data jenis pelayanan di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:services,name,' . $service->id, // Nama unik kecuali untuk ID yang sedang diupdate
            'description' => 'nullable|string',
        ]);

        try {
            $service->update($request->all()); // Perbarui data
            return redirect()->route('services.index')->with('success', 'Jenis pelayanan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui jenis pelayanan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus jenis pelayanan dari database.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        try {
            $service->delete(); // Hapus data
            return redirect()->route('services.index')->with('success', 'Jenis pelayanan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('services.index')->with('error', 'Gagal menghapus jenis pelayanan: ' . $e->getMessage());
        }
    }
}