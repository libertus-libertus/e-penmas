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
            // 'auth' => \App\Http\Middleware\Authenticate::class,
            // 'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            // 'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // 'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            // 'can' => \Illuminate\Auth\Middleware\Authorize::class,
            // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            // 'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
            // 'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            // 'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

            // 'role.admin' => \App\Http\Middleware\AdminMiddleware::class,
            // 'role.staff' => \App\Http\Middleware\StaffMiddleware::class,
            // 'role.patient.redirect' => \App\Http\Middleware\PatientRedirectMiddleware::class,
            // // WAJIB: Daftarkan middleware baru ini
            // 'role.staff_or_self_patient_access' => \App\Http\Middleware\StaffOrSelfPatientAccessMiddleware::class,
        ]);

        // Anda juga bisa mendaftarkan middleware ke grup di sini jika diperlukan.
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
