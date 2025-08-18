<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['doctor', 'patient'])->latest()->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $doctors = Doctor::all();
        $patients = Patient::whereDate('created_at', Carbon::today())->get();

        return view('appointments.create', compact('doctors', 'patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status'           => 'nullable|string|max:255',
            'notes'            => 'nullable|string|max:1000',
        ]);

        Appointment::create($validated);

        return redirect()->route('admin.appointments.index')
                         ->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment)
    {
        // 
    }

    public function edit(Appointment $appointment)
    {
        $doctors = Doctor::all();
        $patients = Patient::all();

        return view('appointments.edit', compact('appointment', 'doctors', 'patients'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status'           => 'nullable|string|max:255',
            'notes'            => 'nullable|string|max:1000',
        ]);

        $appointment->update($validated);

        return redirect()->route('admin.appointments.index')
                         ->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
                         ->with('success', 'Appointment deleted successfully.');
    }
}
