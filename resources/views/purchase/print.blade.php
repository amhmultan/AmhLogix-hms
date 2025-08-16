<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Purchase Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style> 
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #000;
        }

        #print-area {
            padding: 40px;
            box-sizing: border-box;
            max-width: 100%;
            overflow: hidden;
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
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        th, td {
            word-break: break-word;
            max-width: 150px; /* Adjust as needed */
            padding: 8px;
            font-size: 13px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #eee;
        }

        .totals {
            text-align: right;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #print-area, #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div id="print-area">
        
        {{-- Pharmacy Header --}}
        <div style="margin-bottom: 20px;">
            <div class="row">
                <div class="col-sm-3">
                    @if(isset($pharmacy->pic))
                    <img src="{{ asset('img/'.$pharmacy->pic) }}" alt="Logo" style="max-height: 105px;"><br>
                    @endif
                </div>
                <div class="col-sm-9">
                    <h1 class="m-0 p-0 text-font-bold text-uppercase">{{ $pharmacy->name ?? 'Pharmacy Name' }}</h1>
                    <p class="m-0">{{ $pharmacy->address ?? 'Pharmacy Address' }}</p>
                    <p><strong>Phone:</strong> {{ $pharmacy->phone ?? 'Phone Number' }}</p>  
                </div>
            </div>
            
        </div>
        <hr/>
        <h2 class="my-5 text-font-bold"><u>Purchase Invoice</u></h2>

        <div class="info">
            <p><strong>Invoice Number:</strong> {{ $purchase_invoice->invoice_number }}</p>
            <p><strong>Purchase Date:</strong> {{ $purchase_invoice->purchase_date }}</p>
            <p><strong>Supplier:</strong> {{ $purchase_invoice->supplier->name }}</p>
        </div>

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
                @foreach($purchase_invoice->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->batch_no ?? '-' }}</td>
                        <td>{{ $item->expiry_date ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rs. {{ number_format($item->unit_price, 2) }}</td>
                        <td>Rs. {{ number_format($item->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <p><strong>Gross Amount:</strong> Rs. {{ number_format($purchase_invoice->total_amount, 2) }}</p>
            <p><strong>Discount:</strong> Rs. {{ number_format($purchase_invoice->discount, 2) }}</p>
            <p><strong>Tax ({{ $purchase_invoice->tax_percent }}%):</strong> Rs. {{ number_format($purchase_invoice->tax_amount, 2) }}</p>
            <p><strong>Net Amount:</strong> Rs. {{ number_format($purchase_invoice->net_amount, 2) }}</p>
        </div>

        @if($purchase_invoice->notes)
            <div>
                <p><strong>Remarks:</strong></p>
                <p>{{ $purchase_invoice->notes }}</p>
            </div>
        @endif
    </div>

    <script>
        window.onload = () => window.print();
    </script>

</body>
</html>
