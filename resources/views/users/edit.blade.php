@extends('layouts.dashboard') {{-- Pastikan ini meng-extend 'main' --}}

@section('title')
    Edit Pengguna - Puskesmas Sehat Selalu
@endsection

@section('sub_title')
    Edit Pengguna: {{ $user->name }}
@endsection

@section('content')
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header">
        <i class="fas fa-user-edit me-1"></i> Form Edit Pengguna
    </div>
    <div class="card-body">
        {{-- Pesan error validasi akan ditangani oleh Toastr secara global --}}

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT') {{-- Penting: Gunakan metode HTTP PUT untuk update --}}

            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="position" class="form-label">Jabatan</label>
                <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position', $user->position) }}" required>
                @error('position')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password (Kosongkan jika tidak ingin diubah)</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>

            <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Update Pengguna</button>
        </form>
    </div>
</div>
@endsection