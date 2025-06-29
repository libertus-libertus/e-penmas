<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Queue;
use App\Models\PatientDetail;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the registrations and queues.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Registration::with(['patientDetail.user', 'service', 'queue']);

        if ($request->filled('queue_status') && $request->queue_status === 'cancelled') {
            $query->onlyTrashed();
        } else {
            $query->withoutTrashed();
        }

        if ($request->filled('visit_date')) {
            $query->whereDate('visit_date', $request->visit_date);
        }

        if ($request->filled('queue_status')) {
            $query->whereHas('queue', function ($q) use ($request) {
                $q->where('status', $request->queue_status);
            });
        }

        $registrations = $query->orderBy('visit_date', 'desc')
                                ->orderBy('queue_number', 'asc')
                                ->get();

        $patientDetails = PatientDetail::with('user')->get();
        $services = Service::all();

        return view('registrations.index', compact('registrations', 'patientDetails', 'services'));
    }

    /**
     * Show the form for creating a new registration.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $patientDetails = PatientDetail::with('user')->get();
        $services = Service::all();
        return view('registrations.create', compact('patientDetails', 'services'));
    }

    /**
     * Store a newly created registration in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_detail_id' => 'required|exists:patient_details,id',
            'service_id' => 'required|exists:services,id',
            'visit_date' => 'required|date|after_or_equal:today',
        ]);

        try {
            DB::beginTransaction();

            $lastQueueNumber = Registration::whereDate('visit_date', $request->visit_date)
                                            ->withTrashed()
                                            ->max('queue_number');
            $newQueueNumber = ($lastQueueNumber ?? 0) + 1;

            $registration = Registration::create([
                'patient_detail_id' => $request->patient_detail_id,
                'service_id' => $request->service_id,
                'visit_date' => $request->visit_date,
                'queue_number' => $newQueueNumber,
                'status' => 'completed', // Registration status set to 'completed'
            ]);

            Queue::create([
                'registration_id' => $registration->id,
                'queue_number' => $newQueueNumber,
                'status' => 'waiting', // Queue status remains 'waiting'
            ]);

            DB::commit();

            // --- PERUBAHAN DI SINI: Redirect ke halaman cetak ---
            return redirect()->route('registrations.print', $registration->id)->with('success', 'Pendaftaran berhasil dibuat dan struk antrean siap dicetak.');

        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Validation failed during registration creation: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: ' . $e->getMessage())->withErrors($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create registration: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat membuat pendaftaran: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified registration.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $registration = Registration::withTrashed()->with(['patientDetail.user', 'service', 'queue'])->findOrFail($id);
        return view('registrations.show', compact('registration'));
    }

    /**
     * Show the form for editing the queue status.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $registration = Registration::with(['patientDetail.user', 'service', 'queue'])->findOrFail($id);

        if ($registration->trashed() || ($registration->queue && $registration->queue->status === 'completed')) {
            $message = $registration->trashed() ? 'dibatalkan' : 'selesai';
            return redirect()->route('registrations.show', $registration->id)->with('error', 'Pendaftaran ini tidak dapat diedit karena sudah ' . $message . '.');
        }

        if (!$registration->queue) {
            return redirect()->back()->with('error', 'Antrean untuk pendaftaran ini tidak ditemukan.');
        }

        $queueStatuses = ['waiting', 'called', 'completed', 'skipped'];

        return view('registrations.edit', compact('registration', 'queueStatuses'));
    }

    /**
     * Update the queue status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:waiting,called,completed,skipped',
        ]);

        try {
            DB::beginTransaction();

            $registration = Registration::findOrFail($id);

            if ($registration->trashed() || ($registration->queue && $registration->queue->status === 'completed')) {
                DB::rollBack();
                $message = $registration->trashed() ? 'dibatalkan' : 'selesai';
                return redirect()->back()->with('error', 'Pendaftaran ini tidak dapat diperbarui karena sudah ' . $message . '.');
            }

            $queue = $registration->queue;

            if (!$queue) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Antrean untuk pendaftaran ini tidak ditemukan.');
            }

            $queue->status = $request->status;
            $queue->save();

            if ($request->status === 'completed') {
                $registration->status = 'completed';
                $registration->save();
            }

            DB::commit();

            return redirect()->route('registrations.index')->with('success', 'Status antrean berhasil diperbarui.');

        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Validation failed during queue status update: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return redirect()->back()->with('error', 'Validasi gagal: ' . $e->getMessage())->withErrors($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update queue status: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui status antrean: ' . $e->getMessage());
        }
    }

    /**
     * Soft delete a registration (cancel).
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $registration = Registration::findOrFail($id);

            $registration->status = 'cancelled';
            $registration->save();

            $registration->delete(); // Perform soft delete

            if ($registration->queue) {
                $registration->queue->status = 'cancelled';
                $registration->queue->save();
            }

            DB::commit();

            return redirect()->route('registrations.index')->with('success', 'Pendaftaran berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to cancel registration: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membatalkan pendaftaran: ' . $e->getMessage());
        }
    }

    /**
     * Show the print-friendly queue ticket.
     *
     * @param  int  $id Registration ID
     * @return \Illuminate\View\View
     */
    public function printQueue($id)
    {
        // Load the registration with necessary relationships
        $registration = Registration::with(['patientDetail.user', 'service', 'queue'])->findOrFail($id);
        return view('registrations.print_queue', compact('registration'));
    }
}
