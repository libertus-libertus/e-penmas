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

Route::get('/', function () {
    return view('home'); // Atau bisa diarahkan ke homepage frontend Anda
});

Route::middleware(['auth', 'role.patient.redirect'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('role.staff');
    Route::middleware('role.admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('service_schedules', ServiceScheduleController::class);
        Route::resource('patients', PatientDetailController::class);
    });

    Route::get('patient_details/{patient_detail}', [PatientDetailController::class, 'show'])->name('patient_details.show')->middleware('role.staff');

    Route::middleware('role.staff')->group(function () {
        Route::resource('registrations', RegistrationController::class);
        Route::get('registrations/{id}/print', [RegistrationController::class, 'printQueue'])->name('registrations.print');
        Route::resource('appointments', AppointmentController::class);
        Route::resource('patient_visits', PatientVisitController::class)->except(['create', 'store', 'destroy']);
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
    });
});

require __DIR__.'/auth.php';
