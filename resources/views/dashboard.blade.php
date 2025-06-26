<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas Puskesmas Sehat Selalu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #28a745;
            --secondary-color: #007bff;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
            --info-color: #17a2b8;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        body {
            font-family: 'Jost', sans-serif;
            font-size: 0.9rem;
            line-height: 1.5;
            background-color: var(--light-color);
            color: var(--dark-color);
        }

        /* Improved Sidebar */
        #sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--dark-color);
            color: white;
            padding-top: 15px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
            overflow-y: hidden;
            z-index: 1000;
        }

        #sidebar.active {
            margin-left: -220px;
        }

        #sidebar .sidebar-header {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            margin-bottom: 10px;
        }

        #sidebar .sidebar-header h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 3px;
        }

        #sidebar .sidebar-header small {
            font-size: 0.75rem;
            opacity: 0.8;
        }

        #sidebar .list-unstyled.components {
            padding: 0 10px;
        }

        #sidebar .list-unstyled.components li a {
            padding: 10px 12px;
            font-size: 0.85rem;
            display: block;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.2s;
            border-radius: 5px;
            margin: 3px 0;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #sidebar .list-unstyled.components li a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        #sidebar .list-unstyled.components li.active > a,
        #sidebar .list-unstyled.components li[aria-current="page"] > a {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        #sidebar .list-unstyled.components li a i {
            width: 20px;
            text-align: center;
            margin-right: 8px;
            font-size: 0.9rem;
        }

        /* Content Area */
        #content {
            margin-left: 220px;
            padding: 20px;
            transition: all 0.3s;
            width: calc(100% - 220px);
            min-height: 100vh;
        }

        #content.active {
            margin-left: 0;
            width: 100%;
        }

        /* Compact Cards */
        .card-dashboard {
            border: none;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            background-color: white;
        }

        .card-dashboard .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 12px 15px;
            font-weight: 600;
            border-bottom: none;
            font-size: 0.95rem;
        }

        .card-dashboard .card-header i {
            margin-right: 8px;
            font-size: 0.9rem;
        }

        .card-dashboard .card-body {
            padding: 15px;
        }

        .card-icon {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .statistic-value {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 3px;
        }

        .statistic-label {
            font-size: 0.8rem;
            color: #666;
            font-weight: 500;
        }

        /* Compact Tables */
        .table-responsive-custom {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            background-color: white;
            max-height: 400px;
        }

        .table-responsive-custom table {
            margin-bottom: 0;
            font-size: 0.85rem;
        }

        .table-responsive-custom thead {
            background-color: var(--primary-color);
            color: white;
        }

        .table-responsive-custom th {
            font-weight: 600;
            padding: 10px 12px;
            font-size: 0.8rem;
        }

        .table-responsive-custom td {
            padding: 8px 12px;
            vertical-align: middle;
        }

        .table-responsive-custom tbody tr:hover {
            background-color: rgba(0,0,0,0.02);
        }

        /* Buttons */
        .btn-sm {
            padding: 4px 10px;
            font-size: 0.8rem;
        }

        /* Navbar */
        .navbar {
            padding: 12px 15px;
            border-radius: 8px !important;
            margin-bottom: 15px;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1rem;
        }

        /* Headings */
        h1 {
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: var(--dark-color);
        }

        /* Badges */
        .badge {
            padding: 5px 8px;
            font-weight: 500;
            font-size: 0.75rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -220px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                width: 100%;
                margin-left: 0;
                padding: 15px;
            }
            #content.active {
                width: 100%;
            }
            
            .table-responsive-custom {
                max-height: none;
            }
        }
    </style>
