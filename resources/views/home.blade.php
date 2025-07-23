<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puskesmas Nanggalo Siteba - Pelayanan Kesehatan Prima</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
</head>
<body>

    {{-- header --}}
    @include('layouts.frontend.navbar')

    <main>

        {{-- hero section / jumbotron --}}
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

        <section id="tentang-kami" class="section-padding bg-light">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Tentang Puskesmas Kami</h2>
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right" data-aos-duration="1000">
                        <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" class="img-fluid about-us-img" alt="Gedung Puskesmas">
                    </div>
                    <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000">
                        <h3 class="mb-4">Puskesmas Nanggalo Siteba: Komitmen Kami untuk Kesehatan Masyarakat</h3>
                        <p class="mb-3">Kami hadir untuk memberikan pelayanan kesehatan primer yang komprehensif dan berkualitas bagi seluruh masyarakat. Dengan sistem yang terintegrasi, kami memastikan proses pendaftaran dan pelayanan berjalan efisien dan transparan. </p>
                        <p class="mb-3">Fokus kami adalah pada kemudahan akses, mulai dari pendaftaran pasien baru hingga pencatatan riwayat kunjungan, semuanya terkelola dengan baik untuk menunjang pelayanan optimal. </p>
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
                                <p class="card-text">Daftar sebagai pasien baru atau cek riwayat Anda dengan sistem yang intuitif. Dapatkan nomor antrean digital Anda segera. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="200">
                        <div class="card services-card">
                            <div class="card-body text-center">
                                <i class="fas fa-user-md mb-3"></i>
                                <h5 class="card-title">Pelayanan Medis Umum</h5>
                                <p class="card-text">Konsultasi dengan dokter umum, pemeriksaan kesehatan, dan penanganan penyakit ringan oleh tim profesional. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card services-card">
                            <div class="card-body text-center">
                                <i class="fas fa-syringe mb-3"></i>
                                <h5 class="card-title">Imunisasi & Vaksinasi</h5>
                                <p class="card-text">Program imunisasi lengkap untuk anak-anak dan dewasa sesuai jadwal yang direkomendasikan. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="400">
                        <div class="card services-card">
                            <div class="card-body text-center">
                                <i class="fas fa-baby mb-3"></i>
                                <h5 class="card-title">Kesehatan Ibu & Anak (KIA)</h5>
                                <p class="card-text">Pelayanan komprehensif untuk ibu hamil, melahirkan, nifas, serta kesehatan bayi dan balita. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="500">
                        <div class="card services-card">
                            <div class="card-body text-center">
                                <i class="fas fa-tooth mb-3"></i>
                                <h5 class="card-title">Pelayanan Kesehatan Gigi</h5>
                                <p class="card-text">Pemeriksaan gigi, scaling, penambalan, dan pencabutan gigi yang ditangani oleh dokter gigi. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="600">
                        <div class="card services-card">
                            <div class="card-body text-center">
                                <i class="fas fa-chart-line mb-3"></i>
                                <h5 class="card-title">Laporan Kunjungan Harian</h5>
                                <p class="card-text">Sistem kami menyediakan laporan jumlah kunjungan harian dan statistik layanan terpopuler untuk optimalisasi pelayanan. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="call-to-action">
            <div class="container" data-aos="fade-up" data-aos-duration="1000">
                <h2>Siap Mendapatkan Pelayanan Kesehatan Terbaik?</h2>
                <p class="lead">Jangan tunda lagi, kunjungi Puskesmas Nanggalo Siteba atau daftar online untuk pengalaman yang lebih cepat dan mudah.</p>
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
                            <li class="list-group-item bg-light py-3"><i class="far fa-clock me-2 text-primary"></i>
                                Senin - Jumat: 07:30 - 14:30 WIB
                            </li>
                            <li class="list-group-item bg-light py-3"><i class="far fa-clock me-2 text-primary"></i>
                                Sabtu: 07:30 - 14:30 WIB
                            </li>
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
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="100">
                                <div class="feature-box">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <h5>Alamat</h5>
                                    <p>Jl. Padang Perumnas Siteba, Kel. Surau Gadang, Nanggalo, Padang City, West Sumatra 25173</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="200">
                                <div class="feature-box">
                                    <i class="fas fa-phone"></i>
                                    <h5>Telepon</h5>
                                    <p>(0751) 7878690</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="300">
                                <div class="feature-box">
                                    <i class="fas fa-envelope"></i>
                                    <h5>Email</h5>
                                    <p>puskesmasnanggalo_hcn@yahoo.co.id</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="400">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.333007161956!2d100.36442507411306!3d-0.8936686353212636!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b8a12e7e5d7f%3A0xedf8981f66b9b5ff!2sPuskesmas%20Nanggalo%20Siteba!5e0!3m2!1sid!2sid!4v1750951674254!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    {{-- footer --}}
    @include('layouts.frontend.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('frontend/js/script.js') }}"></script>
</body>
</html>