<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Hospital;
use App\Models\DoctorNotes;
use App\Models\Doctor;
use App\Models\DoctorNoteItem;
use App\Models\Product;
use App\Models\Token;
use App\Models\Patient;
use App\Models\Dosage;


class DoctorNotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:DoctorNotes access|DoctorNotes add|DoctorNotes edit|DoctorNotes delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:DoctorNotes add', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:DoctorNotes edit', ['only' => ['edit', 'update']]);
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

            if ($searchType === 'mr') {

                $patient = Patient::find((int) $search);

                if ($patient) {
                    $token = Token::where('fk_patients_id', $patient->id)
                        ->latest()
                        ->first();
                }
            }

            if ($searchType === 'token') {

                $token = Token::with('patient')
                    ->where('id', (int) $search)
                    ->first();

                if ($token) {
                    $patient = $token->patient;

                    $tokenAlreadySaved = DoctorNotes::where('fk_token_id', $token->id)->exists();
                }
            }
        }

        $dosages = Dosage::where('status', 0)->get();

        return view('doctor_notes.new', compact(
            'search',
            'searchType',
            'patient',
            'token',
            'tokenAlreadySaved',
            'dosages'
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
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

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
            $data->right_sph = null;
            $data->right_cyl = null;
            $data->right_axis = null;
            $data->right_va = null;
            $data->left_sph = null;
            $data->left_cyl = null;
            $data->left_axis = null;
            $data->left_va = null;
            $data->right_add = null;
            $data->right_pd = null;
            $data->left_add = null;
            $data->left_pd = null;
            $data->right_remarks = null;
            $data->left_remarks = null;
        }

        /* =======================
        MANUAL MODE (OPD)
        ======================= */ else {

            // =========================
            // OPD FIELDS
            // =========================
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

            // =========================
            // 🔥 STRUCTURED PRODUCTS (FIXED)
            // =========================
            $products = [];

            if ($request->product_id) {

                foreach ($request->product_id as $key => $productId) {

                    if (!$productId) continue;

                    $products[] = [
                        'product_id' => $productId,
                        'dosage_id'  => $request->dosage_id[$key] ?? null,
                        'duration'   => $request->duration[$key] ?? null,
                        'remarks'    => $request->remarks[$key] ?? null,
                    ];
                }
            }

            // =========================
            // OTHERS
            // =========================
            $data->right_sph = $request->right_sph;
            $data->right_cyl = $request->right_cyl;
            $data->right_axis = $request->right_axis;
            $data->right_va = $request->right_va;

            $data->left_sph = $request->left_sph;
            $data->left_cyl = $request->left_cyl;
            $data->left_axis = $request->left_axis;
            $data->left_va = $request->left_va;

            $data->right_add = $request->right_add;
            $data->right_pd = $request->right_pd;
            $data->left_add = $request->left_add;
            $data->left_pd = $request->left_pd;

            $data->right_remarks = $request->right_remarks;
            $data->left_remarks = $request->left_remarks;

            $data->prescription = null;
        }

        $data->save();

        // Save items
        if (!empty($products)) {
            foreach ($products as $item) {

                DoctorNoteItem::create([
                    'doctor_note_id' => $data->id,
                    'product_id'     => $item['product_id'],
                    'dosage_id'      => $item['dosage_id'],
                    'duration'       => $item['duration'],
                    'remarks'        => $item['remarks'],
                ]);
            }
        }

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
        $doctorNote = DoctorNotes::with([
            'items.product',
            'items.dosage'
        ])->findOrFail($id);

        $products = Product::all();

        $dosages = Dosage::where('status', 0)->get();

        return view('doctor_notes.edit', compact(
            'doctorNote',
            'products',
            'dosages'
        ));
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
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $file->move(public_path('assets/doctor_notes'), $fileName);

                $note->prescription = $fileName;
            }

            // clear manual fields
            $note->fill([
                'c_o' => null,
                'o_e' => null,
                'va' => null,
                'at' => null,
                'lids' => null,
                'conjunctiva' => null,
                'cornea' => null,
                'ac' => null,
                'lens' => null,
                'fundus' => null,
                'prescription_text' => null,
                'dm' => null,
                'htn' => null,
                'ihd' => null,
                'asthma' => null,
                'right_sph' => null,
                'right_cyl' => null,
                'right_axis' => null,
                'right_va' => null,
                'left_sph' => null,
                'left_cyl' => null,
                'left_axis' => null,
                'left_va' => null,
                'right_add' => null,
                'right_pd' => null,
                'left_add' => null,
                'left_pd' => null,
                'right_remarks' => null,
                'left_remarks' => null,
                'prescription' => null,
            ]);

            // ❌ IMPORTANT: delete old items if switching mode
            $note->items()->delete();
        }

        /* =========================
    MANUAL OPD MODE
    ========================= */ else {

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

            $note->dm = $request->dm;
            $note->htn = $request->htn;
            $note->ihd = $request->ihd;
            $note->asthma = $request->asthma;

            // =========================
            // 🔥 ITEMS (RELATIONAL SAVE)
            // =========================

            $note->items()->delete(); // clear old items

            if ($request->product_id) {

                foreach ($request->product_id as $key => $productId) {

                    if (!$productId) continue;

                    $note->items()->create([
                        'product_id' => $productId,
                        'dosage_id'  => $request->dosage_id[$key] ?? null,
                        'duration'   => $request->duration[$key] ?? null,
                        'remarks'    => $request->remarks[$key] ?? null,
                    ]);
                }
            }

            // others
            $note->right_sph = $request->right_sph;
            $note->right_cyl = $request->right_cyl;
            $note->right_axis = $request->right_axis;
            $note->right_va = $request->right_va;

            $note->left_sph = $request->left_sph;
            $note->left_cyl = $request->left_cyl;
            $note->left_axis = $request->left_axis;
            $note->left_va = $request->left_va;

            $note->right_add = $request->right_add;
            $note->right_pd = $request->right_pd;
            $note->left_add = $request->left_add;
            $note->left_pd = $request->left_pd;

            $note->right_remarks = $request->right_remarks;
            $note->left_remarks = $request->left_remarks;

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
        $note = DoctorNotes::with([
            'patient',
            'token.doctor',
            'items.product'
        ])->findOrFail($id);

        $patient = $note->patient;

        $doctor = $note->token?->doctor ?? Doctor::first();

        $hospital = Hospital::first();

        $note->prescription_text = ltrim($note->prescription_text);

        // DIRECT ITEMS FROM RELATION (NO JSON)
        $items = $note->items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'name'       => $item->product?->name,
                'dosage'     => $item->dosage_id,
                'duration'   => $item->duration,
                'remarks'    => $item->remarks,
            ];
        });

        return view('doctor_notes.print', compact(
            'note',
            'patient',
            'doctor',
            'hospital',
            'items'
        ));
    }
}
