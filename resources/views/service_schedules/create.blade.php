@extends('layouts.dashboard') {{-- TETAPKAN INI: Meng-extend 'layouts.dashboard' --}}

@section('title')
    Tambah Jadwal Pelayanan - Puskesmas Sehat Selalu
@endsection

@section('sub_title')
    Tambah Jadwal Pelayanan Baru
@endsection

@push('css')
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header">
        <i class="fas fa-plus me-1"></i> Form Tambah Jadwal Pelayanan
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('service_schedules.store') }}">
            @csrf
            
            {{-- Baris 1: Jenis Pelayanan & Hari --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="service_id" class="form-label">Jenis Pelayanan</label>
                    <select class="form-select @error('service_id') is-invalid @enderror" id="service_id" name="service_id" required>
                        <option value="">Pilih Jenis Pelayanan</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                        @endforeach
                    </select>
                    @error('service_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="day" class="form-label">Hari</label>
                    <select class="form-select @error('day') is-invalid @enderror" id="day" name="day" required>
                        <option value="">Pilih Hari</option>
                        @foreach($days as $day)
                            <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                    @error('day')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Baris 2: Jam Mulai & Jam Selesai --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="start_time" class="form-label">Jam Mulai</label>
                    <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                    @error('start_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="end_time" class="form-label">Jam Selesai</label>
                    <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                    @error('end_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <a href="{{ route('service_schedules.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
        </form>
    </div>
</div>
@endsection

@push('js')
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Konfigurasi Toastr Options
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Handle pesan dari session flash
        @if(Session::has('success'))
            toastr.success(@json(Session::get('success')));
        @endif

        @if(Session::has('error'))
            toastr.error(@json(Session::get('error')));
        @endif

        @if(Session::has('warning'))
            toastr.warning(@json(Session::get('warning')));
        @endif

        @if(Session::has('info'))
            toastr.info(@json(Session::get('info')));
        @endif

        // Tangani pesan error validasi ($errors)
        @if($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error(@json($error));
            @endforeach
        @endif
    });
</script>
@endpush