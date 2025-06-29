@extends('layouts.dashboard')

@section('title')
Manajemen Pendaftaran & Antrean
@endsection

@section('sub_title')
Daftar Pendaftaran Pasien
@endsection

@push('css')
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')

{{-- Bagian Statistik Ringkasan Pendaftaran (Opsional) --}}
<div class="row mb-3 g-3">
    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
        <div class="card card-dashboard text-center">
            <div class="card-body">
                <i class="fas fa-clipboard-list card-icon"></i>
                <div class="statistic-value text-info">{{ \App\Models\Registration::whereDate('created_at', today())->count() }}</div>
                <div class="statistic-label">Pendaftaran Hari Ini</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
        <div class="card card-dashboard text-center">
            <div class="card-body">
                <i class="fas fa-hourglass-half card-icon"></i>
                <div class="statistic-value text-warning">{{ \App\Models\Queue::where('status', 'waiting')->whereHas('registration', function($query) { $query->whereDate('visit_date', today()); })->count() }}</div>
                <div class="statistic-label">Pasien Menunggu Antrean</div>
            </div>
        </div>
    </div>
    {{-- Tambahkan statistik lain jika perlu --}}
</div>

{{-- Tabel Data Pendaftaran --}}
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="200">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-clipboard-list me-1"></i> Daftar Pendaftaran</span>
        <a href="{{ route('registrations.create') }}" class="btn btn-action-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Buat Pendaftaran Baru
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session('success') !!} {{-- Gunakan {!! !!} untuk merender HTML --}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {!! session('error') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
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
        {{-- Display Queue Number Pop-up if available --}}
        @if(session('queue_number_display'))
            <div class="modal fade" id="queueNumberModal" tabindex="-1" aria-labelledby="queueNumberModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="queueNumberModalLabel"><i class="fas fa-ticket-alt me-2"></i> Nomor Antrean Anda</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center py-4">
                            <p class="mb-2 fs-5">Pasien: <strong>{{ session('patient_name_display') }}</strong></p>
                            <p class="mb-4 fs-5">Layanan: <strong>{{ session('service_name_display') }}</strong></p>
                            <h3 class="display-1 text-primary fw-bold">{{ session('queue_number_display') }}</h3>
                            <p class="text-muted">Harap tunggu panggilan dari petugas kami.</p>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-action-primary" data-bs-dismiss="modal">Tutup</button>
                            {{-- <button type="button" class="btn btn-action-secondary"><i class="fas fa-print me-1"></i> Cetak</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <div class="table-responsive table-responsive-custom">
            <table class="table table-hover table-striped w-100" id="registrationsTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Antrean</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Pelayanan</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Status Pendaftaran</th>
                        <th>Status Antrean</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $reg)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ str_pad($reg->queue_number, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $reg->patientDetail->user->name ?? 'N/A' }}</td>
                        <td>{{ $reg->service->name ?? 'N/A' }}</td>
                        <td>{{ $reg->visit_date->format('d M Y') }}</td>
                        <td>
                            <span class="badge {{
                                $reg->status == 'completed' ? 'bg-success' :
                                ($reg->status == 'pending' ? 'bg-warning' :
                                ($reg->status == 'confirmed' ? 'bg-info' : 'bg-secondary'))
                            }}">
                                {{ Str::title($reg->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{
                                $reg->queue->status == 'waiting' ? 'bg-warning' :
                                ($reg->queue->status == 'called' ? 'bg-primary' :
                                ($reg->queue->status == 'completed' ? 'bg-success' : 'bg-danger'))
                            }}">
                                {{ Str::title($reg->queue->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('registrations.show', $reg->id) }}" class="btn btn-info btn-sm me-1"><i class="fas fa-eye"></i> Detail</a>
                            {{-- Tombol Edit hanya jika pendaftaran belum selesai --}}
                            @if($reg->status !== 'completed' && $reg->queue->status !== 'completed')
                                <a href="{{ route('registrations.edit', $reg->id) }}" class="btn btn-warning btn-sm me-1"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('registrations.destroy', $reg->id) }}" method="POST" class="d-inline" id="delete-form-registration-{{ $reg->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                        data-id="{{ $reg->id }}" data-name="{{ $reg->patientDetail->user->name ?? 'N/A' }} ({{ str_pad($reg->queue_number, 3, '0', STR_PAD_LEFT) }})">
                                        <i class="fas fa-trash"></i> Hapus
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

@push('js')
<!-- DataTables Core + Bootstrap 5 JS -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#registrationsTable').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                "processing": "Sedang memproses...",
                "lengthMenu": "Tampilkan _MENU_ entri",
                "zeroRecords": "Tidak ditemukan data yang sesuai",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                "infoFiltered": "(disaring dari _MAX_ total entri)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                },
                "aria": {
                    "sortAscending": ": aktifkan untuk mengurutkan kolom secara ascending",
                    "sortDescending": ": aktifkan untuk mengurutkan kolom secara descending"
                }
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5', text: '<i class="fas fa-copy"></i> Salin', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] }
                },
                {
                    extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] }
                },
                {
                    extend: 'pdfHtml5', text: '<i class="fas fa-file-pdf"></i> PDF', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] }
                },
                {
                    extend: 'print', text: '<i class="fas fa-print"></i> Cetak', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] }
                },
                {
                    extend: 'colvis', text: '<i class="fas fa-columns"></i> Kolom', columns: ':not(.no-export)'
                }
            ]
        });

        // Konfigurasi Toastr Options
        toastr.options = {
            "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "showDuration": "300",
            "hideDuration": "1000", "timeOut": "5000", "extendedTimeOut": "1000", "showEasing": "swing",
            "hideEasing": "linear", "showMethod": "fadeIn", "hideMethod": "fadeOut"
        };

        // Menangani pesan dari session flash
        @if(Session::has('success')) toastr.success(@json(Session::get('success'))); @endif
        @if(Session::has('error')) toastr.error(@json(Session::get('error'))); @endif
        @if(Session::has('warning')) toastr.warning(@json(Session::get('warning'))); @endif
        @if(Session::has('info')) toastr.info(@json(Session::get('info'))); @endif
        @if($errors->any()) @foreach ($errors->all() as $error) toastr.error(@json($error)); @endforeach @endif

        // Menangani konfirmasi hapus dengan SweetAlert2
        $(document).on('click', '.btn-delete', function() {
            const regId = $(this).data('id');
            const regName = $(this).data('name');
            const formId = 'delete-form-registration-' + regId;

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                html: "Pendaftaran <strong>" + regName + "</strong> akan dihapus!",
                icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal', reverseButtons: true, confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
            }).then((result) => {
                if (result.isConfirmed) { $('#' + formId).submit(); }
            });
        });

        // Tampilkan modal nomor antrean jika ada di session
        @if(session('queue_number_display'))
            var queueNumberModal = new bootstrap.Modal(document.getElementById('queueNumberModal'));
            queueNumberModal.show();
        @endif
    });
</script>
@endpush