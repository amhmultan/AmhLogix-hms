<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\Doctor;
use Carbon\Carbon;

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
        return view('patient.index');
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
        $request->validate([
            'name' => 'required',
            'age' => 'required|integer|min:0|max:120',
        ]);

        $data = $request->all();

        $data['fk_user_id'] = Auth::id();

        // Convert age to DOB
        $data['dob'] = Carbon::now()->subYears($request->age)->format('Y-m-d');

        Patient::create($data);

        return redirect('/admin/patients')->withSuccess('Patient register successfully !!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        $patient->load('users'); // 👈 important
        
        $title = DB::table('hospitals')
                    ->select('hospitals.title', 'hospitals.logo', 'hospitals.address', 'hospitals.website', 'hospitals.contact', 'hospitals.phc_no')
                    ->first();
        
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'age' => 'required|integer|min:0|max:120',
            'phone' => 'required',
        ]);

        $patient = Patient::findOrFail($id);

        // Convert age → DOB
        $dob = Carbon::now()->subYears($request->age)->format('Y-m-d');

        $patient->update([
            'name'            => $request->name,
            'fname'           => $request->fname,
            'dob'             => $dob,
            'gender'          => $request->gender,
            'marital_status'  => $request->marital_status,
            'phone'           => $request->phone,
            'email'           => $request->email,
            'cnic'            => $request->cnic,
            'address'         => $request->address,
            'emr_name'        => $request->emr_name,
            'relationship'    => $request->relationship,
            'emr_phone'       => $request->emr_phone,
            'reffered_by'     => $request->reffered_by,
            'history'         => $request->history,
            'fk_user_id'      => Auth::id(),
        ]);

        return redirect('/admin/patients')->withSuccess('Patient updated successfully !!!');
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
        return redirect('/admin/patients')->withSuccess('Patient deleted successfully !!!');
    }

    public function getData(Request $request)
    {
        $search = $request->smart_search;

        $query = DB::table('patients')
            ->join('users', 'users.id', '=', 'patients.fk_user_id')

            // ONLY REQUIRED FIELDS (VERY IMPORTANT)
            ->selectRaw("
                patients.id,
                patients.name,
                patients.fname,
                patients.dob,
                patients.marital_status,
                patients.gender,
                patients.phone,
                patients.email,
                patients.cnic,
                patients.address,
                patients.created_at,
                patients.updated_at,
                users.name as usersName
            ");

        /*
        ----------------------------------------------------
        🚀 ULTRA FAST SEARCH STRATEGY
        ----------------------------------------------------
        1. Exact match first (uses INDEX)
        2. Prefix search only (NO %search%)
        3. Avoid full table scan
        */

        if (!empty($search)) {

            $query->where(function ($q) use ($search) {

                // FAST INDEXED MATCHES
                $q->where('patients.id', $search)
                ->orWhere('patients.phone', $search)
                ->orWhere('patients.cnic', $search)

                // PREFIX SEARCH ONLY (FAST LIKE)
                ->orWhere('patients.name', 'like', $search . '%');
            });
        }

        return datatables()
            ->of($query)

            // AGE (FAST + SAFE)
            ->editColumn('age', function ($row) {
                if (!$row->dob) return '';

                $dob = strtotime($row->dob);
                if (!$dob) return '';

                return date_diff(
                    date_create($row->dob),
                    date_create('today')
                )->y . ' years';
            })

            // FORMAT DATES (FAST PHP, avoids SQL dependency issues)
            ->addColumn('registered_on', function ($row) {
                return $row->created_at
                    ? date('d-m-Y h:i A', strtotime($row->created_at))
                    : '';
            })

            ->addColumn('updated_on', function ($row) {
                return $row->updated_at
                    ? date('d-m-Y h:i A', strtotime($row->updated_at))
                    : '';
            })

            ->addColumn('action', function ($patient) {
                return view('patient.partials.actions', compact('patient'))->render();
            })

            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function print($id)
    {
        $patient = Patient::findOrFail($id);

        $hospitals = Hospital::first();

        $doctors = Doctor::first();

        return view('patient.print', compact('patient', 'hospitals', 'doctors'));
    }
    
}