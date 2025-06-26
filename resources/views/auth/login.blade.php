<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas Puskesmas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Google Fonts - Jost -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #28a745;
            --primary-hover: #218838;
            --secondary-color: #007bff;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
            --text-muted: #6c757d;
        }

        body {
            font-family: 'Jost', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.9), rgba(0, 123, 255, 0.7)), 
                        url('https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.98);
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 420px;
            animation: fadeInDown 0.6s ease-out;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h2 {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 0;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.2);
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            padding: 0.75rem 1rem;
        }

        .input-group .form-control {
            border-left: none;
            padding-left: 0.5rem;
        }

        .btn-login {
            background-color: var(--primary-color);
            border: none;
            color: white;
            font-weight: 500;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .forgot-password, 
        .register-link {
            color: var(--secondary-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }

        .forgot-password:hover, 
        .register-link:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        .invalid-feedback {
            font-size: 0.85rem;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-container {
                padding: 1.75rem;
            }
            
            .login-header h2 {
                font-size: 1.5rem;
            }
            
            .form-control, 
            .btn-login {
                padding: 0.65rem 0.9rem;
            }
        }

        @media (max-width: 400px) {
            .login-container {
                padding: 1.5rem;
            }
            
            .form-check {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .forgot-password {
                margin-top: 0.5rem;
            }
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="login-container shadow-lg" data-aos="zoom-in" data-aos-duration="600">
        <div class="login-header">
            {{-- <img src="https://via.placeholder.com/80x80?text=Logo" alt="Puskesmas Logo" class="mb-3" width="80" height="80"> --}}
            <h2 class="animate__animated animate__fadeInUp">Login Petugas</h2>
            <p class="animate__animated animate__fadeInUp animate__delay-1s">Sistem Pendaftaran & Pelayanan Puskesmas</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-3 text-success animate__animated animate__fadeIn" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" data-aos="fade-up" data-aos-delay="300">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label visually-hidden">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Email Petugas">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label visually-hidden">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                           required autocomplete="current-password" placeholder="Password">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label for="remember_me" class="form-check-label">Ingat Saya</label>
                </div>
                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <div class="d-grid gap-2 mb-3">
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> Login
                </button>
            </div>

            <!-- Register Link -->
            <div class="text-center mt-3">
                <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}" class="register-link">Daftar Sekarang</a></p>
            </div>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- AOS Initialization -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            mirror: false,
            duration: 600,
            easing: 'ease-out',
        });
    </script>
</body>
</html>