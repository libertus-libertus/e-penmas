@extends('layouts.dashboard') {{-- Pastikan meng-extend 'layouts.dashboard' --}}

@section('title')
    Tambah Pendaftaran - Puskesmas Nanggalo Siteba
@endsection

@section('sub_title')
    Tambah Pendaftaran Pasien & Antrean Baru
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
        <i class="fas fa-user-plus me-1"></i> Form Tambah Pendaftaran
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

        <form method="POST" action="{{ route('registrations.store') }}">
            @csrf

            {{-- Row 1: Select Patient --}}
            <div class="mb-3">
                <label for="patient_detail_id" class="form-label">Pilih Pasien</label>
                <select class="form-select @error('patient_detail_id') is-invalid @enderror" id="patient_detail_id" name="patient_detail_id" required>
                    <option value="">Pilih Pasien</option>
                    @foreach($patientDetails as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_detail_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->user->name ?? 'N/A' }} (NIK: {{ $patient->nik }})
                        </option>
                    @endforeach
                </select>
                @error('patient_detail_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Row 2: Select Service --}}
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

            {{-- Row 3: Visit Date --}}
            <div class="mb-3">
                <label for="visit_date" class="form-label">Tanggal Kunjungan</label>
                <input type="date" class="form-control @error('visit_date') is-invalid @enderror" id="visit_date" name="visit_date" value="{{ old('visit_date', date('Y-m-d')) }}" required>
                @error('visit_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <a href="{{ route('registrations.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Pendaftaran</button>
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
    // Function to initialize Toastr for session errors/success
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
