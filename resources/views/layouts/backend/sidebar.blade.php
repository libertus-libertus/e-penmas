<nav id="sidebar" class="animate__animated animate__fadeInLeft">
    <div class="sidebar-header">
        <h3><i class="fas fa-hospital-user me-1"></i> Dashboard</h3>
        <small>Puskesmas Sehat</small>
    </div>
    <ul class="list-unstyled components">
        {{-- KATEGORI: DASHBOARD UTAMA --}}
        <li class="sidebar-heading">Dashboard Utama</li>
        <li class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-1"></i> Ringkasan</a>
        </li>

        {{-- KATEGORI: DATA MASTER --}}
        <li class="sidebar-heading mt-3">Data Master</li>
        <li>
            <a href="#"><i class="fas fa-users me-1"></i> Data Pasien</a>
        </li>
        {{-- MENU BARU: MANAJEMEN JENIS PELAYANAN --}}
        <li class="{{ Request::routeIs('services.*') ? 'active' : '' }}">
            <a href="{{ route('services.index') }}"><i class="fas fa-notes-medical me-1"></i> Manajemen Jenis Pelayanan</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-calendar-alt me-1"></i> Data Jadwal Layanan</a>
        </li>


        {{-- KATEGORI: OPERASIONAL --}}
        <li class="sidebar-heading mt-3">Operasional</li>
        <li>
            <a href="#"><i class="fas fa-user-plus me-1"></i> Registrasi Pasien</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-clipboard-list me-1"></i> Pendaftaran Kunjungan</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-hand-pointer me-1"></i> Manajemen Antrean</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-stethoscope me-1"></i> Pencatatan Pelayanan</a>
        </li>

        {{-- KATEGORI: LAPORAN & RIWAYAT --}}
        <li class="sidebar-heading mt-3">Laporan & Riwayat</li>
        <li>
            <a href="#"><i class="fas fa-history me-1"></i> Riwayat Kunjungan</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-chart-bar me-1"></i> Laporan Statistik</a>
        </li>

        {{-- KATEGORI: PENGATURAN SISTEM --}}
        <li class="sidebar-heading mt-3">Pengaturan Sistem</li>
        {{-- MENU: MANAJEMEN PETUGAS --}}
        <li class="{{ Request::routeIs('users.*') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}"><i class="fas fa-user-cog me-1"></i> Manajemen Petugas</a>
        </li>

        {{-- KATEGORI: LAIN-LAIN --}}
        <li class="sidebar-heading mt-3">Lain-lain</li>
        <li>
            <a href="{{ url('/') }}" target="_blank"><i class="fas fa-globe me-1"></i> Lihat Website Frontend</a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                    class="text-decoration-none">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </form>
        </li>
    </ul>
</nav>