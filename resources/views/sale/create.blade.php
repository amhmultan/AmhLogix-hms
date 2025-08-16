<x-app-layout>
<div class="container mx-auto py-6">

    <h2 class="text-2xl font-bold mb-4 text-red-600">Add <span class="text-green-600">Sale Invoice</span></h2>

    {{-- Display Errors --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-6 mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Search Patient --}}
    <form method="GET" action="" class="mb-6">
        <div class="flex gap-2 items-center">
            <input type="search" name="search" placeholder="Enter MR Number"
                  class="border rounded p-2 w-1/4"
                  value="{{ old('search', $search ?? '') }}">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Search</button>
        </div>
    </form>

    {{-- Patient Info & Invoice Form --}}
    @if(!empty($search))
        @if(!empty($patients) && count($patients) > 0)
            @php $patient = $patients[0]; @endphp

            {{-- Patient Info --}}
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="font-medium">Patient Name</label>
                    <div class="p-2 border rounded">{{ $patient->name }}</div>
                </div>
                <div>
                    <label class="font-medium">Contact</label>
                    <div class="p-2 border rounded">{{ $patient->phone }}</div>
                </div>
                <div>
                    <label class="font-medium">Address</label>
                    <div class="p-2 border rounded">{{ $patient->address }}</div>
                </div>
            </div>

            {{-- Sale Invoice Form --}}
            <form action="{{ route('admin.sales.store') }}" method="POST" id="sale-form">
                @csrf
                <input type="hidden" name="fk_patient_id" value="{{ $patient->id }}">

                {{-- Invoice Date --}}
                <div class="mb-4">
                    <label class="font-medium">Invoice Date</label>
                    <input type="date" name="date" class="border rounded p-2 w-full" value="{{ old('date', date('Y-m-d')) }}" required>
                </div>

                {{-- Items Table --}}
                <h3 class="text-lg font-semibold mb-2">Invoice Items</h3>
                <div class="mb-2 text-right">
                    <button type="button" class="bg-gray-600 text-white px-3 py-1 rounded" id="addRow">+ Add Item</button>
                </div>

                <div class="overflow-x-auto mb-4">
                    <table class="table-auto border-collapse w-full border" id="itemsTable">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2">Product</th>
                                <th class="border p-2">Batch</th>
                                <th class="border p-2">Expiry</th>
                                <th class="border p-2">Qty</th>
                                <th class="border p-2">Unit Price</th>
                                <th class="border p-2">Total</th>
                                <th class="border p-2">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                {{-- Discount & Tax --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="font-medium">Discount (Rs.)</label>
                        <input type="number" step="0.01" name="discount" id="discount" class="border rounded p-2 w-full" value="{{ old('discount', 0) }}">
                    </div>
                    <div>
                        <label class="font-medium">Tax (%)</label>
                        <input type="number" step="0.01" name="tax_percentage" id="tax_percentage" class="border rounded p-2 w-full" value="{{ old('tax_percentage', 0) }}">
                    </div>
                </div>

                {{-- Totals --}}
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="font-medium">Gross Amount</label>
                        <input type="text" id="grossAmount" readonly class="border rounded p-2 w-full bg-gray-100">
                        <input type="hidden" name="gross_amount" id="gross_amount_input">
                    </div>
                    <div>
                        <label class="font-medium">Tax Amount</label>
                        <input type="text" id="taxAmount" readonly class="border rounded p-2 w-full bg-gray-100">
                        <input type="hidden" name="tax_amount" id="tax_amount_input">
                    </div>
                    <div>
                        <label class="font-medium">Net Amount</label>
                        <input type="text" id="netAmount" readonly class="border rounded p-2 w-full bg-gray-100">
                        <input type="hidden" name="net_amount" id="net_amount_input">
                    </div>
                </div>

                <div class="text-right">
                    <a href="{{ route('admin.sales.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Back</a>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Save Invoice</button>
                </div>
            </form>
        @else
            <div class="bg-yellow-100 text-yellow-800 p-3 rounded">
                No patient found with MR Number: {{ $search }}
            </div>
        @endif
    @endif
</div>

@push('scripts')
<script>
let rowIndex = 0;

// Add first row on load
document.addEventListener('DOMContentLoaded', addRow);

// Add Row
document.getElementById('addRow').addEventListener('click', addRow);

function addRow() {
    const tbody = document.querySelector('#itemsTable tbody');
    const row = document.createElement('tr');

    row.innerHTML = `
        <td class="border p-1">
            <select name="items[${rowIndex}][fk_product_id]" class="product-select w-full border rounded p-1" required></select>
        </td>
        <td class="border p-1"><input type="text" name="items[${rowIndex}][batch_no]" class="border rounded p-1 w-full"></td>
        <td class="border p-1"><input type="date" name="items[${rowIndex}][expiry_date]" class="border rounded p-1 w-full"></td>
        <td class="border p-1"><input type="number" name="items[${rowIndex}][quantity]" class="quantity border rounded p-1 w-full" min="1" value="1"></td>
        <td class="border p-1"><input type="number" step="0.01" name="items[${rowIndex}][unit_price]" class="unit_price border rounded p-1 w-full" value="0"></td>
        <td class="border p-1"><input type="text" class="line-total border rounded p-1 w-full bg-gray-100" readonly></td>
        <td class="border p-1 text-center"><button type="button" class="remove-item text-red-600">X</button></td>
    `;
    tbody.appendChild(row);

    // Init AJAX Select2 for product search
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

    row.querySelector('.quantity').addEventListener('input', calculateAmounts);
    row.querySelector('.unit_price').addEventListener('input', calculateAmounts);
    row.querySelector('.remove-item').addEventListener('click', e => {
        e.target.closest('tr').remove();
        calculateAmounts();
    });

    rowIndex++;
}

// Recalculate totals
document.getElementById('discount').addEventListener('input', calculateAmounts);
document.getElementById('tax_percentage').addEventListener('input', calculateAmounts);

function calculateAmounts() {
    let total = 0;
    document.querySelectorAll('#itemsTable tbody tr').forEach(row => {
        const qty = parseFloat(row.querySelector('.quantity')?.value || 0);
        const price = parseFloat(row.querySelector('.unit_price')?.value || 0);
        const lineTotal = qty * price;
        row.querySelector('.line-total').value = lineTotal.toFixed(2);
        total += lineTotal;
    });

    const discount = parseFloat(document.getElementById('discount')?.value || 0);
    const taxPercent = parseFloat(document.getElementById('tax_percentage')?.value || 0);

    const afterDiscount = total - discount;
    const taxAmount = afterDiscount * (taxPercent / 100);
    const net = afterDiscount + taxAmount;

    document.getElementById('grossAmount').value = total.toFixed(2);
    document.getElementById('netAmount').value = net.toFixed(2);
    document.getElementById('taxAmount').value = taxAmount.toFixed(2);

    document.getElementById('gross_amount_input').value = total.toFixed(2);
    document.getElementById('net_amount_input').value = net.toFixed(2);
    document.getElementById('tax_amount_input').value = taxAmount.toFixed(2);
}
</script>
@endpush
</x-app-layout>
