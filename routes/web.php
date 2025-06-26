<?php

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
});

// Ini adalah rute bawaan Breeze untuk autentikasi (login, register, forgot password, dll.)
require __DIR__.'/auth.php';