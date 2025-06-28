@extends('layouts.dashboard')

@section('title')
    Edit Jadwal Pelayanan - Puskesmas Sehat Selalu
@endsection

@section('sub_title')
    Edit Jadwal: {{ $serviceSchedule->service->name ?? 'N/A' }} ({{ $serviceSchedule->day }})
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
        <i class="fas fa-edit me-1"></i> Form Edit Jadwal Pelayanan
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('service_schedules.update', $serviceSchedule->id) }}">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="service_id" class="form-label">Jenis Pelayanan</label>
                    <select class="form-select @error('service_id') is-invalid @enderror" id="service_id" name="service_id" required>
                        <option value="">Pilih Jenis Pelayanan</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id', $serviceSchedule->service_id) == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="day" class="form-label">Hari</label>
                    <select class="form-select @error('day') is-invalid @enderror" id="day" name="day" required>
                        <option value="">Pilih Hari</option>
                        @foreach($days as $day)
                            <option value="{{ $day }}" {{ old('day', $serviceSchedule->day) == $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="start_time" class="form-label">Jam Mulai</label>
                    <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time', $serviceSchedule->start_time) }}" required>
                </div>
                <div class="col-md-6">
                    <label for="end_time" class="form-label">Jam Selesai</label>
                    <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time', $serviceSchedule->end_time) }}" required>
                </div>
            </div>

            <a href="{{ route('service_schedules.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Update Jadwal</button>
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

        @if($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error(@json($error));
            @endforeach
        @endif
    });
</script>
@endpush