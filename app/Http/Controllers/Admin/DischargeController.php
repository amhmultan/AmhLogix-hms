<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Dosage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DischargeController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Discharge access|Discharge create|Discharge edit|Discharge delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Discharge create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Discharge edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Discharge delete', ['only' => ['destroy']]);
    }

    /**
     * Show discharge form for an admission
     */
    public function create(Admission $admission)
    {
        // Load related models
        $admission->load(['patient', 'doctor', 'bed.ward']);

        $dosages = Dosage::where('status', 0)->get();

        return view('admissions.discharge', compact('admission', 'dosages'));
    }

    /**
     * Process discharge of patient
     */
    public function store(Request $request, Admission $admission)
    {
        // Validate inputs
        $request->validate([
            'clinical_notes' => 'nullable|string',
            'medications'    => 'nullable|string',
            'follow_up'      => 'nullable|string',
            'dm'             => 'nullable|string',
            'htn'            => 'nullable|string',
            'ihd'            => 'nullable|string',
            'asthma'         => 'nullable|string',
        ]);

        // 1. Update Admission
        $admission->update([
            'status' => 'discharged',
            'discharge_date' => now(),
        ]);

        // 2. Create or Update Discharge Summary
        $dischargeSummary = $admission->dischargeSummary()->updateOrCreate(
            ['admission_id' => $admission->id],
            [
                'clinical_notes' => $request->clinical_notes,
                'medications'    => $request->medications,
                'follow_up'      => $request->follow_up,
                'dm'             => $request->dm,
                'htn'            => $request->htn,
                'ihd'            => $request->ihd,
                'asthma'         => $request->asthma,
            ]
        );

        // 3. SAVE DISCHARGE MEDICINES (SAFE VERSION)
        $items = $request->items ?? [];

        if (!empty($items)) {

            // delete old items (for update case)
            $dischargeSummary->items()->delete();

            foreach ($items as $item) {

                if (empty($item['product_id'])) {
                    continue;
                }

                \App\Models\DischargeSummaryItem::create([
                    'discharge_summary_id' => $dischargeSummary->id,
                    'product_id' => $item['product_id'] ?? null,
                    'dosage_id'  => $item['dosage_id'] ?? null,
                    'duration'   => $item['duration'] ?? null,
                    'remarks'    => $item['remarks'] ?? null,
                ]);
            }
        }

        // 4. Calculate room charges
        $totalDays = $admission->admission_date->diffInDays(now()) + 1;
        $roomRate = $admission->bed->room_rate ?? 0;
        $roomAmount = $roomRate * $totalDays;

        // (optional: you can store this in billing table if needed)

        // 5. Free bed
        if ($admission->bed) {
            $admission->bed->update([
                'status' => 'available'
            ]);
        }

        return redirect()
            ->route('admin.admissions.index')
            ->with('success', 'Patient discharged successfully!');
    }

    /**
     * Print discharge slip
     */
    public function printSlip(Admission $admission)
    {
        $hospital = \App\Models\Hospital::first();

        $admission->load([
            'patient',
            'doctor',
            'bed.ward',
            'dischargeSummary.items.product',
            'dischargeSummary.items.dosage',
            'charges'
        ]);

        // Calculate total admitted days
        $admissionDate = $admission->admission_date;
        $dischargeDate = $admission->discharge_date ?? now();
        $totalDays = $admissionDate->diffInDays($dischargeDate) + 1;

        // Room amount
        $roomRate = $admission->bed->rate_per_day ?? 0;
        $roomAmount = $roomRate * $totalDays;

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

        $admission->load([
            'patient',
            'doctor',
            'bed.ward',
            'dischargeSummary.items.product',
            'dischargeSummary.items.dosage'
        ]);

        return view('admissions.discharge-notes', [
            'hospital' => $hospital,
            'admission' => $admission,
            'doctor' => $doctor,
        ]);
    }
}
