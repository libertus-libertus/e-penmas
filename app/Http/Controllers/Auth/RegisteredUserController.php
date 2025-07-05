<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PatientDetail; // WAJIB: Import model PatientDetail
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // WAJIB: Buat user dengan role 'patient' secara default
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient', // Set role default sebagai 'patient'
            'position' => null, // Pasien tidak punya jabatan
        ]);

        // WAJIB: Buat entri PatientDetail kosong untuk user baru ini
        // Ini akan mencegah $patientDetail menjadi null di dashboard pasien
        PatientDetail::create([
            'user_id' => $user->id,
            'nik' => null, // Ini akan diterima karena kolom sudah nullable
            'address' => null,
            'birth_date' => null,
            'phone_number' => null,
            'gender' => null,
            'bpjs_status' => false, // Default false atau null, sesuai kebutuhan
        ]);


        event(new Registered($user));

        Auth::login($user);

        // Setelah registrasi sukses, arahkan pasien ke dashboard pasien mereka
        return redirect()->route('patient.dashboard');
    }
}
