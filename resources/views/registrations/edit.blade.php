@extends('layouts.dashboard') {{-- TETAPKAN INI: Meng-extend 'layouts.dashboard' --}}

@section('title')
    Edit Status Antrean - Puskesmas Nanggalo Siteba
@endsection

@section('sub_title')
    Edit Status Antrean: No. {{ sprintf('%03d', $registration->queue_number) }}
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
        <i class="fas fa-clipboard-check me-1"></i> Form Edit Status Antrean
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

        <form method="POST" action="{{ route('registrations.update', $registration->id) }}">
            @csrf
            @method('PUT')

            {{-- Registration Info (Display Only) --}}
            <div class="mb-3">
                <label for="queue_number_display" class="form-label">Nomor Antrean</label>
                <input type="text" class="form-control" id="queue_number_display" value="{{ sprintf('%03d', $registration->queue_number) }}" readonly>
            </div>
            <div class="mb-3">
                <label for="patient_name_display" class="form-label">Nama Pasien</label>
                <input type="text" class="form-control" id="patient_name_display" value="{{ $registration->patientDetail->user->name ?? 'N/A' }}" readonly>
            </div>
            <div class="mb-3">
                <label for="service_name_display" class="form-label">Jenis Layanan</label>
                <input type="text" class="form-control" id="service_name_display" value="{{ $registration->service->name ?? 'N/A' }}" readonly>
            </div>
            <div class="mb-3">
                <label for="current_queue_status_display" class="form-label">Status Antrean Saat Ini</label>
                <input type="text" class="form-control" id="current_queue_status_display" value="{{ Str::title($registration->queue->status ?? 'N/A') }}" readonly>
            </div>

            <hr>

            {{-- Select New Queue Status --}}
            <div class="mb-3">
                <label for="status" class="form-label">Ubah Status Antrean Menjadi</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="">Pilih Status Baru</option>
                    @foreach($queueStatuses as $statusOption)
                        <option value="{{ $statusOption }}" {{ old('status', $registration->queue->status) == $statusOption ? 'selected' : '' }}>
                            {{ Str::title($statusOption) }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <a href="{{ route('registrations.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Update Status Antrean</button>
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
