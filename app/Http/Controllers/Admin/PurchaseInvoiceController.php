<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:Purchase access|Purchase create|Purchase edit|Purchase delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Purchase create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Purchase edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Purchase delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $invoices = PurchaseInvoice::with('supplier')->latest()->get();
        return view('purchase.index', compact('invoices'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();

        // Auto-generate invoice number
        $latestInvoice = PurchaseInvoice::latest()->first();
        $nextId = $latestInvoice ? $latestInvoice->id + 1 : 1;
        $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        return view('purchase.new', compact('suppliers', 'products', 'invoiceNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|unique:purchase_invoices,invoice_number',
            'supplier_id'    => 'required|exists:suppliers,id',
            'purchase_date'  => 'required|date',
            'discount'       => 'nullable|numeric|min:0',
            'tax_percent'    => 'nullable|numeric|min:0',
            'items'          => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            // Calculate totals
            $total_amount = 0;
            foreach ($request->items as $item) {
                $total_amount += $item['quantity'] * $item['unit_price'];
            }

            $discount = $request->discount ?? 0;
            $tax_percent = $request->tax_percent ?? 0;
            $tax_amount = (($total_amount - $discount) * $tax_percent) / 100;
            $net_amount = ($total_amount - $discount) + $tax_amount;

            // Create invoice
            $invoice = PurchaseInvoice::create([
                'invoice_number' => $request->invoice_number,
                'supplier_id'    => $request->supplier_id,
                'purchase_date'  => $request->purchase_date,
                'total_amount'   => $total_amount,
                'discount'       => $discount,
                'tax_percent'    => $tax_percent,   // ✅ new column
                'tax_amount'     => $tax_amount,
                'net_amount'     => $net_amount,
                'notes'          => $request->notes,
                'status'         => 'pending',
                'payment_status' => 'unpaid',
            ]);

            // Insert items
            foreach ($request->items as $item) {
                PurchaseInvoiceItem::create([
                    'purchase_invoice_id' => $invoice->id,
                    'product_id'          => $item['product_id'],
                    'quantity'            => $item['quantity'],
                    'unit_price'          => $item['unit_price'],
                    'total_price'         => $item['quantity'] * $item['unit_price'],
                    'batch_no'            => $item['batch_no'] ?? null,
                    'expiry_date'         => $item['expiry_date'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('admin.purchases.index')
            ->with('success', 'Purchase invoice created successfully.');
    }

    public function show($id)
    {
        $purchase_invoice = PurchaseInvoice::with(['supplier', 'items.product'])->findOrFail($id);
        return view('purchase.show', compact('purchase_invoice'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, PurchaseInvoice $purchase_invoice)
    {
        //
    }

    public function print($id)
    {
        $purchase_invoice = PurchaseInvoice::with(['supplier', 'items.product'])->findOrFail($id);
        $pharmacy = Pharmacy::first();
        
        if (!$pharmacy) {
            return redirect()->back()->withErrors('Pharmacy information not found.');
        }

        return view('purchase.print', compact('purchase_invoice', 'pharmacy'));
    }

    public function destroy($id)
    {
        $purchase_invoice = PurchaseInvoice::findOrFail($id);
        $purchase_invoice->delete();
        return redirect()->route('admin.purchases.index')->with('success', 'Invoice deleted successfully!');
    }
        /**
     * Return products for Select2 AJAX search
     */
    public function getProductsAjax(Request $request)
    {
        
        $term = $request->get('q', '');

        $products = Product::query()
            ->when($term, fn($q) => $q->where('name', 'like', "%{$term}%"))
            ->select('id', DB::raw('name as text'))
            ->limit(20)
            ->get();

        if ($products->isEmpty()) {
            return response()->json([
                'results' => [
                    ['id' => 0, 'text' => 'No products found']
                ]
            ]);
        }

        return response()->json(['results' => $products]);
    }

}
