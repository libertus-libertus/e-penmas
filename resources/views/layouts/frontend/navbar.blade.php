<header>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand animate__animated animate__fadeInLeft" href="#">
                <i class="fas fa-hospital me-2" style="font-size: 1.8rem;"></i>
                Puskesmas Nanggalo Siteba
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link animate__animated animate__fadeInDown" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link animate__animated animate__fadeInDown" href="#tentang-kami">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link animate__animated animate__fadeInDown" href="#layanan">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link animate__animated animate__fadeInDown" href="#informasi">Informasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link animate__animated animate__fadeInDown" href="#kontak">Kontak</a>
                    </li>

                    {{-- Tampilkan tombol "Login Petugas" jika pengguna BELUM login --}}
                    @guest
                    <li class="nav-item">
                        <a class="nav-link btn btn-light text-primary ms-lg-3 animate__animated animate__fadeInRight"
                            href="{{ route('login') }}">Login Petugas</a>
                    </li>
                    @endguest

                    {{-- Tampilkan dropdown "Akun Saya" jika pengguna SUDAH login --}}
                    @auth
                    <li class="nav-item dropdown ms-lg-3 animate__animated animate__fadeInRight">
                        <a class="nav-link btn btn-primary text-white dropdown-toggle" href="#" id="navbarDropdownAkun" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Akun Saya <i class="fas fa-user-circle ms-1"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownAkun">
                            {{-- Link ke Dashboard Pasien --}}
                            <li><a class="dropdown-item" href="{{ route('patient.dashboard') }}">Dashboard</a></li>
                            {{-- Link ke Profil Pasien --}}
                            <li><a class="dropdown-item" href="{{ route('patient.profile.edit') }}">Setting Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>
