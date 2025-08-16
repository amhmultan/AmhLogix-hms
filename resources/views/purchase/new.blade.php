<x-app-layout>
    <div class="container mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">New Purchase Invoice</h1>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc pl-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.purchases.store') }}" method="POST" id="purchase-form">
            @csrf

            {{-- Invoice Info --}}
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block mb-1 font-medium">Invoice Number</label>
                    <input type="text" name="invoice_number" value="{{ old('invoice_number') }}"
                           class="w-full border rounded p-2" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Supplier</label>
                    <select name="supplier_id" class="w-full border rounded p-2" required>
                        <option value="">-- Select Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Purchase Date</label>
                    <input type="date" name="purchase_date" value="{{ old('purchase_date', now()->toDateString()) }}"
                           class="w-full border rounded p-2" required>
                </div>
            </div>

            {{-- Items Table --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Items</h2>
                <table class="w-full border border-collapse" id="items-table">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-2">Product</th>
                            <th class="border p-2">Batch No</th>
                            <th class="border p-2">Expiry Date</th>
                            <th class="border p-2">Quantity</th>
                            <th class="border p-2">Unit Price</th>
                            <th class="border p-2">Total</th>
                            <th class="border p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <button type="button" id="add-row"
                        class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">+ Add Item</button>
            </div>

            {{-- Totals --}}
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block mb-1 font-medium">Discount</label>
                    <input type="number" step="0.01" name="discount" id="discount"
                           value="{{ old('discount', 0) }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block mb-1 font-medium">Tax (%)</label>
                    <input type="number" step="0.01" name="tax_percent" id="tax_percent"
                           value="{{ old('tax_percent', 0) }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block mb-1 font-medium">Notes</label>
                    <textarea name="notes" class="w-full border rounded p-2">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-6 mb-6">
                <div>
                    <label class="block font-medium">Total Amount</label>
                    <input type="text" id="total_amount" name="total_amount" readonly
                           class="w-full border rounded p-2 bg-gray-100">
                </div>
                <div>
                    <label class="block font-medium">Tax Amount</label>
                    <input type="text" id="tax_amount" name="tax_amount" readonly
                           class="w-full border rounded p-2 bg-gray-100">
                </div>
                <div>
                    <label class="block font-medium">Net Amount</label>
                    <input type="text" id="net_amount" name="net_amount" readonly
                           class="w-full border rounded p-2 bg-gray-100">
                </div>
            </div>

            <div class="flex justify-end">
                <a class="btn-lg btn-warning mx-3" href="{{ route('admin.purchases.index')}}" accesskey="b" role="button"><u>B</u>ack</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-2 rounded">
                    SAVE
                </button>
            </div>
        </form>
    </div>

    {{-- Scripts --}}
    @push('scripts')
        <script>
            let rowCount = 0;

            function recalcTotals() {
                let total = 0;
                document.querySelectorAll('.line-total').forEach(el => {
                    total += parseFloat(el.value) || 0;
                });

                let discount = parseFloat(document.getElementById('discount').value) || 0;
                let taxPercent = parseFloat(document.getElementById('tax_percent').value) || 0;
                let taxable = Math.max(total - discount, 0);
                let tax = taxable * (taxPercent / 100);
                let net = taxable + tax;

                document.getElementById('total_amount').value = total.toFixed(2);
                document.getElementById('tax_amount').value = tax.toFixed(2);
                document.getElementById('net_amount').value = net.toFixed(2);
            }

            function addRow() {
                let tbody = document.querySelector('#items-table tbody');
                let row = document.createElement('tr');

                row.innerHTML = `
                    <td class="border p-2">
                        <select name="items[${rowCount}][product_id]" class="w-full product-select"></select>
                    </td>
                    <td class="border p-2">
                        <input type="text" name="items[${rowCount}][batch_no]" class="w-full border rounded p-1">
                    </td>
                    <td class="border p-2">
                        <input type="date" name="items[${rowCount}][expiry_date]" class="w-full border rounded p-1">
                    </td>
                    <td class="border p-2">
                        <input type="number" name="items[${rowCount}][quantity]" class="w-full border rounded p-1 qty" value="1" min="1">
                    </td>
                    <td class="border p-2">
                        <input type="number" step="0.01" name="items[${rowCount}][unit_price]" class="w-full border rounded p-1 price" value="0">
                    </td>
                    <td class="border p-2">
                        <input type="text" name="items[${rowCount}][total_price]" class="w-full border rounded p-1 line-total bg-gray-100" readonly>
                    </td>
                    <td class="border p-2 text-center">
                        <button type="button" class="remove-row text-red-600">X</button>
                    </td>
                `;

                tbody.appendChild(row);

                // Init Select2
                $(row).find('.product-select').select2({
                    width: '100%',
                    placeholder: 'Search product...',
                    ajax: {
                        url: '{{ route("admin.products.ajax") }}',
                        dataType: 'json',
                        delay: 250,
                        data: params => ({ q: params.term }),
                        processResults: data => ({ results: data.results || [] })
                    }
                });

                // Event listeners
                row.querySelector('.qty').addEventListener('input', updateLineTotal);
                row.querySelector('.price').addEventListener('input', updateLineTotal);
                row.querySelector('.remove-row').addEventListener('click', () => {
                    row.remove();
                    recalcTotals();
                });

                rowCount++;
            }

            function updateLineTotal(e) {
                let row = e.target.closest('tr');
                let qty = parseFloat(row.querySelector('.qty').value) || 0;
                let price = parseFloat(row.querySelector('.price').value) || 0;
                let total = qty * price;
                row.querySelector('.line-total').value = total.toFixed(2);
                recalcTotals();
            }

            document.getElementById('add-row').addEventListener('click', addRow);
            document.getElementById('discount').addEventListener('input', recalcTotals);
            document.getElementById('tax_percent').addEventListener('input', recalcTotals);

            // Add first row on load
            addRow();
        </script>
    @endpush
</x-app-layout>
