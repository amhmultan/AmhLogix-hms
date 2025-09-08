<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Ward access|Ward create|Ward edit|Ward delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Ward create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Ward edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Ward delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $wards = Ward::latest()->paginate(20);
        return view('wards.index', compact('wards'));
    }

    public function create()
    {
        return view('wards.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:general,private,icu',
        ]);

        Ward::create($request->all());
        return redirect()->route('admin.wards.index')->with('success', 'Ward created successfully.');
    }

    public function show(Ward $ward)
    {
        return view('wards.show', compact('ward'));
    }

    public function edit(Ward $ward)
    {
        return view('wards.edit', compact('ward'));
    }

    public function update(Request $request, Ward $ward)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:general,private,icu',
        ]);

        $ward->update($request->all());
        return redirect()->route('admin.wards.index')->with('success', 'Ward created successfully.');
    }

    public function destroy(Ward $ward)
    {
        $ward->delete();
        return redirect()->route('admin.wards.index')->with('success', 'Ward created successfully.');
    }
}
