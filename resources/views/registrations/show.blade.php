@extends('layouts.dashboard') {{-- TETAPKAN INI: Meng-extend 'layouts.dashboard' --}}

@section('title')
    Detail Pendaftaran - No. {{ sprintf('%03d', $registration->queue_number) }}
@endsection

@section('sub_title')
    Detail Pendaftaran & Antrean
@endsection

@section('content')
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header">
        <i class="fas fa-info-circle me-1"></i> Informasi Detail Pendaftaran: No. {{ sprintf('%03d', $registration->queue_number) }}
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4"><strong>Nomor Antrean:</strong></div>
            <div class="col-md-8">{{ sprintf('%03d', $registration->queue_number) }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Tanggal Kunjungan:</strong></div>
            <div class="col-md-8">{{ $registration->visit_date->format('d M Y') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Nama Pasien:</strong></div>
            <div class="col-md-8">{{ $registration->patientDetail->user->name ?? 'N/A' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>NIK Pasien:</strong></div>
            <div class="col-md-8">{{ $registration->patientDetail->nik ?? 'N/A' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Jenis Layanan:</strong></div>
            <div class="col-md-8">{{ $registration->service->name ?? 'N/A' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Deskripsi Layanan:</strong></div>
            <div class="col-md-8">{{ $registration->service->description ?? '-' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Status Pendaftaran:</strong></div>
            <div class="col-md-8">
                <span class="badge {{
                    $registration->status == 'pending' ? 'bg-warning' :
                    ($registration->status == 'completed' ? 'bg-success' :
                    ($registration->status == 'cancelled' ? 'bg-danger' : 'bg-secondary'))
                }}">
                    {{ Str::title($registration->status) }}
                </span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Status Antrean:</strong></div>
            <div class="col-md-8">
                <span class="badge {{
                    $registration->queue->status == 'waiting' ? 'bg-secondary' :
                    ($registration->queue->status == 'called' ? 'bg-primary' :
                    ($registration->queue->status == 'completed' ? 'bg-success' :
                    ($registration->queue->status == 'skipped' ? 'bg-info' : 'bg-danger')))
                }}">
                    {{ Str::title($registration->queue->status ?? 'N/A') }}
                </span>
            </div>
        </div>
        @if($registration->trashed())
            <div class="row mb-3">
                <div class="col-md-4"><strong>Dibatalkan Pada:</strong></div>
                <div class="col-md-8">{{ $registration->deleted_at->format('d M Y, H:i') }}</div>
            </div>
        @endif
        <div class="row mb-3">
            <div class="col-md-4"><strong>Dibuat Pada:</strong></div>
            <div class="col-md-8">{{ $registration->created_at->format('d M Y, H:i') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Terakhir Diperbarui:</strong></div>
            <div class="col-md-8">{{ $registration->updated_at->format('d M Y, H:i') }}</div>
        </div>

        <hr class="my-4">
        <a href="{{ route('registrations.index') }}" class="btn btn-secondary me-2">Kembali ke Daftar Pendaftaran</a>
        {{-- Edit button only appears if not soft deleted and not completed --}}
        @if(!$registration->trashed() && $registration->queue && $registration->queue->status !== 'completed')
            <a href="{{ route('registrations.edit', $registration->id) }}" class="btn btn-primary">Edit Status Antrean Ini</a>
        @endif
    </div>
</div>
@endsection
