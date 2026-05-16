<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Hospital;
use App\Models\DoctorNotes;
use App\Models\Doctor;
use App\Models\Product;

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
        $doctor_notes = DoctorNotes::with('patient', 'token')
            ->select('doctor_notes.*')
            ->orderByDesc('id')
            ->get();

        return view('doctor_notes.index', compact('doctor_notes'));
    }

    /**
     * CREATE
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

        $data->fk_token_id = ($request->fk_token_id == 0 || $request->fk_token_id == '')
            ? null
            : $request->fk_token_id;

        $data->mode = $request->mode;

        /* =======================
        UPLOAD MODE (UNCHANGED)
        ======================= */
        if ($request->mode === 'upload') {

            if ($request->hasFile('prescription')) {

                $file = $request->file('prescription');
                $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('assets/doctor_notes'), $fileName);

                $data->prescription = $fileName;
            }

            // NEW OPD FIELDS
            $data->c_o = null;
            $data->o_e = null;
            $data->va = null;
            $data->at = null;
            $data->lids = null;
            $data->conjunctiva = null;
            $data->cornea = null;
            $data->ac = null;
            $data->lens = null;
            $data->fundus = null;
            $data->dm = null;
            $data->htn = null;
            $data->ihd = null;
            $data->asthma = null;
            $data->prescription_products = null;
        }

        /* =======================
        MANUAL MODE (OPD)
        ======================= */
        else {

            // NEW OPD FIELDS
            $data->c_o = $request->c_o;
            $data->o_e = $request->o_e;
            $data->va = $request->va;
            $data->at = $request->at;
            $data->lids = $request->lids;
            $data->conjunctiva = $request->conjunctiva;
            $data->cornea = $request->cornea;
            $data->ac = $request->ac;
            $data->lens = $request->lens;
            $data->fundus = $request->fundus;
            $data->prescription_text = $request->prescription_text;
            $data->dm = $request->dm;
            $data->htn = $request->htn;
            $data->ihd = $request->ihd;
            $data->asthma = $request->asthma;
            $data->prescription_products = $request->prescription_products;

            $data->prescription = null;
        }

        $data->save();

        return redirect()
            ->route('admin.doctor_notes.index')
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

        /* =========================
        UPLOAD MODE
        ========================= */
        if ($request->mode === 'upload') {

            if ($request->hasFile('prescription')) {

                $file = $request->file('prescription');
                $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('assets/doctor_notes'), $fileName);

                $note->prescription = $fileName;
            }

            // clear all manual fields
            $note->c_o = null;
            $note->o_e = null;
            $note->va = null;
            $note->at = null;
            $note->lids = null;
            $note->conjunctiva = null;
            $note->cornea = null;
            $note->ac = null;
            $note->lens = null;
            $note->fundus = null;
            $note->prescription_text = null;
            $note->prescription_products = null;
            $note->dm = null;
            $note->htn = null;
            $note->ihd = null;
            $note->asthma = null;
        }

        /* =========================
        MANUAL OPD MODE
        ========================= */
        else {

            $note->c_o = $request->c_o;
            $note->o_e = $request->o_e;
            $note->va = $request->va;
            $note->at = $request->at;
            $note->lids = $request->lids;
            $note->conjunctiva = $request->conjunctiva;
            $note->cornea = $request->cornea;
            $note->ac = $request->ac;
            $note->lens = $request->lens;
            $note->fundus = $request->fundus;
            $note->prescription_text = $request->prescription_text;
            $note->prescription_products = $request->prescription_products ?? [];
            $note->dm = $request->dm;
            $note->htn = $request->htn;
            $note->ihd = $request->ihd;
            $note->asthma = $request->asthma;

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
        $note = DoctorNotes::with(['patient', 'token.doctor'])
                ->findOrFail($id);

        $patient = $note->patient;

        // Try token doctor first
        $doctor = $note->token?->doctor;

        // If token doctor not available, fallback
        if (!$doctor) {
            $doctor = Doctor::first();
        }

        $hospital = Hospital::first();

        $note->prescription_text = ltrim($note->prescription_text);

        // =========================
        // FETCH PRESCRIPTION PRODUCTS
        // =========================
        $productIds = $note->prescription_products ?? [];

        $products = Product::whereIn('id', $productIds)
            ->select('id', 'name', 'description')
            ->get();

        return view('doctor_notes.print', compact(
            'note',
            'patient',
            'doctor',
            'hospital',
            'products'
        ));
    }
}