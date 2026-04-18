<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Bed;
use App\Models\DailyNote;
use App\Models\Charge;
use App\Models\Ward;

use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:IPD_Admission access|IPD_Admission create|IPD_Admission edit|IPD_Admission delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:IPD_Admission create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:IPD_Admission edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:IPD_Admission delete', ['only' => ['destroy']]);
    }

    /** Display list of admissions */
    public function index()
    {
        $admissions = Admission::with(['patient', 'doctor', 'bed.ward'])
            ->orderBy('admission_date', 'desc')
            ->get();

        return view('admissions.index', compact('admissions'));
    }

    /** Show admission creation form */
    public function create(Request $request)
    {
        $search = $request->get('search', '');

        $patients = $search 
            ? Patient::where('id', $search)->get() 
            : collect();

        $doctors = Doctor::all();
        $beds = Bed::where('status', 'available')->with('ward')->get();

        return view('admissions.create', compact('patients', 'doctors', 'beds', 'search'));
    }

    /** Store a new admission */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id'     => 'required|exists:patients,id',
            'doctor_id'      => 'required|exists:doctors,id',
            'bed_id'         => 'required|exists:beds,id',
            'diagnosis'      => 'required|string|max:255',
            'admission_fees' => 'nullable|numeric|min:0',
        ]);

        $admission = Admission::create([
            'patient_id'     => $request->patient_id,
            'doctor_id'      => $request->doctor_id,
            'bed_id'         => $request->bed_id,
            'diagnosis'      => $request->diagnosis,
            'admission_fees' => $request->admission_fees ?? 0,
            'status'         => 'admitted',
            'admission_date' => now(),
        ]);

        // Mark bed as occupied
        $bed = Bed::find($request->bed_id);
        $bed->status = 'occupied';
        $bed->save();

        return redirect()->route('admin.admissions.index')
                        ->with('success', 'Patient admitted successfully.');
    }

    /** Show admission details */
    public function show(Admission $admission)
    {
        $admission->load(['patient', 'doctor', 'bed.ward']);
        return view('admissions.show', compact('admission'));
    }

    /** Show edit form */
    public function edit($id)
    {
        $admission = Admission::findOrFail($id);
        $patients = Patient::where('id', $admission->patient_id)->get();
        $doctors = Doctor::all();

        // Include current bed + all available beds
        $beds = Bed::where(function($query) use ($admission) {
            $query->where('status', 'available')
                  ->orWhere('id', $admission->bed_id); // Include current bed
        })->with('ward')->get();

        return view('admissions.edit', compact('admission', 'patients', 'doctors', 'beds'));
    }

    /** Update admission */
    public function update(Request $request, $id)
    {
        $admission = Admission::findOrFail($id);

        $request->validate([
            'doctor_id'      => 'required|exists:doctors,id',
            'bed_id'         => 'required|exists:beds,id',
            'diagnosis'      => 'required|string|max:255',
            'admission_fees' => 'nullable|numeric|min:0',
        ]);

        // Free old bed if changed
        if ($admission->bed_id != $request->bed_id) {
            $oldBed = Bed::find($admission->bed_id);
            if ($oldBed) {
                $oldBed->status = 'available';
                $oldBed->save();
            }

            $newBed = Bed::find($request->bed_id);
            $newBed->status = 'occupied';
            $newBed->save();
        }

        $admission->update([
            'doctor_id'      => $request->doctor_id,
            'bed_id'         => $request->bed_id,
            'diagnosis'      => $request->diagnosis,
            'admission_fees' => $request->admission_fees ?? 0,
        ]);

        return redirect()->route('admin.admissions.index')
                        ->with('success', 'Admission updated successfully.');
    }

    /** Print Admission Slip */
    public function printSlip(Admission $admission)
    {
        $hospital = \App\Models\Hospital::first(); // optional if you store hospital info
        $admission->load(['patient', 'doctor', 'bed.ward']);

        return view('admissions.admission-slip', compact('admission', 'hospital'));
    }

    /** Show discharge form */
    public function createDischarge(Admission $admission)
    {
        return view('admissions.discharge', compact('admission'));
    }

    /** Store discharge */
    public function storeDischarge(Request $request, $id)
    {
        $admission = Admission::findOrFail($id);

        $admission->discharge_date = now();
        $admission->status = 'discharged';
        $admission->save();

        // Free bed
        $bed = Bed::find($admission->bed_id);
        if ($bed) {
            $bed->status = 'available';
            $bed->save();
        }

        return redirect()->route('admin.admissions.index')
                         ->with('success', 'Patient discharged successfully.');
    }

    /** IPD Dashboard */
    public function ipdDashboard()
    {
        $wardsCount = Ward::count();
        $availableBeds = Bed::where('status', 'available')->count();
        $admissionsCount = Admission::where('status', 'admitted')->count();
        $chargesCount = Charge::count();
        $notesCount = DailyNote::count();
        $dischargedCount = Admission::where('status', 'discharged')->count();
        $reports = 1; // Placeholder for reports count or data

        return view('ipd.index', compact(
            'wardsCount',
            'availableBeds',
            'admissionsCount',
            'chargesCount',
            'notesCount',
            'dischargedCount',
            'reports'
        ));
    }
}
