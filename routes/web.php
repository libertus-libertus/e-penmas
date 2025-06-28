<?php

use App\Http\Controllers\PatientDetailController;
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
    Route::get('/dashboard', function () {
        return view('dashboard'); // Sesuaikan jika nama file dashboard Anda berbeda
    })->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('services', ServiceController::class); 
    // CRUD Service Schedules (Jadwal Pelayanan)
    Route::resource('service_schedules', ServiceScheduleController::class);

    // CRUD Patient Details (Detail Data Pasien)
    // Menggunakan rute kustom karena relasi kuat dengan User
    // Route::get('patient-details/{user}/create', [PatientDetailController::class, 'create'])->name('patient_details.create');
    // Route::post('patient-details', [PatientDetailController::class, 'store'])->name('patient_details.store');
    // Route::get('patient-details/{patient_detail}/edit', [PatientDetailController::class, 'edit'])->name('patient_details.edit');
    // Route::put('patient-details/{patient_detail}', [PatientDetailController::class, 'update'])->name('patient_details.update');
    // Delete tidak perlu karena akan cascade dari user deletion
    Route::resource('patients', PatientDetailController::class)->parameters([
        'patients' => 'patient' // Ini memberitahu Laravel bahwa {patient} di rute akan diikat ke model User
    ]);
});

// Ini adalah rute bawaan Breeze untuk autentikasi (login, register, forgot password, dll.)
require __DIR__.'/auth.php';