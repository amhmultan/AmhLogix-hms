<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Http\Request;

class StockReportController extends Controller
{
    public function index(Request $request)
{
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');
    $filterType = $request->input('filter_type'); // 'purchase', 'sale', 'both'
    $excludeZeroPurchase = $request->boolean('exclude_zero_purchase', false);
    $excludeZeroStock = $request->boolean('exclude_zero_stock', false);

    $query = Product::select(
        'products.id', 'products.name',
        DB::raw('COALESCE(SUM(pii.quantity), 0) as total_purchased'),
        DB::raw('COALESCE(SUM(pii.quantity * pii.unit_price), 0) as total_purchase_value'),
        DB::raw('COALESCE(MAX(pii.created_at), NULL) as last_purchase'),
        DB::raw('COALESCE(SUM(sii.quantity), 0) as total_sold'),
        DB::raw('COALESCE(SUM(sii.quantity * sii.price), 0) as total_sale_value'),
        DB::raw('COALESCE(MAX(sii.created_at), NULL) as last_sale')
    )
    ->leftJoin('purchase_invoice_items as pii', 'pii.product_id', '=', 'products.id')
    ->leftJoin('sale_invoice_items as sii', 'sii.fk_product_id', '=', 'products.id');

    // Apply date filters for purchase and sale items
    if ($fromDate) {
        $query->where(function ($q) use ($fromDate) {
            $q->where('pii.created_at', '>=', $fromDate)
              ->orWhere('sii.created_at', '>=', $fromDate);
        });
    }

    if ($toDate) {
        $query->where(function ($q) use ($toDate) {
            $q->where('pii.created_at', '<=', $toDate)
              ->orWhere('sii.created_at', '<=', $toDate);
        });
    }

    // Filter by type
    if ($filterType === 'purchase') {
        $query->whereNotNull('pii.id');  // Only products with purchases
    } elseif ($filterType === 'sale') {
        $query->whereNotNull('sii.id');  // Only products with sales
    } elseif ($filterType === 'both') {
        // no additional filter, both purchase and sale products
    }

    $query->groupBy('products.id', 'products.name');

    // Get raw data
    $stockData = $query->get()->map(function ($product) {
        $stock_in_hand = $product->total_purchased - $product->total_sold;
        $stock_value = $product->total_purchase_value - $product->total_sale_value;

        return [
            'name' => $product->name,
            'total_purchased' => (int) $product->total_purchased,
            'total_purchase_value' => (float) $product->total_purchase_value,
            'total_sold' => (int) $product->total_sold,
            'total_sale_value' => (float) $product->total_sale_value,
            'stock_in_hand' => $stock_in_hand,
            'stock_value' => $stock_value,
            'last_purchase' => $product->last_purchase,
            'last_sale' => $product->last_sale,
        ];
    });

    // Exclude products with zero purchased if checkbox checked
    if ($excludeZeroPurchase) {
        $stockData = $stockData->filter(fn($item) => $item['total_purchased'] > 0)->values();
    }
    // Exclude products with zero stock if checkbox checked
    if ($excludeZeroStock) {
        $stockData = $stockData->filter(fn($item) => $item['stock_in_hand'] > 0)->values();
    }

    // Calculate totals for footer as before
    $totalPurchaseQty = $stockData->sum('total_purchased');
    $totalPurchaseVal = $stockData->sum('total_purchase_value');
    $totalSoldQty = $stockData->sum('total_sold');
    $totalSoldVal = $stockData->sum('total_sale_value');
    $totalStockQty = $stockData->sum('stock_in_hand');
    $totalStockVal = $stockData->sum('stock_value');

    return view('reports.index', compact(
        'stockData',
        'totalPurchaseQty', 'totalPurchaseVal',
        'totalSoldQty', 'totalSoldVal',
        'totalStockQty', 'totalStockVal'
    ));
}

public function print(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $filterType = $request->input('filter_type');
        $excludeZeroPurchase = $request->boolean('exclude_zero_purchase', false);
        $excludeZeroStock = $request->boolean('exclude_zero_stock', false);

        $query = Product::select(
            'products.id', 'products.name',
            DB::raw('COALESCE(SUM(pii.quantity), 0) as total_purchased'),
            DB::raw('COALESCE(SUM(pii.quantity * pii.unit_price), 0) as total_purchase_value'),
            DB::raw('COALESCE(MAX(pii.created_at), NULL) as last_purchase'),
            DB::raw('COALESCE(SUM(sii.quantity), 0) as total_sold'),
            DB::raw('COALESCE(SUM(sii.quantity * sii.price), 0) as total_sale_value'),
            DB::raw('COALESCE(MAX(sii.created_at), NULL) as last_sale')
        )
        ->leftJoin('purchase_invoice_items as pii', 'pii.product_id', '=', 'products.id')
        ->leftJoin('sale_invoice_items as sii', 'sii.fk_product_id', '=', 'products.id');

        // Apply date filters to purchase and sale joins
        if ($fromDate) {
            $query->where(function($q) use ($fromDate) {
                $q->where('pii.created_at', '>=', $fromDate)
                ->orWhere('sii.created_at', '>=', $fromDate);
            });
        }
        if ($toDate) {
            $query->where(function($q) use ($toDate) {
                $q->where('pii.created_at', '<=', $toDate)
                ->orWhere('sii.created_at', '<=', $toDate);
            });
        }

        // Filter type (purchase or sale)
        if ($filterType === 'purchase') {
            $query->whereNotNull('pii.id');
        } elseif ($filterType === 'sale') {
            $query->whereNotNull('sii.id');
        }

        $query->groupBy('products.id', 'products.name');

        $stockData = $query->get()->map(function ($product) {
            $stock_in_hand = $product->total_purchased - $product->total_sold;
            $stock_value = $product->total_purchase_value - $product->total_sale_value;

            return [
                'name' => $product->name,
                'total_purchased' => (int) $product->total_purchased,
                'total_purchase_value' => (float) $product->total_purchase_value,
                'total_sold' => (int) $product->total_sold,
                'total_sale_value' => (float) $product->total_sale_value,
                'stock_in_hand' => $stock_in_hand,
                'stock_value' => $stock_value,
                'last_purchase' => $product->last_purchase,
                'last_sale' => $product->last_sale,
            ];
        });

        // Exclude zero purchased or zero stock if requested
        if ($excludeZeroPurchase) {
            $stockData = $stockData->filter(fn($item) => $item['total_purchased'] > 0);
        }
        if ($excludeZeroStock) {
            $stockData = $stockData->filter(fn($item) => $item['stock_in_hand'] > 0);
        }

        $totalPurchaseQty = $stockData->sum('total_purchased');
        $totalPurchaseVal = $stockData->sum('total_purchase_value');
        $totalSoldQty = $stockData->sum('total_sold');
        $totalSoldVal = $stockData->sum('total_sale_value');
        $totalStockQty = $stockData->sum('stock_in_hand');
        $totalStockVal = $stockData->sum('stock_value');
        $userName = Auth::user()->name ?? 'Unknown User';
        
        return view('reports.print', compact(
            'stockData', 'totalPurchaseQty', 'totalPurchaseVal',
            'totalSoldQty', 'totalSoldVal', 'totalStockQty', 'totalStockVal',
            'fromDate', 'toDate', 'filterType', 'excludeZeroPurchase', 'excludeZeroStock',
            'userName'
        ));
    }

}