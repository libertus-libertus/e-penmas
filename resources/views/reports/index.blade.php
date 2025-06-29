@extends('layouts.dashboard')

@section('title')
Laporan & Statistik
@endsection

@section('sub_title')
Analisis Data Puskesmas
@endsection

@push('styles')
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
@endpush

@section('content')

<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header"><i class="fas fa-chart-bar me-1"></i> Pilih Jenis Laporan</div>
    <div class="card-body">
        <form id="reportTypeForm" method="GET" action="{{ route('reports.index') }}" class="row g-3 align-items-end">
            <div class="col-md-6 col-sm-12">
                <label for="report_type" class="form-label">Jenis Laporan</label>
                <select class="form-select" id="report_type" name="report_type">
                    <option value="daily_visits" {{ $reportType == 'daily_visits' ? 'selected' : '' }}>Laporan Jumlah Kunjungan Harian</option>
                    <option value="most_used_services" {{ $reportType == 'most_used_services' ? 'selected' : '' }}>Statistik Jenis Layanan Terbanyak Digunakan</option>
                    <option value="active_inactive_patients" {{ $reportType == 'active_inactive_patients' ? 'selected' : '' }}>Laporan Pasien Aktif/Tidak Aktif</option>
                </select>
            </div>
            
            {{-- Filter Tanggal (untuk Kunjungan Harian & Layanan Terbanyak) --}}
            <div id="date-filters" class="col-md-6 col-sm-12 row g-3">
                <div class="col-md-6">
                    <label for="start_date" class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $filters['start_date'] ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label for="end_date" class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $filters['end_date'] ?? '' }}">
                </div>
            </div>

            {{-- Filter Layanan (untuk Layanan Terbanyak) --}}
            <div id="service-filter" class="col-md-6 col-sm-12" style="display: {{ $reportType == 'most_used_services' ? 'block' : 'none' }};">
                <label for="service_id" class="form-label">Filter Berdasarkan Layanan (Opsional)</label>
                <select class="form-select" id="service_id" name="service_id">
                    <option value="">Semua Layanan</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ ($filters['service_id'] ?? '') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-action-primary me-2"><i class="fas fa-eye me-1"></i> Tampilkan Laporan</button>
                @if(count($data) > 0 && !(empty($data['dailyVisits']) && empty($data['mostUsedServices']) && empty($data['activeInactivePatients'])))
                    <a href="{{ route('reports.export', array_merge(['report_type' => $reportType], $filters)) }}" class="btn btn-success">
                        <i class="fas fa-file-excel me-1"></i> Export CSV
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="200">
    <div class="card-header"><i class="fas fa-chart-pie me-1"></i> Hasil Laporan</div>
    <div class="card-body">
        {{-- Laporan Jumlah Kunjungan Harian --}}
        @if($reportType == 'daily_visits')
            <h4>Laporan Jumlah Kunjungan Harian</h4>
            @if($data['dailyVisits']->isEmpty())
                <div class="alert alert-info">Tidak ada data kunjungan untuk periode ini.</div>
            @else
                <div class="table-responsive table-responsive-custom">
                    <table class="table table-hover table-striped w-100" id="dailyVisitsTable">
                        <thead>
                            <tr>
                                <th>Tanggal Kunjungan</th>
                                <th>Jumlah Kunjungan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['dailyVisits'] as $visit)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($visit->visit_date)->format('d M Y') }}</td>
                                <td>{{ $visit->total_visits }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif

        {{-- Statistik Jenis Layanan Terbanyak Digunakan --}}
        @if($reportType == 'most_used_services')
            <h4>Statistik Jenis Layanan Terbanyak Digunakan</h4>
            @if($data['mostUsedServices']->isEmpty())
                <div class="alert alert-info">Tidak ada data layanan untuk periode ini.</div>
            @else
                <div class="table-responsive table-responsive-custom">
                    <table class="table table-hover table-striped w-100" id="mostUsedServicesTable">
                        <thead>
                            <tr>
                                <th>Nama Layanan</th>
                                <th>Jumlah Penggunaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['mostUsedServices'] as $service)
                            <tr>
                                <td>{{ $service->service_name }}</td>
                                <td>{{ $service->total_usage }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif

        {{-- Laporan Pasien Aktif/Tidak Aktif --}}
        @if($reportType == 'active_inactive_patients')
            <h4>Laporan Pasien Aktif/Tidak Aktif (Kunjungan dalam {{ $data['activeInactivePatients']['threshold'] }} Bulan Terakhir)</h4>
            @if($data['activeInactivePatients']['active']->isEmpty() && $data['activeInactivePatients']['inactive']->isEmpty())
                <div class="alert alert-info">Tidak ada data pasien untuk laporan ini.</div>
            @else
                <div class="table-responsive table-responsive-custom mb-4">
                    <h5>Pasien Aktif (Total: {{ $data['activeInactivePatients']['active']->count() }})</h5>
                    <table class="table table-hover table-striped w-100" id="activePatientsTable">
                        <thead>
                            <tr>
                                <th>Nama Pasien</th>
                                <th>NIK Pasien</th>
                                <th>Terakhir Kunjungan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['activeInactivePatients']['active'] as $patient)
                            <tr>
                                <td>{{ $patient->user->name ?? 'N/A' }}</td>
                                <td>{{ $patient->nik ?? '-' }}</td>
                                <td>{{ $patient->patientVisits->isNotEmpty() ? $patient->patientVisits->max('visit_date')->format('d M Y') : '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive table-responsive-custom">
                    <h5>Pasien Tidak Aktif (Total: {{ $data['activeInactivePatients']['inactive']->count() }})</h5>
                    <table class="table table-hover table-striped w-100" id="inactivePatientsTable">
                        <thead>
                            <tr>
                                <th>Nama Pasien</th>
                                <th>NIK Pasien</th>
                                <th>Terakhir Kunjungan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['activeInactivePatients']['inactive'] as $patient)
                            <tr>
                                <td>{{ $patient->user->name ?? 'N/A' }}</td>
                                <td>{{ $patient->nik ?? '-' }}</td>
                                <td>{{ $patient->patientVisits->isNotEmpty() ? $patient->patientVisits->max('visit_date')->format('d M Y') : 'Belum Pernah Kunjungan / Lebih dari ' . $data['activeInactivePatients']['threshold'] . ' bulan' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
    </div>
</div>

@endsection

@push('scripts')
<!-- DataTables Core + Bootstrap 5 JS -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        // Initialize DataTables for each report table
        $('#dailyVisitsTable').DataTable({
            responsive: true, autoWidth: false, paging: false, info: false, searching: false, "order": []
        });
        $('#mostUsedServicesTable').DataTable({
            responsive: true, autoWidth: false, paging: false, info: false, searching: false, "order": []
        });
        $('#activePatientsTable').DataTable({
            responsive: true, autoWidth: false, paging: false, info: false, searching: false, "order": []
        });
        $('#inactivePatientsTable').DataTable({
            responsive: true, autoWidth: false, paging: false, info: false, searching: false, "order": []
        });

        // Function to toggle filter visibility
        function toggleFilters() {
            const reportType = $('#report_type').val();
            if (reportType === 'most_used_services') {
                $('#date-filters').show();
                $('#service-filter').show();
            } else if (reportType === 'daily_visits') {
                $('#date-filters').show();
                $('#service-filter').hide(); // Hide service filter for daily visits
                $('#service_id').val(''); // Clear service filter value
            } else { // active_inactive_patients
                $('#date-filters').hide();
                $('#service-filter').hide();
                // Clear all filter values when not needed
                $('#start_date').val('');
                $('#end_date').val('');
                $('#service_id').val('');
            }
        }

        // Call on page load
        toggleFilters();

        // Call on report type change
        $('#report_type').on('change', function() {
            toggleFilters();
            // Submit form to reload report with new type
            $(this).closest('form').submit();
        });

        // Initialize Toastr for session messages
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    });
</script>
@endpush
