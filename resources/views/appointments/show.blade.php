@extends('layouts.dashboard')

@section('title')
    Detail Catatan Pelayanan - {{ $appointment->registration->patientDetail->user->name ?? 'N/A' }}
@endsection

@section('sub_title')
    Detail Catatan Pelayanan
@endsection

@section('content')
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header">
        <i class="fas fa-info-circle me-1"></i> Informasi Detail Catatan Pelayanan
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4"><strong>Nomor Antrean:</strong></div>
            <div class="col-md-8">{{ sprintf('%03d', $appointment->registration->queue_number ?? 'N/A') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Nama Pasien:</strong></div>
            <div class="col-md-8">{{ $appointment->registration->patientDetail->user->name ?? 'N/A' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Tanggal Kunjungan Pendaftaran:</strong></div>
            <div class="col-md-8">{{ $appointment->registration->visit_date->format('d M Y') ?? 'N/A' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Petugas yang Melayani:</strong></div>
            <div class="col-md-8">{{ $appointment->user->name ?? 'N/A' }} ({{ Str::title($appointment->user->role ?? 'N/A') }})</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Jenis Layanan:</strong></div>
            <div class="col-md-8">{{ $appointment->service->name ?? 'N/A' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Deskripsi Layanan:</strong></div>
            <div class="col-md-8">{{ $appointment->service->description ?? '-' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Catatan Pelayanan:</strong></div>
            <div class="col-md-8">{!! nl2br(e($appointment->notes ?? '-')) !!}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Dibuat Pada:</strong></div>
            <div class="col-md-8">{{ $appointment->created_at->format('d M Y, H:i') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Terakhir Diperbarui:</strong></div>
            <div class="col-md-8">{{ $appointment->updated_at->format('d M Y, H:i') }}</div>
        </div>

        <hr class="my-4">
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary me-2">Kembali ke Daftar Catatan Pelayanan</a>
        <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-primary">Edit Catatan Pelayanan Ini</a>
    </div>
</div>
@endsection
