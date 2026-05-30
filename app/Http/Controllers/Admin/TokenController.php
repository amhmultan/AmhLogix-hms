<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Token;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Speciality;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:Token access|Token add|Token edit|Token delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Token access', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Token edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Token delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tokens = DB::table('tokens')
            ->leftJoin('patients', 'tokens.fk_patients_id', '=', 'patients.id')
            ->leftJoin('doctors', 'tokens.fk_doctors_id', '=', 'doctors.id')
            ->leftJoin('specialities', 'tokens.fk_specialty_id', '=', 'specialities.id')
            ->select('tokens.id', 'tokens.fk_patients_id', 'patients.name as pName', 'patients.reffered_by', 'tokens.fk_doctors_id', 'doctors.name as dName', 'tokens.fk_specialty_id', 'specialities.title as sTitle', 'tokens.fees', 'tokens.denomination', 'tokens.balance', 'tokens.created_at', 'tokens.updated_at')
            ->get();

        return view('token.index', ['tokens' => $tokens]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $search = $request->input('search', '');

        $patients = DB::table('patients')
            ->where('id', 'like', "%$search%")
            ->get();

        $doctors = Doctor::with('specialty')->get();

        $specialities = DB::table('specialities')->select('id', 'title')->get();

        $data = [
            "patients" => $patients,
            "doctors" => $doctors,
            "specialities" => $specialities,
        ];

        return view('token.new', compact('data', 'search'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $token = Token::create($data);
        //dd($token);
        return redirect('/admin/tokens')->withSuccess('Token created !!!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Token $token)
    {
        $hospital = DB::table('hospitals')->first();

        $patient = Patient::find($token->fk_patients_id);
        $doctor = Doctor::find($token->fk_doctors_id);

        // QR DATA (you can customize this later)
        $qrData = route('admin.tokens.show', $token->id);

        return view('token.thermal', compact(
            'hospital',
            'doctor',
            'patient',
            'token',
            'qrData'
        ));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Token $token)
    {
        // Fetch token with relations instead of raw joins
        $token = Token::with(['patient', 'doctor', 'speciality'])
            ->where('id', $token->id)
            ->firstOrFail();

        $doctors = Doctor::select('id', 'name')->get();
        $specialities = Speciality::select('id', 'title')->get();

        return view('token.edit', [
            'token' => $token,
            'doctors' => $doctors,
            'specialities' => $specialities,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Token $token)
    {
        // Validate input before updating
        $validated = $request->validate([
            'fk_doctors_id'   => 'required|exists:doctors,id',
            'fk_specialty_id' => 'required|exists:specialities,id',
        ]);

        $token->update([
            'fk_doctors_id' => $request->fk_doctors_id,
            'fk_specialty_id' => $request->fk_specialty_id,
            'fees' => $request->fees,
            'denomination' => $request->denomination,
            'balance' => $request->balance,
        ]);

        return redirect()->route('admin.tokens.index')->with('success', 'Patient token updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Token $token)
    {
        $token->delete();
        return redirect('/admin/tokens')->withSuccess('Patient token deleted !!!');
    }
}
