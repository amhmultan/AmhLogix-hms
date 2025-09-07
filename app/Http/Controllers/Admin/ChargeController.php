<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Charge;
use App\Models\Admission;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ChargeController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:IPD_Billing access|IPD_Billing create|IPD_Billing edit|IPD_Billing delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:IPD_Billing create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:IPD_Billing edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:IPD_Billing delete', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $charges = Charge::with('admission.patient')->latest()->get();
        return view('charges.index', compact('charges'));
    }

    public function create()
    {
        $admissions = Admission::with('patient')->where('status','admitted')->get();
        return view('charges.create', compact('admissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'amount' => 'required|numeric|min:0',
        ]);

        Charge::create($request->all());
        return redirect()->route('admin.charges.index')->with('success','Charge added successfully.');
    }

    public function edit(Charge $charge)
    {
        $admissions = Admission::with('patient')->where('status','admitted')->get();
        return view('charges.edit', compact('charge','admissions'));
    }

    public function update(Request $request, Charge $charge)
    {
        $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'amount' => 'required|numeric|min:0',
        ]);

        $charge->update($request->all());
        return redirect()->route('admin.charges.index')->with('success','Charge updated successfully.');
    }

    public function destroy(Charge $charge)
    {
        $charge->delete();
        return redirect()->route('admin.charges.index')->with('success','Charge deleted successfully.');
    }

    // Generate Bill
    public function bill($admissionId)
    {
        $admission = Admission::with('bed','charges','patient')->findOrFail($admissionId);

        $days = $admission->discharge_date
            ? Carbon::parse($admission->admission_date)->diffInDays($admission->discharge_date) + 1
            : Carbon::parse($admission->admission_date)->diffInDays(now()) + 1;

        $roomCharges  = $days * $admission->bed->rate_per_day;
        $extraCharges = $admission->charges->sum('amount');
        $total        = $roomCharges + $extraCharges;

        return view('charges.bill', compact('admission','days','roomCharges','extraCharges','total'));
    }
}
