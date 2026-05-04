<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Patient;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:Patient access|Patient create|Patient edit|Patient delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Patient create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Patient edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Patient delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $patients = DB::table('patients')
                        ->join('users', 'users.id','fk_user_id')
                        ->select('patients.*', 'users.name as usersName')
                        ->get();

        return view('patient.index', ['patients' => $patients]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patient.new');
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
        $data['fk_user_id'] = Auth::user()->id;
        $Patient = Patient::create($data);

        return redirect('/admin/patients')->withSuccess('Patient created !!!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        $title = DB::table('hospitals')
                    ->select('hospitals.title', 'hospitals.logo', 'hospitals.address', 'hospitals.website', 'hospitals.contact', 'hospitals.phc_no')
                    ->get();
        
        $doctor = DB::table('doctors')
                    ->select('doctors.*')
                    ->first();
    
        return view('patient.show',['patient' => $patient, 'hospitals' => $title, 'doctors' => $doctor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
       return view('patient.edit',['patient' => $patient]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        $patient->update($request->all());
        return redirect('/admin/patients')->withSuccess('Patient updated !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect('/admin/patients')->withSuccess('Patient deleted !!!');
    }

}
