@extends('layouts.dashboard')

@section('title')
    Detail Data Pasien - {{ $patient->name ?? 'N/A' }}
@endsection

@section('sub_title')
    Detail Data Pasien
@endsection

@section('content')
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header">
        <i class="fas fa-user-injured me-1"></i> Informasi Detail Pasien: {{ $patient->name ?? 'N/A' }}
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4"><strong>Nama Pasien:</strong></div>
            <div class="col-md-8">{{ $patient->name ?? 'N/A' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Email:</strong></div>
            <div class="col-md-8">{{ $patient->email ?? 'N/A' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>NIK:</strong></div>
            {{-- WAJIB: Gunakan optional() helper untuk patientDetail --}}
            <div class="col-md-8">{{ optional($patient->patientDetail)->nik ?? '-' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Alamat:</strong></div>
            {{-- WAJIB: Gunakan optional() helper untuk patientDetail --}}
            <div class="col-md-8">{{ optional($patient->patientDetail)->address ?? '-' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Tanggal Lahir:</strong></div>
            {{-- WAJIB: Gunakan optional() helper untuk patientDetail, lalu null-safe untuk format --}}
            <div class="col-md-8">{{ optional($patient->patientDetail)->birth_date?->format('d M Y') ?? '-' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Nomor HP:</strong></div>
            {{-- WAJIB: Gunakan optional() helper untuk patientDetail --}}
            <div class="col-md-8">{{ optional($patient->patientDetail)->phone_number ?? '-' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Jenis Kelamin:</strong></div>
            {{-- WAJIB: Gunakan optional() helper untuk patientDetail --}}
            <div class="col-md-8">{{ optional($patient->patientDetail)->gender ?? '-' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Status BPJS:</strong></div>
            <div class="col-md-8">
                {{-- WAJIB: Gunakan optional() helper untuk patientDetail --}}
                <span class="badge {{ (optional($patient->patientDetail)->bpjs_status ?? false) ? 'bg-success' : 'bg-secondary' }}">
                    {{ (optional($patient->patientDetail)->bpjs_status ?? false) ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Dibuat Pada:</strong></div>
            <div class="col-md-8">{{ $patient->created_at->format('d M Y, H:i') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Terakhir Diperbarui:</strong></div>
            <div class="col-md-8">{{ $patient->updated_at->format('d M Y, H:i') }}</div>
        </div>

        <hr class="my-4">
        <a href="{{ route('patients.index') }}" class="btn btn-secondary me-2">Kembali ke Daftar Pasien</a>
        <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary">Edit Detail Pasien Ini</a>
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
