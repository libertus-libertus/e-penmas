@extends('layouts.dashboard') {{-- Pastikan ini meng-extend 'main' --}}

@section('title')
    Edit Jenis Pelayanan - Puskesmas Nanggalo Siteba
@endsection

@section('sub_title')
    Edit Pelayanan: {{ $service->name }}
@endsection

@section('content')
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header">
        <i class="fas fa-concierge-bell me-1"></i> Form Edit Jenis Pelayanan
    </div>
    <div class="card-body">
        {{-- Pesan error validasi akan ditangani oleh Toastr secara global --}}

        <form method="POST" action="{{ route('services.update', $service->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nama Pelayanan</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $service->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4" required>{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <a href="{{ route('services.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Update Pelayanan</button>
        </form>
    </div>
</div>
@endsection
