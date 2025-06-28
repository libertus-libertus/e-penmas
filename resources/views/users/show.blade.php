@extends('layouts.dashboard') {{-- TETAPKAN INI: Meng-extend 'layouts.dashboard' --}}

@section('title')
    Detail Pengguna - {{ $user->name }}
@endsection

@section('sub_title')
    Detail Pengguna
@endsection

@section('content')
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header">
        <i class="fas fa-user-circle me-1"></i> Informasi Detail Pengguna: {{ $user->name }}
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3"><strong>Nama:</strong></div>
            <div class="col-md-9">{{ $user->name }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Email:</strong></div>
            <div class="col-md-9">{{ $user->email }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Role:</strong></div>
            <div class="col-md-9">
                <span class="badge {{
                    $user->role == 'admin' ? 'bg-danger' :
                    ($user->role == 'staff' ? 'bg-info' : 'bg-secondary')
                }}">
                    {{ Str::title($user->role) }}
                </span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Jabatan:</strong></div>
            <div class="col-md-9">{{ $user->position ?? '-' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Dibuat Pada:</strong></div>
            <div class="col-md-9">{{ $user->created_at->format('d M Y, H:i') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Terakhir Diperbarui:</strong></div>
            <div class="col-md-9">{{ $user->updated_at->format('d M Y, H:i') }}</div>
        </div>

        {{-- Tampilkan Detail Pasien jika role adalah 'patient' --}}
        @if($user->hasRole('patient'))
        <hr class="my-4">
        <h5><i class="fas fa-user-injured me-1"></i> Detail Data Pasien</h5>
        
            @if($user->patientDetail)
            <div class="row mb-3 mt-3">
                <div class="col-md-3"><strong>NIK:</strong></div>
                <div class="col-md-9">{{ $user->patientDetail->nik }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3"><strong>Alamat:</strong></div>
                <div class="col-md-9">{{ $user->patientDetail->address }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3"><strong>Tanggal Lahir:</strong></div>
                <div class="col-md-9">{{ $user->patientDetail->birth_date->format('d M Y') }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3"><strong>Nomor HP:</strong></div>
                <div class="col-md-9">{{ $user->patientDetail->phone_number }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3"><strong>Jenis Kelamin:</strong></div>
                <div class="col-md-9">{{ $user->patientDetail->gender }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3"><strong>Status BPJS:</strong></div>
                <div class="col-md-9">{{ $user->patientDetail->bpjs_status ? 'Aktif' : 'Tidak Aktif' }}</div>
            </div>
            <a href="{{ route('patient_details.edit', $user->patientDetail->id) }}" class="btn btn-action-primary mt-3">
                <i class="fas fa-edit me-1"></i> Edit Detail Pasien Ini
            </a>
            @else
            <div class="alert alert-warning mt-3">
                <i class="fas fa-exclamation-triangle me-1"></i> Data detail pasien belum lengkap atau belum dibuat.
            </div>
            {{-- PERBAIKI DI SINI: Kirimkan ID user sebagai parameter --}}
            <a href="{{ route('patient_details.create', ['user' => $user->id]) }}" class="btn btn-action-primary mt-3">
                <i class="fas fa-plus me-1"></i> Lengkapi Detail Pasien
            </a>
            @endif
        @endif


        <hr class="my-4">
        <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Kembali ke Daftar Pengguna</a>
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit Akun Pengguna Ini</a>
    </div>
</div>
@endsection