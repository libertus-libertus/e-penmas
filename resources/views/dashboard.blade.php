@extends('layouts.dashboard')

@section('title')
    Dashboard Petugas Puskesmas Nanggalo Siteba
@endsection

@section('sub_title')
    Ringkasan Dashboard
@endsection

@push('scripts')
{{-- Chart.js CDN for charts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="row mb-3 g-3">
    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
        <div class="card card-dashboard text-center">
            <div class="card-body">
                <i class="fas fa-users card-icon"></i>
                <div class="statistic-value text-success">
                    {{ $totalPatients }}
                </div>
                <div class="statistic-label">Pasien Terdaftar</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
        <div class="card card-dashboard text-center">
            <div class="card-body">
                <i class="fas fa-clipboard-list card-icon"></i>
                <div class="statistic-value text-info">{{ $todayRegistrations }}</div>
                <div class="statistic-label">Pendaftaran Hari Ini</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
        <div class="card card-dashboard text-center">
            <div class="card-body">
                <i class="fas fa-hourglass-half card-icon"></i>
                <div class="statistic-value text-warning">{{ $waitingQueues }}</div>
                <div class="statistic-label">Menunggu Antrean</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
        <div class="card card-dashboard text-center">
            <div class="card-body">
                <i class="fas fa-check-circle card-icon"></i>
                <div class="statistic-value text-primary">{{ $completedServicesToday }}</div>
                <div class="statistic-label">Pelayanan Selesai Hari Ini</div>
            </div>
        </div>
    </div>
</div>

<div class="card card-dashboard mb-3" data-aos="fade-up" data-aos-delay="500">
    <div class="card-header">
        <i class="fas fa-list-ol me-1"></i> Antrean Pasien Saat Ini
    </div>
    <div class="card-body p-0">
        <div class="table-responsive table-responsive-custom">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No. Antrean</th>
                        <th>Nama Pasien</th>
                        <th>Pelayanan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($currentQueues as $queueItem)
                    <tr data-aos="fade-in" data-aos-delay="{{ 600 + ($loop->index * 100) }}">
                        <td>{{ sprintf('%03d', $queueItem->queue_number) }}</td>
                        <td>{{ $queueItem->patientDetail->user->name ?? 'N/A' }}</td>
                        <td>{{ $queueItem->service->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{
                                $queueItem->queue->status == 'waiting' ? 'bg-warning' :
                                ($queueItem->queue->status == 'called' ? 'bg-info' : 'bg-secondary')
                            }}">
                                {{ Str::title($queueItem->queue->status ?? '-') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('registrations.edit', $queueItem->id) }}" class="btn btn-sm btn-primary me-1" title="Edit Status Antrean"><i class="fas fa-edit"></i></a>
                            <a href="{{ route('registrations.print', $queueItem->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Cetak Struk Antrean"><i class="fas fa-print"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Tidak ada antrean yang menunggu atau dipanggil saat ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6" data-aos="fade-right" data-aos-delay="1100">
        <div class="card card-dashboard">
            <div class="card-header">
                <i class="fas fa-chart-bar me-1"></i> Kunjungan Harian (7 Hari Terakhir)
            </div>
            <div class="card-body p-2">
                <canvas id="dailyVisitsChart" style="height: 250px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6" data-aos="fade-left" data-aos-delay="1200">
        <div class="card card-dashboard">
            <div class="card-header">
                <i class="fas fa-pie-chart me-1"></i> Layanan Terpopuler (30 Hari Terakhir)
            </div>
            <div class="card-body p-2">
                <canvas id="popularServicesChart" style="height: 250px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card card-dashboard mt-3" data-aos="fade-up" data-aos-delay="1300">
    <div class="card-header">
        <i class="fas fa-user-injured me-1"></i> Pasien Terbaru
    </div>
    <div class="card-body p-0">
        <div class="table-responsive table-responsive-custom">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nama Pasien</th>
                        <th>NIK</th>
                        <th>BPJS</th>
                        <th>Tanggal Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestPatients as $patient)
                    <tr data-aos="fade-in" data-aos-delay="{{ 1400 + ($loop->index * 100) }}">
                        <td>{{ $patient->user->name ?? 'N/A' }}</td>
                        <td>{{ $patient->nik ?? '-' }}</td>
                        <td><span class="badge {{ $patient->bpjs_status ? 'bg-success' : 'bg-secondary' }}">{{ $patient->bpjs_status ? 'Aktif' : 'Non Aktif' }}</span></td>
                        <td>{{ $patient->created_at->format('d/m/y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Tidak ada data pasien terbaru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Data for Daily Visits Chart
        const dailyVisitsCtx = document.getElementById('dailyVisitsChart').getContext('2d');
        new Chart(dailyVisitsCtx, {
            type: 'bar',
            data: {
                labels: @json($dailyVisitsLabels),
                datasets: [{
                    label: 'Jumlah Kunjungan',
                    data: @json($dailyVisitsData),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {if (value % 1 === 0) {return value;}} // Show only whole numbers
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Data for Popular Services Chart
        const popularServicesCtx = document.getElementById('popularServicesChart').getContext('2d');
        new Chart(popularServicesCtx, {
            type: 'pie', // Changed to pie chart for better representation of popular services
            data: {
                labels: @json($popularServicesLabels),
                datasets: [{
                    label: 'Jumlah Penggunaan',
                    data: @json($popularServicesData),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right', // Position legend to the right
                    }
                }
            }
        });
    });
</script>
@endpush
