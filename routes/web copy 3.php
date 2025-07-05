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
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientDashboardController;

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
Route::get('/', function () {
    return view('home'); // Atau bisa diarahkan ke homepage frontend Anda
});

// --- GRUP RUTE UNTUK SISTEM MANAJEMEN (Backend Dashboard Admin/Staff) ---
// Semua rute di grup ini memerlukan autentikasi (`auth`)
// Dan pengguna dengan role 'patient' akan dialihkan (`role.patient.redirect`)
Route::middleware(['auth', 'role.patient.redirect'])->group(function () {

    // Dashboard Admin/Staff
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('role.staff');

    // Data Master (Admin Only)
    Route::middleware('role.admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('service_schedules', ServiceScheduleController::class);
        
        // Patient Management - Admin only parts (index, create, store, destroy)
        Route::get('patients', [PatientDetailController::class, 'index'])->name('patients.index');
        Route::get('patients/create', [PatientDetailController::class, 'create'])->name('patients.create');
        Route::post('patients', [PatientDetailController::class, 'store'])->name('patients.store');
        Route::delete('patients/{patient}', [PatientDetailController::class, 'destroy'])->name('patients.destroy');
    });

    // Operasional & Reports (Admin & Staff)
    Route::middleware('role.staff')->group(function () {
        Route::resource('registrations', RegistrationController::class);
        Route::get('registrations/{id}/print', [RegistrationController::class, 'printQueue'])->name('registrations.print');
        Route::resource('appointments', AppointmentController::class);
        Route::resource('patient_visits', PatientVisitController::class)->except(['create', 'store', 'destroy']);
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
    });
});

// --- GRUP RUTE UNTUK DASHBOARD & PROFIL PASIEN ---
// Hanya memerlukan autentikasi (`auth`), tidak ada pengalihan pasien di sini.
Route::middleware(['auth'])->group(function () {
    // Dashboard Pasien (Hanya dapat diakses oleh role 'patient')
    Route::get('/patient/dashboard', [PatientDashboardController::class, 'index'])->name('patient.dashboard')->middleware('role.patient');

    // Profil Pasien (Edit & Update) - Dapat diakses oleh Admin, Staff, DAN Pasien itu sendiri.
    // WAJIB: Rute ini tidak memiliki parameter ID di URL, akan menggunakan Auth::user()
    Route::get('patient/profile/edit', [PatientDetailController::class, 'editSelf'])->name('patient.profile.edit')->middleware('role.patient');
    Route::put('patient/profile', [PatientDetailController::class, 'updateSelf'])->name('patient.profile.update')->middleware('role.patient');

    // Rute Show PatientDetail (digunakan oleh Admin/Staff untuk melihat detail pasien, dan pasien untuk melihat detailnya sendiri)
    // Parameter {patient} di sini adalah ID dari User model
    Route::get('patients/{patient}', [PatientDetailController::class, 'show'])->name('patients.show')->middleware('role.staff_or_self_patient_access');

    // Rute Edit/Update PatientDetail (digunakan oleh Admin/Staff dari daftar pasien)
    // Ini adalah rute yang sama dengan patient/profile/edit, tetapi namanya berbeda untuk konteks admin/staff
    // Parameter {patient} di sini adalah ID dari User model
    Route::get('patients/{patient}/edit', [PatientDetailController::class, 'edit'])->name('patients.edit')->middleware('role.staff_or_self_patient_access');
    Route::put('patients/{patient}', [PatientDetailController::class, 'update'])->name('patients.update')->middleware('role.staff_or_self_patient_access');
});


// Ini adalah rute bawaan Breeze untuk autentikasi (login, register, forgot password, dll.)
require __DIR__.'/auth.php';
