<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Registration;
use App\Models\User;     // To get staff/admin users
use App\Models\Service;  // To get service types
use App\Models\PatientDetail; // To get patient details from registration
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the appointments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Appointment::with([
            'registration.patientDetail.user', // Patient name via user
            'user', // Staff/admin name
            'service'
        ]);

        // Optional: Filter by registration ID
        if ($request->filled('registration_id')) {
            $query->where('registration_id', $request->registration_id);
        }

        // Optional: Filter by service provider (user_id)
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Optional: Filter by service type (service_id)
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        // Optional: Filter by patient name (via registration -> patientDetail -> user)
        if ($request->filled('patient_name')) {
            $query->whereHas('registration.patientDetail.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->patient_name . '%');
            });
        }


        $appointments = $query->latest()->get(); // Order by latest created

        // Data for filters dropdowns (if applicable in index view)
        $registrations = Registration::with('patientDetail.user')->get(); // Get active registrations
        $staffUsers = User::whereIn('role', ['staff', 'admin'])->get();
        $services = Service::all();

        return view('appointments.index', compact('appointments', 'registrations', 'staffUsers', 'services'));
    }

    /**
     * Show the form for creating a new appointment.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Only show registrations that are 'completed' (from the registration table status)
        // AND whose queue status is NOT 'completed' or 'cancelled'
        // This means, registrations for which service can still be logged.
        // Or, if registration status is 'completed' as per the last requirement,
        // we show registrations whose queue status is 'waiting', 'called', 'skipped'
        // and for which an appointment hasn't been created yet.
        // For simplicity, let's allow creating appointments for any non-cancelled registration
        // that doesn't already have an appointment.

        $registrations = Registration::whereDoesntHave('appointment') // Ensure no existing appointment for this registration
                                    ->withoutTrashed() // Exclude soft-deleted registrations
                                    ->get();

        $staffUsers = User::whereIn('role', ['staff', 'admin'])->get(); // Only staff and admin can be service providers
        $services = Service::all();

        return view('appointments.create', compact('registrations', 'staffUsers', 'services'));
    }

    /**
     * Store a newly created appointment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id|unique:appointments,registration_id', // One appointment per registration
            'user_id' => 'required|exists:users,id', // Must be an existing user
            'service_id' => 'required|exists:services,id', // Must be an existing service
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $appointment = Appointment::create($request->all());

            // Optional: Update the status of the associated registration if necessary
            // For instance, if an appointment marks the 'completion' of a visit,
            // you might want to update the registration status here.
            // Based on previous discussion, registration status is 'completed' on creation.
            // So no changes needed for registration status here.
            // If you want to update queue status here to 'completed' after service, you can:
            // $registration = $appointment->registration;
            // if ($registration && $registration->queue) {
            //     $registration->queue->status = 'completed';
            //     $registration->queue->save();
            // }


            DB::commit();

            return redirect()->route('appointments.index')->with('success', 'Catatan pelayanan berhasil ditambahkan.');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Validation failed during appointment creation: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: ' . $e->getMessage())->withErrors($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create appointment: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan catatan pelayanan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified appointment.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $appointment = Appointment::with([
            'registration.patientDetail.user',
            'user',
            'service'
        ])->findOrFail($id);
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $appointment = Appointment::with([
            'registration.patientDetail.user',
            'user',
            'service'
        ])->findOrFail($id);

        $staffUsers = User::whereIn('role', ['staff', 'admin'])->get();
        $services = Service::all();

        return view('appointments.edit', compact('appointment', 'staffUsers', 'services'));
    }

    /**
     * Update the specified appointment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $appointment = Appointment::findOrFail($id);
            $appointment->update($request->all());

            DB::commit();

            return redirect()->route('appointments.index')->with('success', 'Catatan pelayanan berhasil diperbarui.');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Validation failed during appointment update: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: ' . $e->getMessage())->withErrors($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update appointment: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui catatan pelayanan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified appointment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $appointment = Appointment::findOrFail($id);
            $appointment->delete(); // This is a hard delete as SoftDeletes is not applied yet.

            DB::commit();

            return redirect()->route('appointments.index')->with('success', 'Catatan pelayanan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete appointment: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus catatan pelayanan: ' . $e->getMessage());
        }
    }
}