</head>
<body>

    <div class="wrapper d-flex">
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
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="text-decoration-none">
                           <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                    </form>
                </li>
            </ul>
        </nav>

        <div id="content">
            <button type="button" id="sidebarCollapse" class="btn btn-info d-block d-md-none mb-3 animate__animated animate__fadeIn">
                <i class="fas fa-bars"></i>
            </button>

            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-3 animate__animated animate__fadeInDown">
                <div class="container-fluid">
                    <button class="btn btn-outline-secondary d-none d-md-block" type="button" id="sidebarToggleDesktop">
                        <i class="fas fa-bars"></i>
                    </button>
                    <a class="navbar-brand ms-2 d-none d-md-block" href="#">Halo, Petugas!</a>
                    <div class="ms-auto">
                        <span class="navbar-text" style="font-size: 0.85rem;">
                            Puskesmas Sehat | <span id="currentDateTime"></span>
                        </span>
                    </div>
                </div>
            </nav>

            <h1 class="mb-3 animate__animated animate__fadeInUp">Ringkasan Dashboard</h1>

            <div class="row mb-3 g-3">
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card card-dashboard text-center">
                        <div class="card-body">
                            <i class="fas fa-users card-icon"></i>
                            <div class="statistic-value text-success">150</div>
                            <div class="statistic-label">Pasien Terdaftar</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="card card-dashboard text-center">
                        <div class="card-body">
                            <i class="fas fa-clipboard-list card-icon"></i>
                            <div class="statistic-value text-info">35</div>
                            <div class="statistic-label">Pendaftaran Hari Ini</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="card card-dashboard text-center">
                        <div class="card-body">
                            <i class="fas fa-hourglass-half card-icon"></i>
                            <div class="statistic-value text-warning">8</div>
                            <div class="statistic-label">Menunggu Antrean</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="card card-dashboard text-center">
                        <div class="card-body">
                            <i class="fas fa-check-circle card-icon"></i>
                            <div class="statistic-value text-primary">27</div>
                            <div class="statistic-label">Pelayanan Selesai</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-dashboard mb-3" data-aos="fade-up" data-aos-delay="500">
                <div class="card-header">
                    <i class="fas fa-list-ol me-1"></i> Antrean Pasien Saat Ini
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-responsive-custom">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No. Antrean</th>
                                    <th>Nama Pasien</th>
                                    <th>Pelayanan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-aos="fade-in" data-aos-delay="600">
                                    <td>A001</td>
                                    <td>Budi Santoso</td>
                                    <td>Pemeriksaan Umum</td>
                                    <td><span class="badge bg-warning">Menunggu</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary me-1"><i class="fas fa-bell"></i></button>
                                        <button class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                                    </td>
                                </tr>
                                <tr data-aos="fade-in" data-aos-delay="700">
                                    <td>A002</td>
                                    <td>Siti Aminah</td>
                                    <td>Imunisasi</td>
                                    <td><span class="badge bg-warning">Menunggu</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary me-1"><i class="fas fa-bell"></i></button>
                                        <button class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                                    </td>
                                </tr>
                                <tr data-aos="fade-in" data-aos-delay="800">
                                    <td>A003</td>
                                    <td>Joko Susilo</td>
                                    <td>Kesehatan Gigi</td>
                                    <td><span class="badge bg-info">Dipanggil</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                                    </td>
                                </tr>
                                <tr data-aos="fade-in" data-aos-delay="900">
                                    <td>A004</td>
                                    <td>Ani Nurmala</td>
                                    <td>KIA</td>
                                    <td><span class="badge bg-warning">Menunggu</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary me-1"><i class="fas fa-bell"></i></button>
                                        <button class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                                    </td>
                                </tr>
                                <tr data-aos="fade-in" data-aos-delay="1000">
                                    <td>A005</td>
                                    <td>Rudi Hartono</td>
                                    <td>Konsultasi</td>
                                    <td><span class="badge bg-success">Selesai</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-print"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="1100">
                    <div class="card card-dashboard">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i> Kunjungan Harian
                        </div>
                        <div class="card-body p-2">
                            <div style="height: 250px; display: flex; align-items: center; justify-content: center; color: #6c757d; font-style: italic;">
                                Grafik Kunjungan Harian
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="1200">
                    <div class="card card-dashboard">
                        <div class="card-header">
                            <i class="fas fa-pie-chart me-1"></i> Layanan Terpopuler
                        </div>
                        <div class="card-body p-2">
                            <div style="height: 250px; display: flex; align-items: center; justify-content: center; color: #6c757d; font-style: italic;">
                                Grafik Jenis Layanan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-dashboard mt-3" data-aos="fade-up" data-aos-delay="1300">
                <div class="card-header">
                    <i class="fas fa-user-injured me-1"></i> Pasien Terbaru
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-responsive-custom">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Pasien</th>
                                    <th>NIK</th>
                                    <th>BPJS</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-aos="fade-in" data-aos-delay="1400">
                                    <td>Dewi Lestari</td>
                                    <td>1234567890123456</td>
                                    <td><span class="badge bg-success">Aktif</span></td>
                                    <td>25/06/25</td>
                                    <td><button class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></button></td>
                                </tr>
                                <tr data-aos="fade-in" data-aos-delay="1500">
                                    <td>Rio Pratama</td>
                                    <td>6543210987654321</td>
                                    <td><span class="badge bg-secondary">Non Aktif</span></td>
                                    <td>24/06/25</td>
                                    <td><button class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></button></td>
                                </tr>
                                <tr data-aos="fade-in" data-aos-delay="1600">
                                    <td>Fitriani</td>
                                    <td>1122334455667788</td>
                                    <td><span class="badge bg-success">Aktif</span></td>
                                    <td>24/06/25</td>
                                    <td><button class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></button></td>
                                </tr>
                                <tr data-aos="fade-in" data-aos-delay="1700">
                                    <td>Andi Wijaya</td>
                                    <td>9988776655443322</td>
                                    <td><span class="badge bg-success">Aktif</span></td>
                                    <td>23/06/25</td>
                                    <td><button class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></button></td>
                                </tr>
                                <tr data-aos="fade-in" data-aos-delay="1800">
                                    <td>Sri Rahayu</td>
                                    <td>5566778899001122</td>
                                    <td><span class="badge bg-secondary">Non Aktif</span></td>
                                    <td>23/06/25</td>
                                    <td><button class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            mirror: false,
            duration: 800,
            easing: 'ease-in-out',
        });

        // Script untuk toggle sidebar
        document.getElementById('sidebarCollapse').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });

        document.getElementById('sidebarToggleDesktop').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });

        // Current Date & Time
        function updateDateTime() {
            const now = new Date();
            const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            document.getElementById('currentDateTime').textContent = now.toLocaleDateString('id-ID', options);
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
</body>
</html>