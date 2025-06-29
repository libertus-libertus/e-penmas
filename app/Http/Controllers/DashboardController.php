<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PatientDetail;
use App\Models\Registration;
use App\Models\Queue;
use App\Models\Appointment;
use App\Models\PatientVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Import Carbon for date handling

class DashboardController extends Controller
{
    /**
     * Display the main dashboard summary.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Statistik Kartu (Card Statistics)
        $totalPatients = PatientDetail::count();
        $todayRegistrations = Registration::whereDate('visit_date', today())->count();
        $waitingQueues = Queue::where('status', 'waiting')->count();
        // Count completed services for today. Using Appointments table for this.
        $completedServicesToday = Appointment::whereDate('created_at', today())->count();


        // 2. Antrean Pasien Saat Ini (Current Patient Queues)
        // Only show 'waiting' or 'called' queues for today, ordered by queue number
        $currentQueues = Registration::with(['patientDetail.user', 'service', 'queue'])
            ->whereDate('visit_date', today())
            ->whereHas('queue', function ($query) {
                $query->whereIn('status', ['waiting', 'called']);
            })
            ->orderBy('queue_number', 'asc')
            ->get();


        // 3. Pasien Terbaru (Latest Patients)
        $latestPatients = PatientDetail::with('user')->latest()->limit(5)->get();


        // 4. Data untuk Grafik (Chart Data) - Default for a week/month, can be dynamic
        // Kunjungan Harian (Daily Visits) - Last 7 days
        $dailyVisits = PatientVisit::select(
                DB::raw('DATE(visit_date) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('visit_date', '>=', Carbon::today()->subDays(6)) // Last 7 days including today
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Format dates for chart labels and ensure all 7 days are present
        $dailyVisitsData = [];
        $dailyVisitsLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dailyVisitsLabels[] = $date->format('D, d M'); // e.g., Mon, 24 Jun
            $dailyVisitsData[] = $dailyVisits->where('date', $date->format('Y-m-d'))->first()->count ?? 0;
        }


        // Layanan Terpopuler (Most Popular Services) - Last 30 days
        $popularServices = Appointment::select(
                'services.name as name',
                DB::raw('COUNT(appointments.id) as count')
            )
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->where('appointments.created_at', '>=', Carbon::today()->subDays(29)) // Last 30 days including today
            ->groupBy('services.name')
            ->orderBy('count', 'desc')
            ->limit(5) // Top 5 services
            ->get();

        $popularServicesLabels = $popularServices->pluck('name')->toArray();
        $popularServicesData = $popularServices->pluck('count')->toArray();


        return view('dashboard', compact(
            'totalPatients',
            'todayRegistrations',
            'waitingQueues',
            'completedServicesToday',
            'currentQueues',
            'latestPatients',
            'dailyVisitsData',
            'dailyVisitsLabels',
            'popularServicesLabels',
            'popularServicesData'
        ));
    }
}
