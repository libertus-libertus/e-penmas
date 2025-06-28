@extends('layouts.dashboard')

@section('title')
Manajemen Data Pasien
@endsection

@section('sub_title')
Daftar Pasien
@endsection

@push('styles')
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
@endpush

@section('content')

{{-- Tabel Data Pasien (Users) --}}
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="200">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-users-cog me-1"></i> Daftar Pasien Rumah Sakit</span>
        <a href="{{ route('patients.create') }}" class="btn btn-action-primary btn-sm text-white">
            <i class="fas fa-plus me-1"></i> Tambah Pasien
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive table-responsive-custom">
            <table class="table table-hover table-striped w-100" id="usersTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pasien</th>
                        <th>NIK</th>
                        <th>Email</th>
                        <th>Nomor HP</th>
                        <th>Status BPJS</th>
                        <th>Aksi</th> {{-- Tidak ada kolom 'Dibuat Pada' di sini agar sesuai dengan Users, tapi bisa ditambahkan jika mau --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient) {{-- <--- PERUBAHAN DI SINI: $patients as $patient --}}
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $patient->name }}</td>
                        <td>{{ $patient->patientDetail->nik ?? '-' }}</td> {{-- Akses NIK dari relasi patientDetail --}}
                        <td>{{ $patient->email }}</td>
                        <td>{{ $patient->patientDetail->phone_number ?? '-' }}</td> {{-- Akses No. HP dari relasi patientDetail --}}
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
                            {{-- Tombol Detail --}}
                            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info btn-sm me-1">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            {{-- Tombol Edit --}}
                            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning btn-sm me-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            {{-- FORM HAPUS DIHAPUS DARI SINI SESUAI INSTRUKSI --}}
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
