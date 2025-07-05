@extends('layouts.dashboard') {{-- UBAH INI: Pastikan meng-extend 'main' atau 'layouts.dashboard' --}}

@section('title')
Manajemen Pendaftaran & Antrean
@endsection

@section('sub_title')
Daftar Pendaftaran dan Status Antrean
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
    <div class="card-header"><i class="fas fa-filter me-1"></i> Filter Pendaftaran & Antrean</div>
    <div class="card-body">
        <form method="GET" action="{{ route('registrations.index') }}" class="row g-3 align-items-end">
            {{-- Filter fields and buttons in one row for larger screens --}}
            {{-- Tanggal Kunjungan --}}
            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                <label for="visit_date" class="form-label">Tanggal Kunjungan</label>
                <input type="date" class="form-control" id="visit_date" name="visit_date" value="{{ request('visit_date') }}">
            </div>
            {{-- Status Antrean --}}
            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                <label for="queue_status" class="form-label">Status Antrean</label>
                <select class="form-select" id="queue_status" name="queue_status">
                    <option value="">Semua Status Antrean</option>
                    <option value="waiting" {{ request('queue_status') == 'waiting' ? 'selected' : '' }}>Menunggu</option>
                    <option value="called" {{ request('queue_status') == 'called' ? 'selected' : '' }}>Dipanggil</option>
                    <option value="completed" {{ request('queue_status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="skipped" {{ request('queue_status') == 'skipped' ? 'selected' : '' }}>Dilewati</option>
                    <option value="cancelled" {{ request('queue_status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            
            {{-- Filter buttons --}}
            <div class="col-lg-3 col-md-3 col-sm-6 col-12 d-flex align-items-end">
                <button type="submit" class="btn btn-action-primary w-100"><i class="fas fa-search me-1"></i> Terapkan</button>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-12 d-flex align-items-end">
                <a href="{{ route('registrations.index') }}" class="btn btn-secondary w-100"><i class="fas fa-redo me-1"></i> Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Data Pendaftaran & Antrean --}}
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="200">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-clipboard-list me-1"></i> Daftar Pendaftaran & Antrean</span>
        <a href="{{ route('registrations.create') }}" class="btn btn-action-primary btn-sm text-white">
            <i class="fas fa-plus me-1"></i> Tambah Pendaftaran
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive table-responsive-custom">
            <table class="table table-hover table-striped w-100" id="registrationsTable">
                <thead>
                    <tr>
                        <th>No. Antrean</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Nama Pasien</th>
                        <th>Layanan</th>
                        <th>Status Antrean</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $registration)
                    <tr>
                        <td>{{ sprintf('%03d', $registration->queue_number) }}</td>
                        <td>{{ $registration->visit_date->format('Y-m-d') }}</td>
                        <td>{{ $registration->patientDetail->user->name ?? 'N/A' }}</td>
                        <td>{{ $registration->service->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{
                                $registration->queue->status == 'waiting' ? 'bg-secondary' :
                                ($registration->queue->status == 'called' ? 'bg-primary' :
                                ($registration->queue->status == 'completed' ? 'bg-success' :
                                ($registration->queue->status == 'skipped' ? 'bg-info' : 'bg-danger')))
                            }}">
                                {{ Str::title($registration->queue->status ?? 'N/A') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('registrations.show', $registration->id) }}" class="btn btn-info btn-sm me-1">
                                <i class="fas fa-eye"></i>
                            </a>
                            {{-- Tombol Cetak Struk Antrean --}}
                            {{-- Tampil jika tidak di-soft delete dan status antrean bukan 'cancelled' --}}
                            @if(!$registration->trashed() && $registration->queue && $registration->queue->status !== 'cancelled')
                                <a href="{{ route('registrations.print', $registration->id) }}" target="_blank" class="btn btn-primary btn-sm me-1">
                                    <i class="fas fa-print"></i>
                                </a>
                            @endif

                            {{-- Hanya tampilkan tombol Edit Antrean jika status antrean bukan 'completed' atau 'cancelled' dan tidak di-soft delete --}}
                            @if($registration->queue && $registration->queue->status !== 'completed' && $registration->queue->status !== 'cancelled' && !$registration->trashed())
                                <a href="{{ route('registrations.edit', $registration->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endif
                            {{-- Hanya tampilkan tombol "Batalkan" jika status antrean bukan 'completed' atau 'cancelled' dan tidak di-soft delete --}}
                            @if($registration->queue && $registration->queue->status !== 'completed' && $registration->queue->status !== 'cancelled' && !$registration->trashed())
                                <form action="{{ route('registrations.destroy', $registration->id) }}" method="POST" class="d-inline" id="delete-form-{{ $registration->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        data-id="{{ $registration->id }}" data-queue-number="{{ sprintf('%03d', $registration->queue_number) }}">
                                        <i class="fas fa-trash bg-danger"></i>
                                    </button>
                                </form>
                            @endif
                            {{-- Tampilkan indikator jika sudah dibatalkan (soft deleted) --}}
                            @if($registration->trashed())
                                <span class="badge bg-danger ms-1">Dibatalkan</span>
                            @endif
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
        $('#registrationsTable').DataTable();

        $('.btn-delete').on('click', function () {
            const registrationId = $(this).data('id');
            const queueNumber = $(this).data('queue-number');
            const formId = '#delete-form-' + registrationId;

            Swal.fire({
                title: 'Yakin ingin membatalkan pendaftaran?',
                html: "Pendaftaran dengan Nomor Antrean <strong>" + queueNumber + "</strong> akan dibatalkan! Data akan tetap ada untuk riwayat, namun tidak dapat dipulihkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Tidak',
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
