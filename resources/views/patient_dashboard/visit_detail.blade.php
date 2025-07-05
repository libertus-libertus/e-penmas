@extends('layouts.dashboard')

@section('title')
    Detail Kunjungan Anda - {{ $patientVisit->visit_date->format('d M Y') }}
@endsection

@section('sub_title')
    Detail Riwayat Kunjungan Anda
@endsection

@section('content')
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header">
        <i class="fas fa-info-circle me-1"></i> Informasi Detail Kunjungan Anda
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4"><strong>Nama Pasien:</strong></div>
            <div class="col-md-8">{{ $patientVisit->patientDetail->user->name ?? 'N/A' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>NIK Pasien:</strong></div>
            <div class="col-md-8">{{ $patientVisit->patientDetail->nik ?? 'N/A' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Tanggal Kunjungan:</strong></div>
            <div class="col-md-8">{{ $patientVisit->visit_date->format('d M Y') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Layanan:</strong></div>
            <div class="col-md-8">{{ $patientVisit->service->name ?? 'N/A' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Deskripsi Layanan:</strong></div>
            <div class="col-md-8">{{ $patientVisit->service->description ?? '-' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Status Kunjungan:</strong></div>
            <div class="col-md-8">
                <span class="badge {{
                    $patientVisit->status == 'completed' ? 'bg-success' :
                    ($patientVisit->status == 'canceled' ? 'bg-danger' : 'bg-secondary')
                }}">
                    {{ Str::title($patientVisit->status) }}
                </span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Dibuat Pada:</strong></div>
            <div class="col-md-8">{{ $patientVisit->created_at->format('d M Y, H:i') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Terakhir Diperbarui:</strong></div>
            <div class="col-md-8">{{ $patientVisit->updated_at->format('d M Y, H:i') }}</div>
        </div>

        <hr class="my-4">
        <a href="{{ route('patient.dashboard') }}" class="btn btn-secondary me-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
        {{-- Tombol Edit Status Kunjungan (opsional, jika pasien diizinkan mengubah status riwayat) --}}
        {{-- <a href="{{ route('patient.visits.edit', $patientVisit->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Status
        </a> --}}
    </div>
</div>
@endsection
