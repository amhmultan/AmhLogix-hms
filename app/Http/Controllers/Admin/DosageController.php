<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Dosage;

use Illuminate\Http\Request;

class DosageController extends Controller
{

    public function __construct()
    {
        $this->middleware('role_or_permission:Dosage access|Dosage create|Dosage edit|Dosage delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Dosage create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Dosage edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Dosage delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dosages.index', ['dosages' => Dosage::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dosages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'status'  => 'required|in:0,1',
            'description' => 'nullable|string|max:255',
        ]);

        Dosage::create($validated);

        return redirect('/admin/dosages')
                ->withSuccess('Dosage created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dosage  $dosage
     * @return \Illuminate\Http\Response
     */
    public function show(Dosage $dosage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dosage  $dosage
     * @return \Illuminate\Http\Response
     */
    public function edit(Dosage $dosage)
    {
        return view('dosages.edit', compact('dosage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dosage  $dosage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dosage $dosage)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255|unique:dosages,name,' . $dosage->id,
            'status'  => 'required|in:0,1',
            'description' => 'nullable|string|max:255',
        ]);        

        $dosage->update($validated);

        return redirect('/admin/dosages')
            ->withSuccess('Dosage updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dosage  $dosage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dosage $dosage)
    {
        $dosage->delete();

        return redirect('/admin/dosages')
            ->withSuccess('Dosage deleted successfully!');
    }
}
