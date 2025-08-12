<style>
    .table-bordered,
    .table-bordered th,
    .table-bordered td {
        border: 2px solid black !important;
    }
</style>

<x-app-layout>
    <div class="my-6 p-4">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="mb-5 row">
            <div class="col-auto">
                <label for="from_date" class="form-label">From Date</label>
                <input type="date" id="from_date" name="from_date" value="{{ request('from_date') }}" class="form-control">
            </div>
            <div class="col-auto">
                <label for="to_date" class="form-label">To Date</label>
                <input type="date" id="to_date" name="to_date" value="{{ request('to_date') }}" class="form-control">
            </div>
            <div class="col-auto">
                <label for="filter_type" class="form-label">Filter Type</label>
                <select id="filter_type" name="filter_type" class="form-select">
                    <option value="both" {{ request('filter_type') == 'both' ? 'selected' : '' }}>Both</option>
                    <option value="purchase" {{ request('filter_type') == 'purchase' ? 'selected' : '' }}>Purchases</option>
                    <option value="sale" {{ request('filter_type') == 'sale' ? 'selected' : '' }}>Sales</option>
                </select>
            </div>
            <div class="col-auto form-check" style="margin-top: 28px;">
                <input type="checkbox" class="form-check-input" id="exclude_zero_purchase" name="exclude_zero_purchase" value="1" {{ request('exclude_zero_purchase') ? 'checked' : '' }}>
                <label class="form-check-label" for="exclude_zero_purchase">Exclude zero purchased</label>
            </div>
            <div class="col-auto form-check" style="margin-top: 28px;">
                <input type="checkbox" class="form-check-input" id="exclude_zero_stock" name="exclude_zero_stock" value="1" {{ request('exclude_zero_stock') ? 'checked' : '' }}>
                <label class="form-check-label" for="exclude_zero_stock">Exclude zero stock in hand</label>
            </div>
            <div class="col-auto" style="margin-top: 28px;">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    
        <hr />
    
        <div class="d-flex justify-content-between mt-5 mb-3">
            <h2 class="text-2xl font-bold text-primary">Stock Report</h2>
            <a href="{{ route('admin.reports.print', request()->all()) }}" target="_blank" class="btn btn-success">
                <i class="fas fa-print mr-1"></i> Print Report
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-warning">
                    <tr>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">S.No.</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Product Name</th>
                        <th colspan="2">Total Purchased</th>
                        <th colspan="2">Total Sold</th>
                        <th colspan="2">Stock In Hand</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Last Purchase Date</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Last Sale Date</th>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <th>Value (Rs.)</th>
                        <th>Quantity</th>
                        <th>Value (Rs.)</th>
                        <th>Quantity</th>
                        <th>Value (Rs.)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stockData as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['total_purchased'] }}</td>
                            <td>{{ number_format($item['total_purchase_value'], 2) }}</td>
                            <td>{{ $item['total_sold'] }}</td>
                            <td>{{ number_format($item['total_sale_value'], 2) }}</td>
                            <td>{{ $item['stock_in_hand'] }}</td>
                            <td>{{ number_format($item['stock_value'], 2) }}</td>
                            <td>{{ $item['last_purchase'] ? \Carbon\Carbon::parse($item['last_purchase'])->format('d M Y') : 'N/A' }}</td>
                            <td>{{ $item['last_sale'] ? \Carbon\Carbon::parse($item['last_sale'])->format('d M Y') : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-info fw-bold">
                    <tr>
                        <td colspan="2" class="text-center">Totals:</td>
                        <td>{{ $totalPurchaseQty }}</td>
                        <td>{{ number_format($totalPurchaseVal, 2) }}</td>
                        <td>{{ $totalSoldQty }}</td>
                        <td>{{ number_format($totalSoldVal, 2) }}</td>
                        <td>{{ $totalStockQty }}</td>
                        <td>{{ number_format($totalStockVal, 2) }}</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-app-layout>
