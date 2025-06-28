@extends('layouts.dashboard') {{-- UBAH INI: Pastikan meng-extend 'main' --}}

@section('title')
Manajemen Jadwal Pelayanan
@endsection

@section('sub_title')
Daftar Jadwal Pelayanan
@endsection

@push('styles')
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
@endpush

@section('content')

{{-- Tabel Data Jenis Pelayanan --}}
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="200">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-calendar-alt me-1"></i> Data Jadwal Pelayanan</span>
        <a href="{{ route('service_schedules.create') }}" class="btn text-white btn-action-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Tambah Jadwal
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive table-responsive-custom">
            <table class="table table-hover table-striped w-100" id="servicesTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelayanan</th>
                        <th>Hari</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($serviceSchedules as $schedule)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $schedule->service->name ?? 'N/A' }}</td> {{-- Menampilkan nama layanan dari relasi --}}
                        <td>{{ $schedule->day }}</td>
                        <td>{{ $schedule->start_time }}</td>
                        <td>{{ $schedule->end_time }}</td>
                        <td class="text-center">
                            <a href="{{ route('service_schedules.show', $schedule->id) }}" class="btn btn-info btn-sm me-1"><i class="fas fa-eye"></i> Detail</a>
                            <a href="{{ route('service_schedules.edit', $schedule->id) }}" class="btn btn-warning btn-sm me-1"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('service_schedules.destroy', $schedule->id) }}" method="POST" class="d-inline" id="delete-form-{{ $schedule->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete"
                                    data-id="{{ $schedule->id }}" data-name="{{ $schedule->service->name ?? 'N/A' }} ({{ $schedule->day }})">
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
        $('#servicesTable').DataTable({
            responsive: true,
            autoWidth: false
        });

        $('.btn-delete').on('click', function () {
            const scheduleId = $(this).data('id');
            const scheduleName = $(this).data('name');
            const formId = '#delete-form-' + scheduleId;

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                html: "Daftar jadwal pelayanan <strong>" + scheduleName + "</strong> akan dihapus!",
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
    });
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        toastr.success(@json(session('success')));
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        toastr.error(@json(session('error')));
    });
</script>
@endif

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach($errors->all() as $error)
            toastr.error(@json($error));
        @endforeach
    });
</script>
@endif
@endpush
