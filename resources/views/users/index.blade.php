@extends('layouts.dashboard') {{-- UBAH INI: Pastikan meng-extend 'main' --}}

@section('title')
Manajemen Pengguna
@endsection

@section('sub_title')
Manajemen Aktivitas Pengguna
@endsection

@push('styles')
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
@endpush

@section('content')

{{-- Tabel Data Pengguna (Users) --}}
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="200">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-users-cog me-1"></i> Daftar Pengguna Sistem</span>
        <a href="{{ route('users.create') }}" class="btn btn-action-primary btn-sm text-white">
            <i class="fas fa-plus me-1"></i> Tambah Pengguna
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive table-responsive-custom">
            <table class="table table-hover table-striped w-100" id="usersTable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th> {{-- Kolom baru: Role --}}
                        <th>Jabatan</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{
                                $user->role == 'admin' ? 'bg-danger' :
                                ($user->role == 'staff' ? 'bg-info' : 'bg-secondary')
                            }}">
                                {{ Str::title($user->role) }} {{-- Menampilkan role dengan huruf kapital di awal --}}
                            </span>
                        </td>
                        <td>{{ $user->position ?? '-' }}</td> {{-- Tampilkan '-' jika jabatan null --}}
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="text-center">
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm me-1">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm me-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" id="delete-form-{{ $user->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete"
                                    data-id="{{ $user->id }}" data-name="{{ $user->name }}">
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
        $('#usersTable').DataTable({
            responsive: true,
            autoWidth: false
        });

        $('.btn-delete').on('click', function () {
            const userId = $(this).data('id');
            const userName = $(this).data('name');
            const formId = '#delete-form-' + userId;

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                html: "Pengguna <strong>" + userName + "</strong> akan dihapus!",
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
