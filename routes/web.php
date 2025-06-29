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
use App\Http\Controllers\UserController; // <-- Pastikan ini ada

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

Route::get('/', function () {
    return view('home'); // Atau bisa diarahkan ke homepage frontend Anda
});

// Grup rute yang hanya bisa diakses setelah login
Route::middleware(['auth'])->group(function () {
    // Route untuk Dashboard utama
    // Route::get('/dashboard', function () {
    //     return view('dashboard'); // Sesuaikan jika nama file dashboard Anda berbeda
    // })->name('dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('services', ServiceController::class); 
    // CRUD Service Schedules (Jadwal Pelayanan)
    Route::resource('service_schedules', ServiceScheduleController::class);
    Route::resource('patients', PatientDetailController::class)->parameters([
        'patients' => 'patient' // Ini memberitahu Laravel bahwa {patient} di rute akan diikat ke model User
    ]);

    // MODUL BARU: PENDAFTARAN PASIEN & ANTRIAN
    Route::resource('registrations', RegistrationController::class);
    Route::get('registrations/{id}/print', [RegistrationController::class, 'printQueue'])->name('registrations.print');

    Route::resource('appointments', AppointmentController::class);
    Route::resource('patient_visits', PatientVisitController::class)->except(['create', 'store', 'destroy']);

    // --- Rute Baru untuk Modul Laporan & Statistik ---
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
});

// Ini adalah rute bawaan Breeze untuk autentikasi (login, register, forgot password, dll.)
require __DIR__.'/auth.php';