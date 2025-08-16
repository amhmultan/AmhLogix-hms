<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductController extends Controller
{
    
    function __construct()
    {
        $this->middleware('role_or_permission:Product access|Product create|Product edit|Product delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Product create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Product edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Product delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = DB::table('products')
            ->join('manufacturers', 'manufacturers.id', '=', 'products.fk_manufacturer_id')
            ->select('products.*', 'manufacturers.name as manufacturersName')
            ->when($request->search, function($query) use ($request) {
                $query->where('products.name', 'like', '%' . $request->search . '%')
                    ->orWhere('products.generic', 'like', '%' . $request->search . '%')
                    ->orWhere('manufacturers.name', 'like', '%' . $request->search . '%');
            })
            ->paginate(50); // ✅ Load only 50 per page

        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $manufacturers = DB::table('manufacturers')
            ->select('manufacturers.id', 'manufacturers.name as mName')
            ->get();
            
        return view('product.new', compact('manufacturers'));

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
        
        $Product = Product::create($data);
        return redirect('/admin/products')->withSuccess('Product created !!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $products, $id)
    {
        
        $data = [];

        $products = DB::table('products')
                        ->join('manufacturers', 'manufacturers.id','products.fk_manufacturer_id')
                        ->select('products.*', 'manufacturers.name as mName')
                        ->where('products.id', '=', $id)
                        ->get();        
        
        $manufacturers = DB::table('manufacturers')
                        ->select('manufacturers.id','manufacturers.name as mName')
                        ->get();

        $data = [
            "manufacturers" => $manufacturers,
            "products" => $products,
        ];

        return view('product.edit',['data' => $data]);
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
        $products = Product::find($id);
        $products->update($request->all());
        
        return redirect('/admin/products')->withSuccess('Product updated !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = Product::find($id);
        $products->delete();
        return redirect('/admin/products')->withSuccess('Product deleted !!!');
    }

    public function getProducts(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::query()
                ->leftJoin('manufacturers', 'products.fk_manufacturer_id', '=', 'manufacturers.id')
                ->select(
                    'products.id',
                    'manufacturers.name as manufacturer_name',
                    'products.name',
                    'products.generic',
                    'products.drug_class',
                    'products.pack_size',
                    'products.status',
                    'products.created_at',
                    'products.updated_at'
                );

            return datatables()->of($products)
                ->addColumn('manufacturersName', function ($row) {
                    return $row->manufacturer_name ?: '-';
                })
                ->addColumn('status', function ($row) {
                    return $row->status == 1
                        ? '<span class="text-success">Active</span>'
                        : '<span class="text-danger">Inactive</span>';
                })
                ->addColumn('created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->created_at)->format('d M Y');
                })
                ->addColumn('updated_at', function ($row) {
                    return \Carbon\Carbon::parse($row->updated_at)->format('d M Y');
                })
                ->addColumn('actions', function ($row) {
                    $edit = '<a href="' . route('admin.products.edit', $row->id) . '" class="btn btn-sm btn-outline-primary me-1">Edit</a>';
                    $delete = '<form action="' . route('admin.products.destroy', $row->id) . '" method="POST" class="d-inline">'
                        . csrf_field()
                        . method_field('delete')
                        . '<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>';
                    return $edit . $delete;
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }

        return view('product.index');
    }
    
}
