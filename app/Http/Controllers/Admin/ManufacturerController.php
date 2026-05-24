<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manufacturer;
use Illuminate\Support\Facades\Auth;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:Manufacturer access|Manufacturer add|Manufacturer edit|Manufacturer delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Manufacturer add', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Manufacturer edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Manufacturer delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of these resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manufacturers = Manufacturer::all();

        return view('manufacturer.index', ['manufacturers' => $manufacturers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manufacturer.new');
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

        if ($image = $request->file('logo')) {
            $destinationPath = 'img/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $data['logo'] = "$profileImage";
        }

        $manufacturer = Manufacturer::create($data,);
        return redirect('/admin/manufacturers')->withSuccess('Manufacturer created !!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Manufacturer  $manufacturer
     * @return \Illuminate\Http\Response
     */
    public function show(Manufacturer $manufacturer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Manufacturer  $manufacturer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manufacturer = Manufacturer::find($id);
        return view('manufacturer.edit',['manufacturer' => $manufacturer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Manufacturer  $manufacturer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $manufacturer = Manufacturer::find($id);

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'fbr_no' => 'required',
            'contact' => 'required',
            'email' => 'required|email',
            'website' => 'required',
            'address' => 'required',
            'remarks' => 'required',
            
        ]);

        $file = $request->file('logo');
        $filename = date('YmdHis') . "." . $file->getClientOriginalName();
        $path = 'img/';
        $file->move($path, $filename);

        $update = [
            'name' => $request->name, 'description' => $request->description,
            'fbr_no' => $request->fbr_no, 'contact' => $request->contact,
            'email' => $request->email, 'website' => $request->website,
            'addressaddress' => $request->address, 'logo' => $filename,
            'remarks' => $request->remarks
        ];


        $manufacturer->update($update);
        
        return redirect('/admin/manufacturers')->withSuccess('Manufacturer updated !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Manufacturer  $manufacturer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->delete();
        return redirect('/admin/manufacturers')->withSuccess('Manufacturer deleted !!!');
    }
}
