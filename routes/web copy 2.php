<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientDetailController;
use App\Http\Controllers\PatientVisitController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceScheduleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Pastikan ini ada

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rute yang dapat diakses oleh Tamu (Frontend Website)
// Pasien yang login juga akan dialihkan ke sini jika mencoba akses dashboard
Route::get('/', function () {
    return view('home'); // Atau bisa diarahkan ke homepage frontend Anda
});

// --- GRUP RUTE UNTUK SISTEM MANAJEMEN (Backend Dashboard) ---
// Semua rute di grup ini memerlukan autentikasi (`auth`)
// Dan pengguna dengan role 'patient' akan dialihkan (`role.patient.redirect`)
Route::middleware(['auth', 'role.patient.redirect'])->group(function () {

    // Dashboard - Dapat diakses oleh Admin dan Staff
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('role.staff');


    // --- GRUP RUTE: Data Master - Hanya dapat diakses oleh Admin ---
    // Meliputi: Manajemen Petugas, Manajemen Jenis Pelayanan, Manajemen Jadwal Layanan, Manajemen Data Pasien (CRUD Master)
    Route::middleware('role.admin')->group(function () {
        // Manajemen Pengguna (Petugas/Admin)
        Route::resource('users', UserController::class);

        // Manajemen Jenis Pelayanan
        Route::resource('services', ServiceController::class);

        // Manajemen Jadwal Pelayanan
        Route::resource('service_schedules', ServiceScheduleController::class);

        // Manajemen Data Pasien (CRUD utama untuk PatientDetail)
        // Pastikan model binding di sini tidak tumpang tindih jika 'patients' merujuk ke User model.
        // Jika {patient} merujuk ke PatientDetail model, ini sudah benar.
        // Jika {patient} harusnya merujuk ke user_id di PatientDetail, maka perlu penyesuaian.
        // Berdasarkan IPO, patients adalah patient_details, jadi ini mengikat ke PatientDetail model.
        Route::resource('patients', PatientDetailController::class);
        // Hapus `.parameters(['patients' => 'patient'])` jika PatientDetailController mengharapkan ID PatientDetail,
        // bukan ID User. Jika Anda ingin menggunakan `PatientDetail $patient` di controller, ini sudah benar tanpa `parameters()`.
        // Jika `patients` mengacu pada modul manajemen pasien yang memanipulasi PatientDetail,
        // maka `Route::resource('patients', PatientDetailController::class);` saja sudah cukup.
    });


    // --- Rute Khusus: Tampilan Detail Pasien (patient_details.show) ---
    // Diperlukan oleh Dashboard (Pasien Terbaru) dan modul Operasional lainnya (Registrasi, Appointment).
    // Dapat diakses oleh Admin dan Staff (karena role.staff).
    // Kita tempatkan di luar grup role.admin agar staff bisa mengakses detail pasien.
    Route::get('patient_details/{patient_detail}', [PatientDetailController::class, 'show'])->name('patient_details.show')->middleware('role.staff');


    // --- GRUP RUTE: Operasional & Laporan/Riwayat - Dapat diakses oleh Admin dan Staff ---
    // Meliputi: Pendaftaran & Antrean, Pencatatan Pelayanan, Riwayat Kunjungan, Laporan & Statistik
    Route::middleware('role.staff')->group(function () {
        // Pendaftaran & Antrean
        Route::resource('registrations', RegistrationController::class);
        Route::get('registrations/{id}/print', [RegistrationController::class, 'printQueue'])->name('registrations.print');

        // Pencatatan Pelayanan
        Route::resource('appointments', AppointmentController::class);

        // Riwayat Kunjungan Pasien
        Route::resource('patient_visits', PatientVisitController::class)->except(['create', 'store', 'destroy']);

        // Laporan & Statistik
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
    });
});

// Ini adalah rute bawaan Breeze untuk autentikasi (login, register, forgot password, dll.)
require __DIR__.'/auth.php';
