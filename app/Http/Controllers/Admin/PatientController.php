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
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'age' => 'required|integer|min:0|max:120',
        ]);

        $patient = Patient::findOrFail($id);

        // Convert age → DOB
        $dob = Carbon::now()->subYears($request->age)->format('Y-m-d');

        $patient->name = $request->name;
        $patient->dob = $dob;
        $patient->fk_user_id = Auth::id(); // optional: or keep created_by separate
        $patient->save();

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
        $query = DB::table('patients')
            ->join('users', 'users.id', '=', 'patients.fk_user_id')
            ->select('patients.*', 'users.name as usersName');

        // 🔥 SMART SEARCH LOGIC
        if (!empty($request->smart_search)) {

            $search = $request->smart_search;

            $query->where(function ($q) use ($search) {

                $q->where('patients.id', 'like', "%$search%")
                ->orWhere('patients.cnic', 'like', "%$search%")
                ->orWhere('patients.phone', 'like', "%$search%");

            });
        }

        return datatables()
            ->of($query)
            ->addColumn('age', function ($patient) {
                return $patient->dob
                    ? \Carbon\Carbon::parse($patient->dob)->diff(\Carbon\Carbon::now())->format('%y years')
                    : '';
            })
            ->addColumn('registered_on', fn($p) => \Carbon\Carbon::parse($p->created_at)->format('d-m-Y h:i A'))
            ->addColumn('updated_on', fn($p) => \Carbon\Carbon::parse($p->updated_at)->format('d-m-Y h:i A'))
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