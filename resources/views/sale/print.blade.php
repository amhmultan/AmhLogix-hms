<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Sale Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #000;
        }
        #print-area {
            padding: 40px;
            max-width: 100%;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .info, .totals {
            margin-bottom: 20px;
        }
        .info p, .totals p {
            margin: 0;
            line-height: 1.6;
        }
        table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            word-wrap: break-word;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 13px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
        .totals {
            text-align: right;
        }
        @media print {
            body * { visibility: hidden; }
            #print-area, #print-area * { visibility: visible; }
            #print-area { position: absolute; left: 0; top: 0; width: 100%; }
        }
    </style>
</head>
<body>

<div id="print-area">
    {{-- Pharmacy Header --}}
    <div class="row mb-3">
        <div class="col-sm-3">
            @if(isset($pharmacy->pic))
                <img src="{{ asset('img/' . $pharmacy->pic) }}" alt="Logo" style="max-height: 105px;">
            @endif
        </div>
        <div class="col-sm-9">
            <h3 class="text-uppercase font-weight-bold m-0">{{ $pharmacy->name ?? 'Pharmacy Name' }}</h3>
            <p class="m-0">{{ $pharmacy->address ?? 'Pharmacy Address' }}</p>
            <p><strong>Phone:</strong> {{ $pharmacy->phone ?? 'Phone Number' }}</p>
        </div>
    </div>

    <hr/>
    <h2><u>Sale Invoice</u></h2>

    {{-- Invoice Info --}}
    <div class="info">
        <p><strong>Invoice ID:</strong> SI-{{ $sale->id }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($sale->sale_date)->format('d-M-Y') }}</p>
        <p><strong>MR No:</strong> {{ $sale->patient->id ?? '-' }}</p>
        <p><strong>Patient Name:</strong> {{ $sale->patient->name ?? '-' }}</p>
        <p><strong>Contact:</strong> {{ $sale->patient->phone ?? '-' }}</p>
    </div>

    {{-- Invoice Items --}}
    <table>
        <thead>
        <tr>
            <th>Product</th>
            <th>Batch #</th>
            <th>Expiry</th>
            <th>Qty</th>
            <th>Unit Price</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sale->items as $item)
            <tr>
                <td>{{ $item->product->name ?? '-' }}</td>
                <td>{{ $item->batch_no ?? '-' }}</td>
                <td>{{ $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('d-M-Y') : '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rs. {{ number_format($item->price, 2) }}</td>
                <td>Rs. {{ number_format($item->quantity * $item->price, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- Totals --}}
    @php
        $taxAmount = ($sale->gross_amount - ($sale->discount ?? 0)) * ($sale->tax ?? 0) / 100;
    @endphp
    <div class="totals mt-3">
        <p><strong>Gross Amount:</strong> Rs. {{ number_format($sale->gross_amount, 2) }}</p>
        <p><strong>Discount:</strong> Rs. {{ number_format($sale->discount ?? 0, 2) }}</p>
        <p><strong>Tax:</strong> {{ number_format($sale->tax ?? 0, 2) }}% (Rs. {{ number_format($taxAmount, 2) }})</p>
        <p><strong>Net Amount:</strong> Rs. {{ number_format($sale->net_amount, 2) }}</p>
    </div>
</div>

<script>
    window.onload = () => window.print();
</script>

</body>
</html>
