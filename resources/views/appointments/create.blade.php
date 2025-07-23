@extends('layouts.dashboard')

@section('title')
    Tambah Catatan Pelayanan
@endsection

@section('sub_title')
    Tambah Catatan Pelayanan Baru
@endsection

@push('styles')
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header">
        <i class="fas fa-file-medical me-1"></i> Form Tambah Catatan Pelayanan
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5>Terjadi Kesalahan:</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('appointments.store') }}">
            @csrf
            
            {{-- Pilih Pendaftaran (Nomor Antrean & Pasien) --}}
            <div class="mb-3">
                <label for="registration_id" class="form-label">Pilih Pendaftaran (Nomor Antrean - Nama Pasien)</label>
                <select class="form-select @error('registration_id') is-invalid @enderror" id="registration_id" name="registration_id" required>
                    <option value="">Pilih Pendaftaran</option>
                    @foreach($registrations as $registration)
                        <option value="{{ $registration->id }}" {{ old('registration_id') == $registration->id ? 'selected' : '' }}>
                            No. {{ sprintf('%03d', $registration->queue_number) }} - {{ $registration->patientDetail->user->name ?? 'N/A' }} ({{ $registration->visit_date->format('Y-m-d') }})
                        </option>
                    @endforeach
                </select>
                @error('registration_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Pilih Petugas yang Melayani --}}
            <div class="mb-3">
                <label for="user_id" class="form-label">Dokter yang Melayani</label>
                <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                    <option value="">Pilih Dokter</option>
                    @foreach($staffUsers as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ Str::title($user->role) }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Pilih Jenis Layanan --}}
            <div class="mb-3">
                <label for="service_id" class="form-label">Jenis Layanan</label>
                <select class="form-select @error('service_id') is-invalid @enderror" id="service_id" name="service_id" required>
                    <option value="">Pilih Jenis Layanan</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
                @error('service_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Catatan Pelayanan --}}
            <div class="mb-3">
                <label for="notes" class="form-label">Catatan Pelayanan</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <a href="{{ route('appointments.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Catatan</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Initialize Toastr for session messages
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
});
</script>
@endpush
