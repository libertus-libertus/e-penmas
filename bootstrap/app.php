<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role.admin' => \App\Http\Middleware\AdminMiddleware::class,
            'role.staff' => \App\Http\Middleware\StaffMiddleware::class,
            'role.patient' => \App\Http\Middleware\PatientMiddleware::class, // WAJIB: Alias untuk PatientMiddleware
            'role.patient.redirect' => \App\Http\Middleware\PatientRedirectMiddleware::class,
            'role.staff_or_self_patient_access' => \App\Http\Middleware\StaffOrSelfPatientAccessMiddleware::class,
            'profile.complete' => \App\Http\Middleware\CheckPatientProfileComplete::class, // WAJIB: Middleware baru
        ]);

        // Anda juga bisa mendaftarkan middleware ke grup di sini jika diperlukan.
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
