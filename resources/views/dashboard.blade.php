@extends('layouts.dashboard')

@section('title')
    Dashboard Petugas Puskesmas Nanggalo Siteba
@endsection

@section('sub_title')
    Ringkasan Dashboard
@endsection

@section('content')
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
                <div
                    style="height: 250px; display: flex; align-items: center; justify-content: center; color: #6c757d; font-style: italic;">
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
                <div
                    style="height: 250px; display: flex; align-items: center; justify-content: center; color: #6c757d; font-style: italic;">
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
@endsection