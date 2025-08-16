<x-app-layout>
    <div class="container bg-white shadow-md rounded my-6 px-5 py-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-primary font-bold text-lg">View <span class="text-success">Sale Invoice</span></h2>
            <div class="flex gap-2">
                <a class="btn btn-info" href="{{ route('admin.sales.index')}}" accesskey="b"><u>B</u>ack</a>
                <a href="{{ route('admin.sales.print', $sale->id) }}" class="btn btn-outline-primary" target="_blank">
                    Print Invoice
                </a>
            </div>
        </div>

        {{-- Invoice Info --}}
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <label class="font-semibold">Invoice Number:</label>
                <div>SI-{{ $sale->id }}</div>
            </div>
            <div>
                <label class="font-semibold">Sale Date:</label>
                <div>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d-M-Y') }}</div>
            </div>
            <div>
                <label class="font-semibold">Patient:</label>
                <div>{{ $sale->patient->name ?? '-' }}</div>
            </div>
        </div>

        <hr class="my-4">

        {{-- Items Table --}}
        <h5 class="text-primary font-semibold mb-2">Invoice Items</h5>
        <div class="overflow-x-auto mb-4">
            <table class="table-auto w-full border border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Product</th>
                        <th class="border p-2">Qty</th>
                        <th class="border p-2">Unit Price</th>
                        <th class="border p-2">Batch #</th>
                        <th class="border p-2">Expiry</th>
                        <th class="border p-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $item)
                        <tr>
                            <td class="border p-2">{{ $item->product->name }}</td>
                            <td class="border p-2">{{ $item->quantity }}</td>
                            <td class="border p-2">Rs. {{ number_format($item->price, 2) }}</td>
                            <td class="border p-2">{{ $item->batch_no ?? '-' }}</td>
                            <td class="border p-2">
                                {{ $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('d-M-Y') : '-' }}
                            </td>
                            <td class="border p-2">
                                Rs. {{ number_format($item->quantity * $item->price, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Totals --}}
        <div class="grid grid-cols-4 gap-4 mb-4 text-right font-semibold">
            <div>
                <label>Total Amount (Gross):</label>
                <div>Rs. {{ number_format($sale->gross_amount, 2) }}</div>
            </div>
            <div>
                <label>Discount:</label>
                <div>Rs. {{ number_format($sale->discount ?? 0, 2) }}</div>
            </div>
            <div>
                <label>Tax:</label>
                @php
                    $taxAmount = ($sale->gross_amount - ($sale->discount ?? 0)) * ($sale->tax ?? 0) / 100;
                @endphp
                <div>{{ number_format($sale->tax ?? 0, 2) }}% (Rs. {{ number_format($taxAmount, 2) }})</div>
            </div>
            <div>
                <label>Net Amount:</label>
                <div>Rs. {{ number_format($sale->net_amount, 2) }}</div>
            </div>
        </div>

        {{-- Notes --}}
        <div>
            <label class="font-semibold">Remarks / Notes:</label>
            <p>{{ $sale->notes ?: 'N/A' }}</p>
        </div>
    </div>
</x-app-layout>
