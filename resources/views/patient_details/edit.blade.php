@extends('layouts.dashboard')

@section('title')
    Edit Pasien - {{ $patient->name ?? 'N/A' }}
@endsection

@section('sub_title')
    Edit Data Pasien
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
        <i class="fas fa-user-edit me-1"></i> Form Edit Pasien
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

        <form method="POST" action="{{ route('patients.update', $patient->id) }}">
            @csrf
            @method('PUT')
            
            {{-- Data Akun Pasien --}}
            <h5 class="mb-3">Data Akun & Demografi Pasien</h5>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nama Lengkap Pasien</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $patient->name ?? '') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email (Username)</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $patient->email ?? '') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="password" class="form-label">Password (Kosongkan jika tidak ingin diubah)</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
            </div>

            <hr class="my-4">

            {{-- Data Detail Demografi Pasien --}}
            <h5 class="mb-3">Detail Demografi Pasien</h5>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="nik" class="form-label">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $patient->patientDetail->nik ?? '') }}" required maxlength="16">
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date', $patient->patientDetail->birth_date?->format('Y-m-d') ?? '') }}" required>
                    @error('birth_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Alamat Lengkap</label>
                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address', $patient->patientDetail->address ?? '') }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="phone_number" class="form-label">Nomor HP</label>
                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $patient->patientDetail->phone_number ?? '') }}" required maxlength="15">
                    @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('gender', $patient->patientDetail->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', $patient->patientDetail->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="bpjs_status" class="form-label">Status BPJS</label>
                    <select class="form-select @error('bpjs_status') is-invalid @enderror" id="bpjs_status" name="bpjs_status" required>
                        <option value="">Pilih Status BPJS</option>
                        <option value="1" {{ old('bpjs_status', $patient->patientDetail->bpjs_status ?? '') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('bpjs_status', $patient->patientDetail->bpjs_status ?? '') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('bpjs_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <a href="{{ route('patients.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Update Pasien</button>
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
    // WAJIB: Pastikan ini berada di dalam $(document).ready()
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
