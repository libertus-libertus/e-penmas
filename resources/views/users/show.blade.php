@extends('layouts.dashboard') {{-- Pastikan ini meng-extend 'main' --}}

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
            <div class="col-md-3"><strong>Jabatan:</strong></div>
            <div class="col-md-9">{{ $user->position }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Dibuat Pada:</strong></div>
            <div class="col-md-9">{{ $user->created_at->format('d M Y') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Terakhir Diperbarui:</strong></div>
            <div class="col-md-9">{{ $user->updated_at->format('d M Y') }}</div>
        </div>

        <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Kembali ke Daftar</a>
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit Pengguna Ini</a>
    </div>
</div>
@endsection