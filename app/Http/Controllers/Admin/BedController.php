<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bed;
use App\Models\Ward;
use App\Models\Admission;
use Illuminate\Http\Request;

class BedController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Bed access|Bed create|Bed edit|Bed delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Bed create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Bed edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Bed delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beds = Bed::with('ward')->latest()->paginate(20);
        return view('beds.index', compact('beds'));
    }

    public function create()
    {
        $wards = Ward::all();
        return view('beds.create', compact('wards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ward_id' => 'required|exists:wards,id',
            'bed_number' => 'required|string|max:50',
            'rate_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied',
        ]);

        Bed::create($request->all());

        return redirect()->route('admin.beds.index')->with('success','Bed added successfully.');
    }

    public function show(Bed $bed)
    {
        return view('beds.show', compact('bed'));
    }

    public function edit(Bed $bed)
    {
        $wards = Ward::all();
        return view('beds.edit', compact('bed','wards'));
    }

    public function update(Request $request, Bed $bed)
    {
        $request->validate([
            'ward_id' => 'required|exists:wards,id',
            'bed_number' => 'required|string|max:50',
            'rate_per_day' => 'required|numeric|min:0',
        ]);

        $bed->update($request->all());
        return redirect()->route('admin.beds.index')->with('success','Bed updated successfully.');
    }

    public function destroy(Bed $bed)
    {
        $bed->delete();
        return redirect()->route('admin.beds.index')->with('success','Bed deleted.');
    }

    // Custom: Bed shifting
    public function shift(Request $request, Admission $admission)
    {
        $request->validate([
            'new_bed_id' => 'required|exists:beds,id',
        ]);

        // free old bed
        Bed::where('id',$admission->bed_id)->update(['status'=>'available']);

        // assign new bed
        $admission->update(['bed_id'=>$request->new_bed_id]);
        Bed::where('id',$request->new_bed_id)->update(['status'=>'occupied']);

        return back()->with('success','Bed shifted successfully.');
    }
}
