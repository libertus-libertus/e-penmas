@extends('layouts.dashboard') {{-- Menggunakan layout dashboard umum --}}

@section('title')
    Daftar Layanan & Antrean
@endsection

@section('sub_title')
    Pendaftaran Layanan Baru
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header">
        <i class="fas fa-calendar-plus me-1"></i> Form Pendaftaran Layanan
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

        <form method="POST" action="{{ route('patient.registrations.store') }}">
            @csrf
            
            {{-- Data Pasien (Otomatis dari user yang login) --}}
            <h5 class="mb-3">Informasi Pasien</h5>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="patient_name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="patient_name" value="{{ $user->name ?? 'N/A' }}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="patient_nik" class="form-label">NIK</label>
                    <input type="text" class="form-control" id="patient_nik" value="{{ $patientDetail->nik ?? 'N/A' }}" readonly>
                </div>
            </div>

            <hr class="my-4">

            {{-- Detail Pendaftaran --}}
            <h5 class="mb-3">Detail Pendaftaran Layanan</h5>
            <div class="mb-3">
                <label for="service_id" class="form-label">Pilih Jenis Layanan</label>
                <select class="form-select @error('service_id') is-invalid @enderror" id="service_id" name="service_id" required>
                    <option value="">Pilih Layanan</option>
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

            <div class="mb-3">
                <label for="visit_date" class="form-label">Tanggal Kunjungan</label>
                <input type="date" class="form-control @error('visit_date') is-invalid @enderror" id="visit_date" name="visit_date" value="{{ old('visit_date', date('Y-m-d')) }}" required>
                @error('visit_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <a href="{{ route('patient.dashboard') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
