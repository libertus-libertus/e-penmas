<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\PatientVisit;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\PatientDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display the main reports and statistics page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $reportType = $request->input('report_type', 'daily_visits'); // Default report type

        $data = [];
        $filters = $request->all();

        switch ($reportType) {
            case 'daily_visits':
                $data['dailyVisits'] = $this->getDailyVisitsReport($filters);
                break;
            case 'most_used_services':
                $data['mostUsedServices'] = $this->getMostUsedServicesReport($filters);
                break;
            case 'active_inactive_patients':
                $data['activeInactivePatients'] = $this->getActiveInactivePatientsReport($filters);
                break;
            default:
                $data['dailyVisits'] = $this->getDailyVisitsReport($filters);
                break;
        }

        // Pass all services for service filter dropdown
        $services = Service::all();

        return view('reports.index', compact('reportType', 'data', 'filters', 'services'));
    }

    /**
     * Get data for Daily Visits Report.
     *
     * @param array $filters
     * @return \Illuminate\Support\Collection
     */
    private function getDailyVisitsReport(array $filters)
    {
        $query = PatientVisit::select(
                DB::raw('DATE(visit_date) as visit_date'),
                DB::raw('COUNT(id) as total_visits')
            )
            ->groupBy(DB::raw('DATE(visit_date)'))
            ->orderBy(DB::raw('DATE(visit_date)'), 'desc');

        // Apply date range filter
        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('visit_date', [$filters['start_date'], $filters['end_date']]);
        } else {
            // Default to last 30 days if no date range specified
            $query->where('visit_date', '>=', now()->subDays(30));
        }

        return $query->get();
    }

    /**
     * Get data for Most Used Services Statistics.
     *
     * @param array $filters
     * @return \Illuminate\Support\Collection
     */
    private function getMostUsedServicesReport(array $filters)
    {
        $query = Appointment::select(
                'services.name as service_name',
                DB::raw('COUNT(appointments.id) as total_usage')
            )
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->groupBy('services.name')
            ->orderBy('total_usage', 'desc');

        // Apply date range filter (based on appointment creation date)
        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('appointments.created_at', [$filters['start_date'], $filters['end_date']]);
        } else {
            // Default to last 30 days if no date range specified
            $query->where('appointments.created_at', '>=', now()->subDays(30));
        }

        // Apply service filter if any (although this report is about finding most used, a specific service filter might be for drilling down)
        if (isset($filters['service_id']) && !empty($filters['service_id'])) {
            $query->where('appointments.service_id', $filters['service_id']);
        }

        return $query->get();
    }

    /**
     * Get data for Active/Inactive Patients Report.
     *
     * @param array $filters
     * @return array
     */
    private function getActiveInactivePatientsReport(array $filters)
    {
        $activeThresholdMonths = 12; // Define active if visited in the last 12 months

        // Get patients who have visited within the active threshold
        $activePatients = PatientDetail::whereHas('patientVisits', function ($q) use ($activeThresholdMonths) {
                $q->where('visit_date', '>=', now()->subMonths($activeThresholdMonths));
            })
            ->with('user') // Load user data for patient name
            ->get();

        // Get all patients
        $allPatients = PatientDetail::with('user', 'patientVisits') // Load patient visits to check for any visits
                                    ->get();

        // Filter out active patients from all patients to get inactive ones
        $inactivePatients = $allPatients->filter(function ($patient) use ($activePatients) {
            return !$activePatients->contains('id', $patient->id);
        });

        return [
            'active' => $activePatients,
            'inactive' => $inactivePatients,
            'threshold' => $activeThresholdMonths
        ];
    }

    /**
     * Export report data as CSV.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export(Request $request)
    {
        $reportType = $request->input('report_type');
        $filters = $request->all();
        $filename = 'report_' . $reportType . '_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() use ($reportType, $filters) {
            $handle = fopen('php://output', 'w');

            // Write CSV headers based on report type
            switch ($reportType) {
                case 'daily_visits':
                    fputcsv($handle, ['Tanggal Kunjungan', 'Jumlah Kunjungan']);
                    $data = $this->getDailyVisitsReport($filters);
                    foreach ($data as $row) {
                        fputcsv($handle, [$row->visit_date, $row->total_visits]);
                    }
                    break;
                case 'most_used_services':
                    fputcsv($handle, ['Nama Layanan', 'Jumlah Penggunaan']);
                    $data = $this->getMostUsedServicesReport($filters);
                    foreach ($data as $row) {
                        fputcsv($handle, [$row->service_name, $row->total_usage]);
                    }
                    break;
                case 'active_inactive_patients':
                    fputcsv($handle, ['Status', 'Nama Pasien', 'NIK Pasien', 'Terakhir Kunjungan (Jika Ada)']);
                    $data = $this->getActiveInactivePatientsReport($filters);
                    foreach ($data['active'] as $patient) {
                        $lastVisitDate = $patient->patientVisits->isNotEmpty() ? $patient->patientVisits->max('visit_date')->format('Y-m-d') : '-';
                        fputcsv($handle, ['Aktif', $patient->user->name ?? 'N/A', $patient->nik, $lastVisitDate]);
                    }
                    foreach ($data['inactive'] as $patient) {
                        $lastVisitDate = $patient->patientVisits->isNotEmpty() ? $patient->patientVisits->max('visit_date')->format('Y-m-d') : '-';
                        fputcsv($handle, ['Tidak Aktif', $patient->user->name ?? 'N/A', $patient->nik, $lastVisitDate]);
                    }
                    break;
            }
            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
