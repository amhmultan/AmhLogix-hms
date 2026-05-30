<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DischargeController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Discharge access|Discharge create|Discharge edit|Discharge delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Discharge create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Discharge edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Discharge delete', ['only' => ['destroy']]);
    }

    /**
     * Show discharge form for an admission
     */
    public function create(Admission $admission)
    {
        // Load related models
        $admission->load(['patient', 'doctor', 'bed.ward']);

        return view('admissions.discharge', compact('admission'));
    }

    /**
     * Process discharge of patient
     */
    public function store(Request $request, Admission $admission)
    {
        // Validate inputs
        $request->validate([
            'clinical_notes' => 'nullable|string',
            'medications' => 'nullable|string',
            'follow_up' => 'nullable|string',
            'dm' => 'nullable|string',
            'htn' => 'nullable|string',
            'ihd' => 'nullable|string',
            'asthma' => 'nullable|string',
        ]);
        
        // 1. Update Admission
        $admission->update([
            'status' => 'discharged',
            'discharge_date' => now(),
        ]);

        // 2. Create or update Discharge Summary
        $admission->dischargeSummary()->updateOrCreate(
            ['admission_id' => $admission->id],
            [
                'clinical_notes' => $request->clinical_notes,
                'medications' => $request->medications,
                'follow_up' => $request->follow_up,
                'dm' => $request->dm,
                'htn' => $request->htn,
                'ihd' => $request->ihd,
                'asthma' => $request->asthma,
            ]
        );

        // 3. Optional: calculate total days & room charges (for billing if needed)
        $totalDays = $admission->admission_date->diffInDays($admission->discharge_date) + 1;
        $roomRate = $admission->bed->room_rate ?? 0;
        $roomAmount = $roomRate * $totalDays;

        // 4. Free up the bed
        $admission->bed->update(['status' => 'available']);

        return redirect()
            ->route('admin.admissions.index', $admission->id)
            ->with('success', 'Patient discharged successfully!');
    }

    /**
     * Print discharge slip
     */
    public function printSlip(Admission $admission)
    {
        $hospital = \App\Models\Hospital::first();
        
        $admission->load(['patient', 'doctor', 'bed.ward', 'dischargeSummary', 'charges']);

        // Calculate total admitted days
        $admissionDate = $admission->admission_date;
        $dischargeDate = $admission->discharge_date ?? now();
        $totalDays = $admissionDate->diffInDays($dischargeDate) + 1; // +1 to count first day

        // Calculate room amount
        $roomRate = $admission->bed->rate_per_day ?? 0;
        $roomAmount = $roomRate * $totalDays;

        // Pass to view
        return view('admissions.discharge-slip', [
            'admission' => $admission,
            'totalDays' => $totalDays,
            'roomAmount' => $roomAmount,
            'hospital' => $hospital,
        ]);
    }
    /**
     * Print discharge notes
     */
    public function printNotes(Admission $admission)
    {
        $hospital = \App\Models\Hospital::first();
        $doctor = \App\Models\Doctor::first();
        
        $admission->load(['patient', 'doctor', 'bed.ward']);

        return view('admissions.discharge-notes', [
            'hospital' => $hospital,
            'admission' => $admission,
            'doctor' => $doctor,
        ]);
    }
}
