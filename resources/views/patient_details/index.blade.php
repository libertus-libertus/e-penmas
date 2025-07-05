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
        <span><i class="fas fa-users-cog me-1"></i> Daftar Pasien Rumah Sakit</span>
        {{-- Tombol Tambah Pasien hanya untuk Admin --}}
        @if(Auth::check() && Auth::user()->role === 'admin')
        <a href="{{ route('patients.create') }}" class="btn btn-action-primary btn-sm text-white">
            <i class="fas fa-plus me-1"></i> Tambah Pasien
        </a>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive table-responsive-custom">
            <table class="table table-hover table-striped w-100" id="usersTable">
                <thead>
                    <tr>
                        <th>Nama Pasien</th>
                        <th>NIK</th>
                        <th>Email</th>
                        <th>Nomor HP</th>
                        <th>Status BPJS</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient) {{-- $patients adalah koleksi User model dengan role 'patient' --}}
                    <tr>
                        <td>{{ $patient->name }}</td>
                        {{-- Akses data dari patientDetail jika ada, jika tidak, tampilkan '-' --}}
                        <td>{{ $patient->patientDetail->nik ?? '-' }}</td>
                        <td>{{ $patient->email }}</td>
                        <td>{{ $patient->patientDetail->phone_number ?? '-' }}</td>
                        <td>
                            @if($patient->patientDetail)
                                <span class="badge {{ $patient->patientDetail->bpjs_status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $patient->patientDetail->bpjs_status ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            @else
                                <span class="badge bg-warning">Data Belum Lengkap</span> {{-- Jika patientDetail belum ada --}}
                            @endif
                        </td>
                        <td class="text-center">
                            {{-- Tombol Detail - Mengirim ID User ke route show --}}
                            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info btn-sm me-1" title="Detail Pasien">
                                <i class="fas fa-eye"></i> {{-- Hanya ikon --}}
                            </a>
                            
                            {{-- Tombol Edit - Mengirim ID User ke route edit --}}
                            {{-- Sekarang selalu aktif karena form edit bisa melengkapi data --}}
                            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning btn-sm me-1" title="Edit Pasien">
                                <i class="fas fa-edit"></i> {{-- Hanya ikon --}}
                            </a>

                            {{-- Tombol Hapus - Hanya untuk Admin --}}
                            @if(Auth::check() && Auth::user()->role === 'admin')
                                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline" id="delete-form-{{ $patient->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                        data-id="{{ $patient->id }}" data-name="{{ $patient->name }}" title="Hapus Pasien">
                                        <i class="fas fa-trash"></i> {{-- Hanya ikon --}}
                                    </button>
                                </form>
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
