<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puskesmas Sehat Selalu - Pelayanan Kesehatan Prima</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #28a745; /* Hijau Puskesmas */
            --secondary-color: #007bff; /* Biru */
            --dark-color: #343a40;
            --light-color: #f8f9fa;
        }

        body {
            font-family: 'Jost', sans-serif;
            line-height: 1.6;
            color: var(--dark-color);
        }

        .navbar {
            background-color: var(--primary-color) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }

        .navbar-brand, .nav-link {
            color: var(--light-color) !important;
            font-weight: 600;
        }

        .navbar-brand {
            font-size: 1.3rem;
        }

        .navbar-brand:hover, .nav-link:hover {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover;
            color: white;
            padding: 120px 0;
            text-align: center;
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 60px;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 25px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: 35px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-custom-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transition: all 0.3s ease;
            padding: 12px 30px;
            font-weight: 500;
            border-radius: 50px;
            letter-spacing: 0.5px;
        }

        .btn-custom-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .section-padding {
            padding: 100px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 70px;
            font-weight: 700;
            color: var(--primary-color);
            position: relative;
            font-size: 2.5rem;
        }

        .section-title:after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: var(--primary-color);
            margin: 15px auto;
            border-radius: 2px;
        }

        .feature-box {
            text-align: center;
            padding: 35px 25px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            margin-bottom: 30px;
            background-color: white;
            height: 100%;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .feature-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.12);
            border-color: rgba(40, 167, 69, 0.2);
        }

        .feature-box i {
            font-size: 3.5rem;
            color: var(--primary-color);
            margin-bottom: 25px;
        }

        .feature-box h5 {
            font-weight: 600;
            margin-bottom: 15px;
        }

        .about-us-img {
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .about-us-img:hover {
            transform: scale(1.02);
        }

        .services-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            transition: all 0.4s ease;
            background-color: white;
            height: 100%;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .services-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
            border-color: rgba(40, 167, 69, 0.2);
        }

        .services-card .card-body {
            padding: 30px;
        }

        .services-card .card-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        .services-card i {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .call-to-action {
            background-color: var(--secondary-color);
            color: white;
            padding: 80px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .call-to-action:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1581056771107-24ca5f033842?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') center/cover;
            opacity: 0.1;
            z-index: 0;
        }

        .call-to-action .container {
            position: relative;
            z-index: 1;
        }

        .call-to-action h2 {
            font-size: 2.8rem;
            margin-bottom: 25px;
            font-weight: 700;
        }

        .call-to-action p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 30px;
        }

        footer {
            background-color: var(--dark-color);
            color: var(--light-color);
            padding: 70px 0 30px;
        }

        footer h5 {
            color: var(--primary-color);
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 1.3rem;
        }

        footer p, footer a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: var(--primary-color);
        }

        .footer-social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 1.2rem;
            margin-right: 10px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .footer-social-icons a:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }

        /* Carousel styles */
        .carousel {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 50px;
        }

        .carousel-item img {
            height: 500px;
            object-fit: cover;
        }

        .carousel-caption {
            background: rgba(0,0,0,0.6);
            border-radius: 10px;
            padding: 20px;
            bottom: 40px;
            left: 10%;
            right: 10%;
        }

        /* Responsiveness adjustments */
        @media (max-width: 992px) {
            .hero-section {
                padding: 100px 0;
                min-height: 60vh;
            }
            
            .hero-section h1 {
                font-size: 2.8rem;
            }
            
            .section-padding {
                padding: 80px 0;
            }
            
            .carousel-item img {
                height: 400px;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 80px 0;
                min-height: 50vh;
                margin-top: 56px;
            }
            
            .hero-section h1 {
                font-size: 2.2rem;
            }
            
            .hero-section p {
                font-size: 1.1rem;
            }
            
            .section-padding {
                padding: 60px 0;
            }
            
            .section-title {
                font-size: 2rem;
                margin-bottom: 50px;
            }
            
            .carousel-item img {
                height: 300px;
            }
            
            .call-to-action h2 {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 576px) {
            .hero-section h1 {
                font-size: 1.8rem;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            .call-to-action h2 {
                font-size: 1.8rem;
            }
            
            .carousel-item img {
                height: 250px;
            }
        }
    </style>
</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand animate__animated animate__fadeInLeft" href="#">
                    <i class="fas fa-hospital me-2" style="font-size: 1.8rem;"></i>
                    Puskesmas Sehat Selalu
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                        <li class="nav-item">
                            <a class="nav-link btn btn-light text-primary ms-lg-3 animate__animated animate__fadeInRight" href="{{ route('login') }}">Login Petugas</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section id="beranda" class="hero-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mx-auto" data-aos="fade-up" data-aos-duration="1500">
                        <h1 class="animate__animated animate__fadeInDown">Melayani Dengan Hati, Untuk Kesehatan Optimal Anda</h1>
                        <p class="animate__animated animate__fadeInUp">Sistem Pendaftaran & Pelayanan Puskesmas yang Modern, Cepat, dan Ramah Masyarakat. Prioritas kami adalah kemudahan akses kesehatan bagi Anda.</p>
                        <a href="#layanan" class="btn btn-lg btn-custom-primary animate__animated animate__zoomIn">Jelajahi Layanan Kami <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Carousel Section -->
        {{-- <section class="section-padding">
            <div class="container">
                <div id="puskesmasCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#puskesmasCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#puskesmasCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#puskesmasCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner rounded">
                        <div class="carousel-item active">
                            <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" class="d-block w-100" alt="Pelayanan Puskesmas">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Pelayanan Kesehatan Terbaik</h5>
                                <p>Tim medis profesional siap melayani Anda dengan sepenuh hati.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" class="d-block w-100" alt="Fasilitas Puskesmas">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Fasilitas Modern</h5>
                                <p>Peralatan medis terkini untuk diagnosis dan perawatan yang akurat.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="https://images.unsplash.com/photo-1505751172876-fa1923c5c528?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" class="d-block w-100" alt="Kegiatan Puskesmas">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Program Kesehatan Masyarakat</h5>
                                <p>Berbagai program untuk meningkatkan kesehatan masyarakat.</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#puskesmasCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#puskesmasCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </section> --}}

        <section id="tentang-kami" class="section-padding bg-light">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Tentang Puskesmas Kami</h2>
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right" data-aos-duration="1000">
                        <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" class="img-fluid about-us-img" alt="Gedung Puskesmas">
                    </div>
                    <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000">
                        <h3 class="mb-4">Puskesmas Sehat Selalu: Komitmen Kami untuk Kesehatan Masyarakat</h3>
                        <p class="mb-3">Kami hadir untuk memberikan pelayanan kesehatan primer yang komprehensif dan berkualitas bagi seluruh masyarakat. Dengan sistem yang terintegrasi, kami memastikan proses pendaftaran dan pelayanan berjalan efisien dan transparan. </p>
                        <p class="mb-3">Fokus kami adalah pada kemudahan akses, mulai dari pendaftaran pasien baru hingga pencatatan riwayat kunjungan, semuanya terkelola dengan baik untuk menunjang pelayanan optimal. [cite: 1, 2, 7, 8, 9]</p>
                        <p class="mb-4">Tim medis dan staf kami yang profesional siap melayani Anda dengan sepenuh hati, menjadikan pengalaman Anda di Puskesmas nyaman dan efektif.</p>
                        <a href="#" class="btn btn-outline-primary btn-lg">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="layanan" class="section-padding">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Layanan Unggulan Kami</h2>
                <div class="row">
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                        <div class="card services-card">
                            <div class="card-body text-center">
                                <i class="fas fa-notes-medical mb-3"></i>
                                <h5 class="card-title">Pendaftaran Cepat & Mudah</h5>
                                <p class="card-text">Daftar sebagai pasien baru atau cek riwayat Anda dengan sistem yang intuitif. Dapatkan nomor antrean digital Anda segera. [cite: 2, 7]</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="200">
                        <div class="card services-card">
                            <div class="card-body text-center">
                                <i class="fas fa-user-md mb-3"></i>
                                <h5 class="card-title">Pelayanan Medis Umum</h5>
                                <p class="card-text">Konsultasi dengan dokter umum, pemeriksaan kesehatan, dan penanganan penyakit ringan oleh tim profesional. [cite: 6]</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card services-card">
                            <div class="card-body text-center">
                                <i class="fas fa-syringe mb-3"></i>
                                <h5 class="card-title">Imunisasi & Vaksinasi</h5>
                                <p class="card-text">Program imunisasi lengkap untuk anak-anak dan dewasa sesuai jadwal yang direkomendasikan. [cite: 2, 6, 12, 13]</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="400">
                        <div class="card services-card">
                            <div class="card-body text-center">
                                <i class="fas fa-baby mb-3"></i>
                                <h5 class="card-title">Kesehatan Ibu & Anak (KIA)</h5>
                                <p class="card-text">Pelayanan komprehensif untuk ibu hamil, melahirkan, nifas, serta kesehatan bayi dan balita. [cite: 2, 6]</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="500">
                        <div class="card services-card">
                            <div class="card-body text-center">
                                <i class="fas fa-tooth mb-3"></i>
                                <h5 class="card-title">Pelayanan Kesehatan Gigi</h5>
                                <p class="card-text">Pemeriksaan gigi, scaling, penambalan, dan pencabutan gigi yang ditangani oleh dokter gigi. [cite: 2, 6]</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="600">
                        <div class="card services-card">
                            <div class="card-body text-center">
                                <i class="fas fa-chart-line mb-3"></i>
                                <h5 class="card-title">Laporan Kunjungan Harian</h5>
                                <p class="card-text">Sistem kami menyediakan laporan jumlah kunjungan harian dan statistik layanan terpopuler untuk optimalisasi pelayanan. [cite: 5, 6, 9]</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="call-to-action">
            <div class="container" data-aos="fade-up" data-aos-duration="1000">
                <h2>Siap Mendapatkan Pelayanan Kesehatan Terbaik?</h2>
                <p class="lead">Jangan tunda lagi, kunjungi Puskesmas Sehat Selalu atau daftar online untuk pengalaman yang lebih cepat dan mudah.</p>
                <a href="#pendaftaran-online" class="btn btn-lg btn-light text-secondary mt-3 animate__animated animate__pulse animate__infinite">Daftar Sekarang! <i class="fas fa-clipboard-list ms-2"></i></a>
            </div>
        </section>

        <section id="informasi" class="section-padding bg-light">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Informasi Penting</h2>
                <div class="row">
                    <div class="col-lg-6 mb-4" data-aos="fade-right" data-aos-delay="100">
                        <h4 class="mb-4">Jam Operasional</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-light py-3"><i class="far fa-clock me-2 text-primary"></i>Senin - Jumat: 08:00 - 16:00 WIB</li>
                            <li class="list-group-item bg-light py-3"><i class="far fa-clock me-2 text-primary"></i>Sabtu: 08:00 - 13:00 WIB</li>
                            <li class="list-group-item bg-light py-3"><i class="far fa-clock me-2 text-primary"></i>Minggu & Hari Libur Nasional: Tutup</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 mb-4" data-aos="fade-left" data-aos-delay="200">
                        <h4 class="mb-4">Persyaratan Pendaftaran</h4>
                        <p class="mb-3">Pastikan Anda membawa:</p>
                        <ul class="mb-3">
                            <li class="mb-2"><i class="fas fa-check-circle me-2 text-primary"></i>Kartu Tanda Penduduk (KTP) / Kartu Keluarga (KK)</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2 text-primary"></i>Kartu BPJS (jika ada dan berstatus aktif)</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2 text-primary"></i>Surat rujukan (jika dari fasilitas kesehatan lain)</li>
                        </ul>
                        <p class="small text-muted">Untuk informasi lebih lanjut, silakan hubungi pusat informasi kami.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="kontak" class="section-padding">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Hubungi Kami</h2>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="100">
                                <div class="feature-box">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <h5>Alamat</h5>
                                    <p>Jl. Kesehatan No. 123, Kota Padang, Sumatera Barat</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="200">
                                <div class="feature-box">
                                    <i class="fas fa-phone"></i>
                                    <h5>Telepon</h5>
                                    <p>(0751) 123456</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="300">
                                <div class="feature-box">
                                    <i class="fas fa-envelope"></i>
                                    <h5>Email</h5>
                                    <p>info@puskesmassehatselalu.co.id</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="400">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.288289569687!2d100.35411781475765!3d-0.9452329994680854!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b92b6a9d901b%3A0x6b7a5a8e0d3c0c1b!2sPadang%2C%20West%20Sumatra!5e0!3m2!1sen!2sid!4v1719451152932!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="text-center text-md-start">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="100">
                    <h5>Puskesmas Sehat Selalu</h5>
                    <p class="mb-4">Dedikasi kami untuk memberikan pelayanan kesehatan terbaik dan terdepan bagi masyarakat Padang dan sekitarnya.</p>
                    <div class="footer-social-icons">
                        <a href="#" class="me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="200">
                    <h5>Link Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#beranda"><i class="fas fa-chevron-right me-2"></i>Beranda</a></li>
                        <li class="mb-2"><a href="#tentang-kami"><i class="fas fa-chevron-right me-2"></i>Tentang Kami</a></li>
                        <li class="mb-2"><a href="#layanan"><i class="fas fa-chevron-right me-2"></i>Layanan</a></li>
                        <li class="mb-2"><a href="#informasi"><i class="fas fa-chevron-right me-2"></i>Informasi</a></li>
                        <li class="mb-2"><a href="#kontak"><i class="fas fa-chevron-right me-2"></i>Kontak</a></li>
                        <li class="mb-2"><a href="{{ route('login') }}"><i class="fas fa-chevron-right me-2"></i>Login Petugas</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="300">
                    <h5>Informasi Kontak</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="fas fa-map-marker-alt me-2"></i>Jl. Kesehatan No. 123, Padang</li>
                        <li class="mb-3"><i class="fas fa-phone me-2"></i>(0751) 123456</li>
                        <li class="mb-3"><i class="fas fa-envelope me-2"></i>info@puskesmassehatselalu.co.id</li>
                        <li class="mb-3"><i class="fas fa-clock me-2"></i>Senin-Jumat: 08:00-16:00</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; 2025 Puskesmas Sehat Selalu. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            mirror: false,
            duration: 1000,
            easing: 'ease-in-out',
        });

        // Smooth scrolling for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Auto-rotate carousel every 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            var myCarousel = document.querySelector('#puskesmasCarousel');
            var carousel = new bootstrap.Carousel(myCarousel, {
                interval: 5000,
                wrap: true
            });
        });
    </script>
</body>
</html>