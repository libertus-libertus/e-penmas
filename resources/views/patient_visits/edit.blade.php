@extends('layouts.dashboard')

@section('title')
    Edit Status Riwayat Kunjungan - {{ $patientVisit->patientDetail->user->name ?? 'N/A' }}
@endsection

@section('sub_title')
    Edit Status Riwayat Kunjungan
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
        <i class="fas fa-edit me-1"></i> Form Edit Status Riwayat Kunjungan
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

        <form method="POST" action="{{ route('patient_visits.update', $patientVisit->id) }}">
            @csrf
            @method('PUT')
            
            {{-- Informasi Kunjungan (Display Only) --}}
            <div class="mb-3">
                <label for="patient_display" class="form-label">Nama Pasien</label>
                <input type="text" class="form-control" id="patient_display" value="{{ $patientVisit->patientDetail->user->name ?? 'N/A' }}" readonly>
            </div>
            <div class="mb-3">
                <label for="service_display" class="form-label">Jenis Layanan</label>
                <input type="text" class="form-control" id="service_display" value="{{ $patientVisit->service->name ?? 'N/A' }}" readonly>
            </div>
            <div class="mb-3">
                <label for="visit_date_display" class="form-label">Tanggal Kunjungan</label>
                <input type="text" class="form-control" id="visit_date_display" value="{{ $patientVisit->visit_date->format('d M Y') }}" readonly>
            </div>
            <div class="mb-3">
                <label for="current_status_display" class="form-label">Status Kunjungan Saat Ini</label>
                <input type="text" class="form-control" id="current_status_display" value="{{ Str::title($patientVisit->status) }}" readonly>
            </div>

            <hr>

            {{-- Pilih Status Baru --}}
            <div class="mb-3">
                <label for="status" class="form-label">Ubah Status Kunjungan Menjadi</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="">Pilih Status Baru</option>
                    @foreach($statuses as $statusOption)
                        <option value="{{ $statusOption }}" {{ old('status', $patientVisit->status) == $statusOption ? 'selected' : '' }}>
                            {{ Str::title($statusOption) }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <a href="{{ route('patient_visits.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Update Status Kunjungan</button>
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
