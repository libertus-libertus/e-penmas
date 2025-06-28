@extends('layouts.dashboard') {{-- TETAPKAN INI: Meng-extend 'layouts.dashboard' --}}

@section('title')
    Edit Pengguna - Puskesmas Nanggalo Siteba
@endsection

@section('sub_title')
    Edit Pengguna: {{ $user->name }}
@endsection

@section('content')
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header">
        <i class="fas fa-user-edit me-1"></i> Form Edit Pengguna
    </div>
    <div class="card-body">
        {{-- Pesan error validasi akan ditangani oleh Toastr secara global --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5>Terjadi Kesalahan:</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            {{-- Baris 1: Nama & Email --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Baris 2: Role & Jabatan --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                        <option value="">Pilih Role</option>
                        @foreach($roles as $roleOption)
                            <option value="{{ $roleOption }}" {{ old('role', $user->role) == $roleOption ? 'selected' : '' }}>{{ Str::title($roleOption) }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6" id="position-group">
                    <label for="position" class="form-label">Jabatan</label>
                    <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position', $user->position) }}">
                    @error('position')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Baris 3: Password --}}
            <div class="mb-3">
                <label for="password" class="form-label">Password (Kosongkan jika tidak ingin diubah)</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>

            <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Update Pengguna</button>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    function togglePositionField() {
        const role = $('#role').val();
        if (role === 'patient') {
            $('#position-group').hide();
            $('#position').val(''); // Kosongkan nilai jabatan jika role pasien
            $('#position').prop('required', false); // Tidak wajib
        } else {
            $('#position-group').show();
            if ($('#position').val() === '') { // Hanya set required jika input kosong
                 $('#position').prop('required', true);
            }
        }
    }

    // Panggil saat halaman dimuat
    togglePositionField();

    // Panggil saat nilai dropdown role berubah
    $('#role').on('change', togglePositionField);

});
</script>
@endpush