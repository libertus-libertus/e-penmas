@extends('layouts.dashboard')

@section('title')
Manajemen Riwayat Kunjungan Pasien
@endsection

@section('sub_title')
Daftar Riwayat Kunjungan Pasien
@endsection

@push('styles')
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
@endpush

@section('content')

{{-- Filter Form --}}
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header"><i class="fas fa-filter me-1"></i> Filter Riwayat Kunjungan</div>
    <div class="card-body">
        <form method="GET" action="{{ route('patient_visits.index') }}" class="row g-3 align-items-end">
            {{-- Filter by Patient --}}
            {{-- <div class="col-md-4 col-sm-6 col-12">
                <label for="patient_id" class="form-label">Nama Pasien</label>
                <select class="form-select" id="patient_id" name="patient_id">
                    <option value="">Semua Pasien</option>
                    @foreach($patientDetails as $patient)
                        <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->user->name ?? 'N/A' }} (NIK: {{ $patient->nik }})
                        </option>
                    @endforeach
                </select>
            </div> --}}
            {{-- Filter by Service --}}
            <div class="col-md-4 col-sm-6 col-12">
                <label for="service_id" class="form-label">Jenis Layanan</label>
                <select class="form-select" id="service_id" name="service_id">
                    <option value="">Semua Layanan</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- Filter by Status --}}
            <div class="col-md-4 col-sm-6 col-12">
                <label for="status" class="form-label">Status Kunjungan</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Semua Status</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
             {{-- Filter by Visit Date --}}
            <div class="col-md-4 col-sm-6 col-12">
                <label for="visit_date" class="form-label">Tanggal Kunjungan</label>
                <input type="date" class="form-control" id="visit_date" name="visit_date" value="{{ request('visit_date') }}">
            </div>
            
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-action-primary me-2"><i class="fas fa-search me-1"></i> Terapkan Filter</button>
                <a href="{{ route('patient_visits.index') }}" class="btn btn-secondary"><i class="fas fa-redo me-1"></i> Reset Filter</a>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Data Riwayat Kunjungan --}}
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="200">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-history me-1"></i> Riwayat Kunjungan Pasien</span>
        {{-- No "Tambah" button here, as creation is automated --}}
    </div>
    <div class="card-body">
        <div class="table-responsive table-responsive-custom">
            <table class="table table-hover table-striped w-100" id="patientVisitsTable">
                <thead>
                    <tr>
                        <th>Tanggal Kunjungan</th>
                        <th>Nama Pasien</th>
                        <th>Layanan</th>
                        <th>Status</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patientVisits as $visit)
                    <tr>
                        <td>{{ $visit->visit_date->format('Y-m-d') }}</td>
                        <td>{{ $visit->patientDetail->user->name ?? 'N/A' }}</td>
                        <td>{{ $visit->service->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{
                                $visit->status == 'completed' ? 'bg-success' :
                                ($visit->status == 'canceled' ? 'bg-danger' : 'bg-secondary')
                            }}">
                                {{ Str::title($visit->status) }}
                            </span>
                        </td>
                        <td>{{ $visit->created_at->format('Y-m-d H:i') }}</td>
                        <td class="text-center">
                            <a href="{{ route('patient_visits.show', $visit->id) }}" class="btn btn-info btn-sm me-1">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <a href="{{ route('patient_visits.edit', $visit->id) }}" class="btn btn-warning btn-sm me-1">
                                <i class="fas fa-edit"></i> Edit Status
                            </a>
                            {{-- No delete button as per requirement/design for history --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- DataTables Core + Bootstrap 5 JS -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#patientVisitsTable').DataTable({
            responsive: true,
            autoWidth: false,
            "order": [],
            "columnDefs": [
                { "orderable": false, "targets": [5] } // Disable sorting on the "Aksi" column
            ]
        });

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
