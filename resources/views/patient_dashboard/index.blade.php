@extends('layouts.dashboard') {{-- Anda bisa membuat layout terpisah untuk pasien jika ingin --}}

@section('title')
    Dashboard Pasien - Puskesmas Nanggalo Siteba
@endsection

@section('sub_title')
    Ringkasan Akun Anda
@endsection

@section('content')
<div class="row mb-3 g-3">
    <div class="col-12" data-aos="fade-up" data-aos-delay="100">
        <div class="card card-dashboard">
            <div class="card-body">
                <h4 class="mb-3">Halo, {{ $user->name ?? 'Pasien' }}! Selamat datang di Dashboard Anda.</h4>
                
                @if(!$isProfileComplete)
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>
                            Profil Anda belum lengkap! Mohon lengkapi data diri Anda <a href="{{ route('patient.profile.edit') }}" class="alert-link">di sini</a> untuk dapat menggunakan semua fitur pendaftaran layanan.
                        </div>
                    </div>
                @else
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>
                            Profil Anda sudah lengkap. Anda siap untuk melakukan pendaftaran layanan!
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Kartu Statistik Ringkasan --}}
    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card card-dashboard text-center">
            <div class="card-body">
                <i class="fas fa-calendar-check card-icon"></i>
                <div class="statistic-value text-info">
                    {{ $upcomingRegistrations->count() }}
                </div>
                <div class="statistic-label">Pendaftaran Mendatang</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
        <div class="card card-dashboard text-center">
            <div class="card-body">
                <i class="fas fa-history card-icon"></i>
                <div class="statistic-value text-primary">
                    {{ $recentVisits->count() }}
                </div>
                <div class="statistic-label">Kunjungan Terakhir</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
        <div class="card card-dashboard text-center">
            <div class="card-body">
                <i class="fas fa-user-injured card-icon"></i>
                <div class="statistic-value text-success">
                    {{ $patientDetail ? ($patientDetail->nik ? 'Lengkap' : 'Belum') : 'Belum' }}
                </div>
                <div class="statistic-label">Status Profil</div>
            </div>
        </div>
    </div>
</div>

{{-- Tombol Daftar Layanan --}}
<div class="card card-dashboard mb-3" data-aos="fade-up" data-aos-delay="600">
    <div class="card-header">
        <i class="fas fa-hand-point-right me-1"></i> Pendaftaran Layanan
    </div>
    <div class="card-body text-center">
        @if($isProfileComplete)
            <a href="{{ route('patient.registrations.create') }}" class="btn btn-action-primary btn-lg">
                <i class="fas fa-plus-circle me-2"></i> Daftar Layanan Sekarang
            </a>
        @else
            <button class="btn btn-secondary btn-lg" disabled title="Lengkapi profil Anda untuk mendaftar layanan">
                <i class="fas fa-plus-circle me-2"></i> Daftar Layanan (Profil Belum Lengkap)
            </button>
        @endif
    </div>
</div>

{{-- Tabel Pendaftaran Mendatang --}}
<div class="card card-dashboard mb-3" data-aos="fade-up" data-aos-delay="700">
    <div class="card-header">
        <i class="fas fa-list-ol me-1"></i> Pendaftaran Mendatang Anda
    </div>
    <div class="card-body p-0">
        <div class="table-responsive table-responsive-custom">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No. Antrean</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Layanan</th>
                        <th>Status Antrean</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($upcomingRegistrations as $registration)
                    <tr data-aos="fade-in" data-aos-delay="{{ 800 + ($loop->index * 100) }}">
                        <td>{{ sprintf('%03d', $registration->queue_number) }}</td>
                        <td>{{ $registration->visit_date->format('d M Y') }}</td>
                        <td>{{ $registration->service->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{
                                $registration->queue->status == 'waiting' ? 'bg-warning' :
                                ($registration->queue->status == 'called' ? 'bg-info' : 'bg-secondary')
                            }}">
                                {{ Str::title($registration->queue->status ?? '-') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('patient.registrations.show', $registration->id) }}" class="btn btn-sm btn-info me-1" title="Detail Pendaftaran"><i class="fas fa-eye"></i></a>
                            {{-- Tombol Cetak Antrean Pasien --}}
                            @if($registration->queue && $registration->queue->status !== 'cancelled')
                                <a href="{{ route('patient.registrations.print', $registration->id) }}" target="_blank" class="btn btn-sm btn-primary" title="Cetak Antrean"><i class="fas fa-print"></i></a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Tidak ada pendaftaran mendatang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Tabel Riwayat Kunjungan Terakhir --}}
<div class="card card-dashboard mt-3" data-aos="fade-up" data-aos-delay="1200">
    <div class="card-header">
        <i class="fas fa-history me-1"></i> Riwayat Kunjungan Terakhir Anda
    </div>
    <div class="card-body p-0">
        <div class="table-responsive table-responsive-custom">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Tanggal Kunjungan</th>
                        <th>Layanan</th>
                        <th>Status Kunjungan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentVisits as $visit)
                    <tr data-aos="fade-in" data-aos-delay="{{ 1300 + ($loop->index * 100) }}">
                        <td>{{ $visit->visit_date->format('d M Y') }}</td>
                        <td>{{ $visit->service->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{
                                $visit->status == 'completed' ? 'bg-success' :
                                ($visit->status == 'canceled' ? 'bg-danger' : 'bg-secondary')
                            }}">
                                {{ Str::title($visit->status) }}
                            </span>
                        </td>
                        <td>
                            {{-- Tombol Detail Riwayat Kunjungan Pasien --}}
                            <a href="{{ route('patient.visits.show', $visit->id) }}" class="btn btn-sm btn-info" title="Detail Kunjungan"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">Tidak ada riwayat kunjungan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
