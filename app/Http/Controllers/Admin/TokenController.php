<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Token;
use App\Models\Doctor;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:Token access|Token add|Token edit|Token delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Token access', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Token edit', ['only' => ['edit','update']]);
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
                    ->leftJoin('patients','tokens.fk_patients_id','=','patients.id')
                    ->leftJoin('doctors','tokens.fk_doctors_id','=','doctors.id')
                    ->leftJoin('specialities','tokens.fk_specialty_id','=','specialities.id')
                    ->select('tokens.id', 'tokens.fk_patients_id', 'patients.name as pName', 'tokens.fk_doctors_id','doctors.name as dName', 'tokens.fk_specialty_id', 'specialities.title as sTitle', 'tokens.fees', 'tokens.denomination', 'tokens.balance', 'tokens.created_at', 'tokens.updated_at')
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

        $data= $request->all();
        $data['user_id'] = Auth::user()->id;
        $token = Token::create($data);
        
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
        // Get hospital info (only first row)
        $hospital = DB::table('hospitals')->first();

        // Get full token info including doctor, patient, and specialty
        $tokenInfo = DB::table('tokens')
                    ->join('patients', 'tokens.fk_patients_id', '=', 'patients.id')
                    ->join('doctors', 'tokens.fk_doctors_id', '=', 'doctors.id')
                    ->join('specialities', 'tokens.fk_specialty_id', '=', 'specialities.id')
                    ->select(
                        'tokens.*',
                        'patients.name as pName',
                        'patients.fname as fName',
                        'doctors.name as dName',
                        'specialities.title as sTitle',
                        'doctors.pmdc',
                        'doctors.remarks',
                        'patients.phone as pPhone',
                        'patients.address as pAddress',
                        'patients.dob as pAge'
                    )
                    ->where('tokens.id', $token->id)
                    ->first();

        return view('token.show', [
            'token' => $tokenInfo,
            'hospital' => $hospital,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Token $token)
    {
        
        $data = [];
        
        $id = $token->id;
        
        $token = DB::table('tokens')
                        ->join('patients','tokens.fk_patients_id','=','patients.id')
                        ->join('doctors','tokens.fk_doctors_id','=','doctors.id')
                        ->join('specialities','tokens.fk_specialty_id','=','specialities.id')
                        ->select('tokens.*','patients.name as pName','patients.phone','doctors.name as dName','specialities.title as sTitle')
                        ->where('tokens.id', '=', $id)
                        ->get();
        
        $doctors = DB::table('doctors')
                    ->select('doctors.id','doctors.name')
                    ->get();

        $specialities = DB::table('specialities')
                    ->select('specialities.id','specialities.title')
                    ->get();

        $data = [
            "tokens" => $token,
            "doctors" => $doctors,
            "specialities" => $specialities,
        ];
        
        return view('token.edit',['data' => $data]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $token = Token::find($id);
        $token->update($request->all());
        return redirect('/admin/tokens')->withSuccess('Patient token updated !!!');

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