<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DoctorNotes;

class DoctorNotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:DoctorNotes access|DoctorNotes add|DoctorNotes edit|DoctorNotes delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:DoctorNotes add', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:DoctorNotes edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:DoctorNotes delete', ['only' => ['destroy']]);
    }

    /**
     * INDEX
     */
    public function index()
    {
        $doctor_notes = DB::table('doctor_notes')
            ->join('patients', 'patients.id', '=', 'doctor_notes.fk_patient_id')

            // 🔥 IMPORTANT FIX (LEFT JOIN)
            ->leftJoin('tokens', 'tokens.id', '=', 'doctor_notes.fk_token_id')

            ->select(
                'doctor_notes.*',
                'patients.name as patient_name',
                'tokens.created_at as token_date'
            )
            ->orderByDesc('doctor_notes.id')
            ->get();

        return view('doctor_notes.index', compact('doctor_notes'));
    }

    /**
     * CREATE (SEARCH)
     */
    public function create(Request $request)

    {
        $search = trim($request->get('search'));
        $searchType = strtolower(trim($request->get('search_type', 'mr')));

        $patient = null;
        $token = null;
        $tokenAlreadySaved = false;

        if ($search !== '') {

            // =========================
            // MR SEARCH (PATIENT ONLY)
            // =========================
            if ($searchType === 'mr') {

                $patient = DB::table('patients')
                    ->where('id', (int) $search)
                    ->first();

                if ($patient) {

                    $token = DB::table('tokens')
                        ->where('fk_patients_id', $patient->id)
                        ->orderByDesc('id')
                        ->first();

                    // 🔥 NORMALIZE TOKEN (IMPORTANT FIX)
                    if ($patient && !$token) {
                        $token = (object)[
                            'id' => null,
                            'token_id' => null,
                            'mr_no' => $patient->id,
                            'name' => $patient->name,
                            'pAddress' => $patient->address,
                            'pAge' => $patient->dob,
                            'reffered_by' => $patient->reffered_by,
                            'created_at' => null
                        ];
                    }
                }
            }

            // =========================
            // TOKEN SEARCH
            // =========================
            if ($searchType === 'token') {

                $token = DB::table('tokens')
                    ->join('patients', 'tokens.fk_patients_id', '=', 'patients.id')
                    ->select(
                        'tokens.id as token_id',
                        'tokens.created_at',
                        'patients.id as mr_no',
                        'patients.name',
                        'patients.address as pAddress',
                        'patients.dob as pAge',
                        'patients.reffered_by'
                    )
                    ->where('tokens.id', (int) $search)
                    ->first();

                if ($token) {
                    $patient = DB::table('patients')
                        ->where('id', $token->mr_no)
                        ->first();

                    $tokenAlreadySaved = DB::table('doctor_notes')
                        ->where('fk_token_id', $token->token_id)
                        ->exists();
                }
            }
        }

        return view('doctor_notes.new', compact(
            'search',
            'searchType',
            'patient',
            'token',
            'tokenAlreadySaved'
        ));
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $request->validate([
            'fk_patient_id' => 'required',
            'mode' => 'required|in:upload,manual',
            'fk_token_id' => 'nullable'
        ]);

        $data = new DoctorNotes();

        $data->fk_patient_id = $request->fk_patient_id;

        // FIX: convert 0 → null
        $data->fk_token_id = ($request->fk_token_id == 0 || $request->fk_token_id == '')
            ? null
            : $request->fk_token_id;

        $data->mode = $request->mode;

        if ($request->mode === 'upload') {

            if ($request->hasFile('prescription')) {

                $file = $request->file('prescription');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $file->move(public_path('assets/doctor_notes'), $fileName);

                $data->prescription = $fileName;
            }

            $data->complaints = null;
            $data->history = null;
            $data->investigations = null;
            $data->prescription_text = null;
            $data->remarks = null;

        } else {

            $data->complaints = $request->complaints;
            $data->history = $request->history;
            $data->investigations = $request->investigations;
            $data->prescription_text = $request->prescription_text;
            $data->remarks = $request->remarks;

            $data->prescription = null;
        }

        $data->save();

        return redirect()->route('admin.doctor_notes.index')
            ->with('success', 'Doctor Notes saved successfully!');
    }

    /**
     * SHOW
     */
    public function show($id)
    {
        //
    }

    /**
     * EDIT
     */
    public function edit($id)
    {
        $doctor_notes = DoctorNotes::findOrFail($id);

        return view('doctor_notes.edit', compact('doctor_notes'));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, $id)
    {
        $note = DoctorNotes::findOrFail($id);

        $note->mode = $request->mode;

        if ($request->mode === 'upload') {

            if ($request->hasFile('prescription')) {
                $file = $request->file('prescription');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/doctor_notes'), $fileName);

                $note->prescription = $fileName;
            }

            $note->complaints = null;
            $note->history = null;
            $note->investigations = null;
            $note->prescription_text = null;
            $note->remarks = null;

        } else {

            $note->complaints = $request->complaints;
            $note->history = $request->history;
            $note->investigations = $request->investigations;
            $note->prescription_text = $request->prescription_text;
            $note->remarks = $request->remarks;

            $note->prescription = null;
        }

        $note->save();

        return redirect('/admin/doctor_notes')
            ->with('success', 'Doctor Notes updated successfully!');
    }

    /**
     * DELETE
     */
    public function destroy($id)
    {
        $note = DoctorNotes::findOrFail($id);
        $note->delete();

        return redirect('/admin/doctor_notes')
            ->with('success', 'Doctor Notes deleted!');
    }

    /**
     * PRINT
     */
    public function print($id)
    {
        $doctor_notes = DoctorNotes::findOrFail($id);

        $token = DB::table('tokens')
            ->join('patients', 'patients.id', '=', 'tokens.fk_patients_id')
            ->select(
                'tokens.*',
                'patients.name as pName',
                'patients.fname as fName'
            )
            ->where('tokens.id', $doctor_notes->fk_token_id)
            ->first();

        $hospital = DB::table('hospitals')->first();

        return view('doctor_notes.print', compact('doctor_notes', 'hospital', 'token'));
    }
}