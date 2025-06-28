@extends('layouts.dashboard') {{-- Meng-extend 'main' --}}

@section('title')
    Detail Jadwal Pelayanan - {{ $serviceSchedule->service->name ?? 'N/A' }} ({{ $serviceSchedule->day }})
@endsection

@section('sub_title')
    Detail Jadwal Pelayanan
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
        <i class="fas fa-info-circle me-1"></i> Informasi Detail Jadwal: {{ $serviceSchedule->service->name ?? 'N/A' }}
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3"><strong>Nama Pelayanan:</strong></div>
            <div class="col-md-9">{{ $serviceSchedule->service->name ?? 'N/A' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Hari:</strong></div>
            <div class="col-md-9">{{ $serviceSchedule->day }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Jam Mulai:</strong></div>
            <div class="col-md-9">{{ $serviceSchedule->start_time }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Jam Selesai:</strong></div>
            <div class="col-md-9">{{ $serviceSchedule->end_time }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Dibuat Pada:</strong></div>
            <div class="col-md-9">{{ $serviceSchedule->created_at->format('d M Y, H:i') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3"><strong>Terakhir Diperbarui:</strong></div>
            <div class="col-md-9">{{ $serviceSchedule->updated_at->format('d M Y, H:i') }}</div>
        </div>

        <a href="{{ route('service_schedules.index') }}" class="btn btn-secondary me-2">Kembali ke Daftar</a>
        <a href="{{ route('service_schedules.edit', $serviceSchedule->id) }}" class="btn btn-primary">Edit Jadwal Ini</a>
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