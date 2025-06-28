<?php

namespace App\Http\Controllers;

use App\Models\ServiceSchedule; // Import Model ServiceSchedule
use App\Models\Service; // Import Model Service (untuk dropdown)
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Untuk validasi unique kompleks

class ServiceScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar jadwal pelayanan.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil semua jadwal pelayanan beserta nama layanan terkait
        $serviceSchedules = ServiceSchedule::with('service')->latest()->get();
        return view('service_schedules.index', compact('serviceSchedules'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk menambah jadwal pelayanan baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::orderBy('name')->get(); // Ambil semua jenis layanan untuk dropdown
        $days = [ // Daftar hari
            'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'
        ];
        return view('service_schedules.create', compact('services', 'days'));
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan jadwal pelayanan baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'day' => ['required', 'string', Rule::unique('service_schedules')->where(function ($query) use ($request) {
                return $query->where('service_id', $request->service_id);
            })], // Pastikan kombinasi service_id dan day unik
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ], [
            'day.unique' => 'Jadwal untuk layanan dan hari tersebut sudah ada.',
            'end_time.after' => 'Jam selesai harus setelah jam mulai.',
        ]);

        try {
            ServiceSchedule::create($request->all());
            return redirect()->route('service_schedules.index')->with('success', 'Jadwal pelayanan berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan jadwal pelayanan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail jadwal pelayanan.
     *
     * @param  \App\Models\ServiceSchedule  $serviceSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceSchedule $serviceSchedule)
    {
        // Eager load service untuk menampilkan nama layanan
        $serviceSchedule->load('service');
        return view('service_schedules.show', compact('serviceSchedule'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit jadwal pelayanan.
     *
     * @param  \App\Models\ServiceSchedule  $serviceSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceSchedule $serviceSchedule)
    {
        $services = Service::orderBy('name')->get();
        $days = [
            'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'
        ];
        return view('service_schedules.edit', compact('serviceSchedule', 'services', 'days'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data jadwal pelayanan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceSchedule  $serviceSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceSchedule $serviceSchedule)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'day' => ['required', 'string', Rule::unique('service_schedules')->where(function ($query) use ($request) {
                return $query->where('service_id', $request->service_id);
            })->ignore($serviceSchedule->id)], // Unique kecuali untuk jadwal yang sedang diedit
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ], [
            'day.unique' => 'Jadwal untuk layanan dan hari tersebut sudah ada.',
            'end_time.after' => 'Jam selesai harus setelah jam mulai.',
        ]);

        try {
            $serviceSchedule->update($request->all());
            return redirect()->route('service_schedules.index')->with('success', 'Jadwal pelayanan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui jadwal pelayanan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus jadwal pelayanan.
     *
     * @param  \App\Models\ServiceSchedule  $serviceSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceSchedule $serviceSchedule)
    {
        try {
            $serviceSchedule->delete();
            return redirect()->route('service_schedules.index')->with('success', 'Jadwal pelayanan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('service_schedules.index')->with('error', 'Gagal menghapus jadwal pelayanan: ' . $e->getMessage());
        }
    }
}