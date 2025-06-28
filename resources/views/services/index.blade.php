@extends('layouts.dashboard') {{-- UBAH INI: Pastikan meng-extend 'main' --}}

@section('title')
Manajemen Jenis Pelayanan
@endsection

@section('sub_title')
Manajemen Data Jenis Pelayanan
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
        <span><i class="fas fa-concierge-bell me-1"></i> Daftar Jenis Pelayanan</span>
        <a href="{{ route('services.create') }}" class="btn text-white btn-sm">
            <i class="fas fa-plus me-1"></i> Tambah Jenis Pelayanan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive table-responsive-custom">
            <table class="table table-hover table-striped w-100" id="servicesTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelayanan</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->description }}</td>
                        <td class="text-center">
                            <a href="{{ route('services.show', $service->id) }}" class="btn btn-info btn-sm me-1">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning btn-sm me-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline" id="delete-form-{{ $service->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete"
                                    data-id="{{ $service->id }}" data-name="{{ $service->name }}">
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
            const serviceId = $(this).data('id');
            const serviceName = $(this).data('name');
            const formId = '#delete-form-' + serviceId;

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                html: "Jenis pelayanan <strong>" + serviceName + "</strong> akan dihapus!",
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
