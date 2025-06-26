<nav id="sidebar" class="animate__animated animate__fadeInLeft">
    <div class="sidebar-header">
        <h3><i class="fas fa-hospital-user me-1"></i> Dashboard</h3>
        <small>Puskesmas Sehat</small>
    </div>
    <ul class="list-unstyled components">
        <li aria-current="page">
            <a href="#" class="active"><i class="fas fa-tachometer-alt me-1"></i> Ringkasan</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-user-plus me-1"></i> Registrasi Pasien</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-users me-1"></i> Data Pasien</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-clipboard-list me-1"></i> Pendaftaran</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-hand-pointer me-1"></i> Antrean</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-stethoscope me-1"></i> Pelayanan</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-calendar-alt me-1"></i> Jadwal</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-history me-1"></i> Riwayat</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-chart-bar me-1"></i> Laporan</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-user-cog me-1"></i> Petugas</a>
        </li>
        <li>
            <a href="{{ url('/') }}" target="_blank"><i class="fas fa-globe me-1"></i> Website</a>
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