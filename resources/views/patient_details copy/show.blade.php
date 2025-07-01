@extends('layouts.dashboard')

@section('title')
    Detail Pasien - {{ $patient->name }}
@endsection

@section('sub_title')
    Detail Pasien: {{ $patient->name }}
@endsection

@section('content')
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header">
        <i class="fas fa-user-injured me-1"></i> Informasi Detail Pasien: {{ $patient->name }}
    </div>
    <div class="card-body">
        {{-- Data Akun Pasien (dari tabel users) --}}
        <h6 class="mb-3 text-primary"><i class="fas fa-user-circle me-1"></i> Data Akun</h6>
        <div class="row mb-3 mt-3">
            <div class="col-md-3"><strong>Nama Lengkap:</strong></div>
            <div class="col-md-9">{{ $patient->name }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Email:</strong></div>
            <div class="col-md-9">{{ $patient->email }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Role:</strong></div>
            <div class="col-md-9">
                <span class="badge bg-secondary">{{ Str::title($patient->role) }}</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Dibuat Pada:</strong></div>
            <div class="col-md-9">{{ $patient->created_at->format('d M Y, H:i') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Terakhir Diperbarui:</strong></div>
            <div class="col-md-9">{{ $patient->updated_at->format('d M Y, H:i') }}</div>
        </div>

        <hr class="my-4">

        {{-- Data Demografi Pasien (dari tabel patient_details) --}}
        <h6 class="mb-3 text-primary"><i class="fas fa-id-card-alt me-1"></i> Data Demografi</h6>
        @if($patient->patientDetail)
        <div class="row mb-3 mt-3">
            <div class="col-md-3"><strong>NIK:</strong></div>
            <div class="col-md-9">{{ $patient->patientDetail->nik }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Alamat:</strong></div>
            <div class="col-md-9">{{ $patient->patientDetail->address }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Tanggal Lahir:</strong></div>
            <div class="col-md-9">{{ $patient->patientDetail->birth_date->format('d M Y') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Nomor HP:</strong></div>
            <div class="col-md-9">{{ $patient->patientDetail->phone_number }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Jenis Kelamin:</strong></div>
            <div class="col-md-9">{{ $patient->patientDetail->gender }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Status BPJS:</strong></div>
            <div class="col-md-9">{{ $patient->patientDetail->bpjs_status ? 'Aktif' : 'Tidak Aktif' }}</div>
        </div>
        @else
        <div class="alert alert-warning mt-3">
            <i class="fas fa-exclamation-triangle me-1"></i> Data demografi pasien belum lengkap.
        </div>
        @endif

        <hr class="my-4">
        <a href="{{ route('patients.index') }}" class="btn btn-secondary me-2">Kembali ke Daftar Pasien</a>
        <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary">Edit Data Pasien Ini</a>
    </div>
</div>
@endsection