<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DoctorNotes;

class DoctorNotesController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:DoctorNotes access|DoctorNotes add|DoctorNotes edit|DoctorNotes delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:DoctorNotes add', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:DoctorNotes edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:DoctorNotes delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctor_notes = DB::table('doctor_notes')
            ->join('patients', 'patients.id','fk_patient_id')
            ->join('tokens', 'tokens.id', 'fk_token_id')
            ->select('doctor_notes.*','patients.name', 'tokens.created_at')
            ->get();

        return view('doctor_notes.index', ['doctor_notes' => $doctor_notes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $search = $request['search'] ?? "";

        $tokens = DB::table('tokens')
            ->join('patients', 'patients.id', '=', 'tokens.fk_patients_id')
            ->select('tokens.id', 'tokens.fk_patients_id', 'patients.name', 'tokens.created_at')
            ->where('tokens.id','LIKE',"%$search%")
            ->get();

        return view('doctor_notes.new', [
            'search' => $search,
            'tokens' => $tokens
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new DoctorNotes();

        $data->fk_patient_id = $request->fk_patient_id;
        $data->fk_token_id = $request->fk_token_id;
        $data->mode = $request->mode;

        if ($request->mode === 'upload') {
            // Handle file upload
            if ($request->hasFile('prescription')) {
                $prescription = $request->file('prescription');
                $prescriptionName = time().'.'.$prescription->getClientOriginalExtension();
                $prescription->move('assets', $prescriptionName);
                $data->prescription = $prescriptionName;
            }
        } else {
            // Manual entry fields
            $data->complaints = $request->complaints;
            $data->history = $request->history;
            $data->investigations = $request->investigations;
            $data->prescription_text = $request->prescription_text;
            $data->remarks = $request->remarks;
        }

        $data->save();

        return redirect('/admin/doctor_notes')->withSuccess('Notes saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $doctor_notes = DoctorNotes::findOrFail($id);

        $hospital = null;
        $token = null;

        // Only fetch extra details when mode = manual
        if ($doctor_notes->mode === 'manual') {
            // Get hospital information (adjust table/fields if needed)
            $hospital = DB::table('hospitals')->first();

            // Fetch token with patient details
            $token = DB::table('tokens')
                ->join('patients', 'patients.id', '=', 'tokens.fk_patients_id')
                ->select(
                    'tokens.*',
                    'patients.name as pName',
                    'patients.fname as fName',
                    'patients.dob as pAge',
                    'patients.address as pAddress',
                    'patients.phone as pPhone',
                )
                ->where('tokens.id', $doctor_notes->fk_token_id)
                ->first();
        }

        return view('doctor_notes.show', compact('doctor_notes', 'hospital', 'token'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $doctor_notes = DoctorNotes::find($id);
        return view('doctor_notes.edit',['doctor_notes' => $doctor_notes]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $doctor_notes = DoctorNotes::find($id);

        $doctor_notes->mode = $request->mode;

        if ($request->mode === 'upload') {
            if ($request->hasFile('prescription')) {
                $prescription = $request->file('prescription');
                $prescriptionName = time().'.'.$prescription->getClientOriginalExtension();
                $prescription->move('assets', $prescriptionName);
                $doctor_notes->prescription = $prescriptionName;
            }
            // Clear manual fields when switching to upload mode
            $doctor_notes->complaints = null;
            $doctor_notes->history = null;
            $doctor_notes->investigations = null;
            $doctor_notes->prescription_text = null;
            $doctor_notes->remarks = null;
        } else {
            // Update manual fields
            $doctor_notes->complaints = $request->complaints;
            $doctor_notes->history = $request->history;
            $doctor_notes->investigations = $request->investigations;
            $doctor_notes->prescription_text = $request->prescription_text;
            $doctor_notes->remarks = $request->remarks;
            // Clear file if switching to manual
            $doctor_notes->prescription = null;
        }

        $doctor_notes->update();

        return redirect('/admin/doctor_notes')->withSuccess('Doctor Notes updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $doctor_notes = DoctorNotes::find($id);
        $doctor_notes->delete();
        return redirect('/admin/doctor_notes')->withSuccess('Doctor Notes deleted!');
    }

    public function print($id)
    {
        $doctor_notes = DoctorNotes::findOrFail($id);

        // Fetch hospital and token data if manual mode
        $hospital = null;
        $token = null;

        if ($doctor_notes->mode === 'manual') {
            $token = DB::table('tokens')
                ->join('patients', 'patients.id', '=', 'tokens.fk_patients_id')
                ->select(
                    'tokens.*',
                    'patients.name as pName',
                    'patients.fname as fName'
                )
                ->where('tokens.id', $doctor_notes->fk_token_id)
                ->first();

            // If you have hospital settings table
            $hospital = DB::table('hospitals')->first();
        }

        return view('doctor_notes.print', compact('doctor_notes', 'hospital', 'token'));
    }

}