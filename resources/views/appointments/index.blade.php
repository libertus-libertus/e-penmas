@extends('layouts.dashboard')

@section('title')
Manajemen Catatan Pelayanan
@endsection

@section('sub_title')
Daftar Catatan Pelayanan Pasien
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
    <div class="card-header"><i class="fas fa-filter me-1"></i> Filter Catatan Pelayanan</div>
    <div class="card-body">
        <form method="GET" action="{{ route('appointments.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4 col-sm-6 col-12">
                <label for="registration_id" class="form-label">Nomor Antrean / Pendaftaran</label>
                <select class="form-select" id="registration_id" name="registration_id">
                    <option value="">Semua Pendaftaran</option>
                    @foreach($registrations as $reg)
                        <option value="{{ $reg->id }}" {{ request('registration_id') == $reg->id ? 'selected' : '' }}>
                            {{ sprintf('%03d', $reg->queue_number) }} - {{ $reg->patientDetail->user->name ?? 'N/A' }} ({{ $reg->visit_date->format('Y-m-d') }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <label for="user_id" class="form-label">Petugas Pelayanan</label>
                <select class="form-select" id="user_id" name="user_id">
                    <option value="">Semua Petugas</option>
                    @foreach($staffUsers as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ Str::title($user->role) }})
                        </option>
                    @endforeach
                </select>
            </div>
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
            {{-- Search by Patient Name (Optional, if needed for direct search not dropdown) --}}
            {{-- <div class="col-md-4 col-sm-6 col-12">
                <label for="patient_name" class="form-label">Nama Pasien</label>
                <input type="text" class="form-control" id="patient_name" name="patient_name" value="{{ request('patient_name') }}" placeholder="Cari nama pasien...">
            </div> --}}
            
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-action-primary me-2"><i class="fas fa-search me-1"></i> Terapkan Filter</button>
                <a href="{{ route('appointments.index') }}" class="btn btn-secondary"><i class="fas fa-redo me-1"></i> Reset Filter</a>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Data Pelayanan --}}
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="200">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-notes-medical me-1"></i> Daftar Catatan Pelayanan</span>
        <a href="{{ route('appointments.create') }}" class="btn btn-action-primary btn-sm text-white">
            <i class="fas fa-plus me-1"></i> Tambah Catatan Pelayanan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive table-responsive-custom">
            <table class="table table-hover table-striped w-100" id="appointmentsTable">
                <thead>
                    <tr>
                        <th>No. Antrean</th>
                        <th>Nama Pasien</th>
                        <th>Layanan Diberikan</th>
                        <th>Dokter</th>
                        <th>Tanggal Pelayanan</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ sprintf('%03d', $appointment->registration->queue_number ?? 'N/A') }}</td>
                        <td>{{ $appointment->registration->patientDetail->user->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->service->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->user->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ Str::limit($appointment->notes, 50, '...') ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('appointments.show', $appointment->id) }}" class="btn btn-info btn-sm me-1">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning btn-sm me-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="d-inline" id="delete-form-{{ $appointment->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete"
                                    data-id="{{ $appointment->id }}" data-patient-name="{{ $appointment->registration->patientDetail->user->name ?? 'N/A' }}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
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
        $('#appointmentsTable').DataTable({
            responsive: true,
            autoWidth: false,
            "order": [],
            "columnDefs": [
                { "orderable": false, "targets": [6] } // Disable sorting on the "Aksi" column
            ]
        });

        $('.btn-delete').on('click', function () {
            const appointmentId = $(this).data('id');
            const patientName = $(this).data('patient-name');
            const formId = '#delete-form-' + appointmentId;

            Swal.fire({
                title: 'Yakin ingin menghapus catatan pelayanan ini?',
                html: "Catatan pelayanan untuk pasien <strong>" + patientName + "</strong> akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $(formId).submit();
                }
            });
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
