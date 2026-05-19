<!DOCTYPE html>
<html>
<head>
    <title>Token Thermal Print</title>

    <style>
        @page {
            size: 80mm auto;
            margin: 5mm;
        }

        body {
            width: 80mm;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .center {
            text-align: center;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .bold { font-weight: bold; }
        .small { font-size: 11px; }
        .row { margin-bottom: 3px; }
        .right { text-align: right; }

        .logo {
            max-width: 60px;
            height: auto;
            margin-bottom: 5px;
        }

        .qr {
            margin-top: 5px;
        }
        @media print {
            body {
                visibility: visible;
            }

            /* hide everything except content */
            * {
                visibility: visible;
            }

            /* optional: remove any buttons if present */
            .no-print {
                display: none !important;
            }
        }
        
    </style>
</head>

<body onload="autoPrint()">

    {{-- HEADER --}}
    <div class="center">

        {{-- LOGO --}}
        @if(!empty($hospital->logo))
            <img class="logo"
                 src="{{ asset('img/'.$hospital->logo) }}"
                 alt="Hospital Logo">
        @endif

        <div class="bold">{{ $hospital->title ?? '' }}</div>
        <div class="small">{{ $hospital->address ?? '' }}</div>
        <div class="small">{{ $hospital->contact ?? '' }}</div>
    </div>

    <hr>

    {{-- TOKEN INFO --}}
    <div>
        <div class="row"><span class="bold">Token #:</span> {{ $token->id }}</div>
        <div class="row"><span class="bold">Date:</span> {{ $token->created_at }}</div>
    </div>

    <hr>

    {{-- PATIENT INFO --}}
    <div>
        <div class="row"><span class="bold">MR #:</span> {{ $patient->id ?? '' }}</div>
        <div class="row"><span class="bold">Name:</span> {{ $patient->name ?? '' }}</div>
        <div class="row"><span class="bold">Age:</span> {{ $patient->age_detailed ?? '' }}</div>
        <div class="row"><span class="bold">Gender:</span> {{ $patient->gender ?? '' }}</div>
        <div class="row"><span class="bold">Phone:</span> {{ $patient->phone ?? '' }}</div>
    </div>

    <hr>

    {{-- DOCTOR --}}
    <div>
        <div class="row"><span class="bold">Doctor:</span> {{ $doctor->name ?? '' }}</div>
    </div>

    <hr>

    {{-- FEES --}}
    <div>
        <div class="row"><span class="bold">Fees:</span> {{ $token->fees ?? 0 }}</div>
        <div class="row"><span class="bold">Paid:</span> {{ $token->denomination ?? 0 }}</div>
        <div class="row"><span class="bold">Balance:</span> {{ $token->balance ?? 0 }}</div>
    </div>

    <hr>

    {{-- QR CODE --}}
    <div class="center qr">
        {!! QrCode::size(80)->generate($qrData) !!}
        <div class="small">Scan for token verification</div>
    </div>

    <br>

    <div class="center small">
        Please keep this token safe
    </div>

    <br>

    <!-- <div class="right">
        ----------------------<br>
        Signature
    </div> -->

    <script>
        function autoPrint() {
            window.print();
        }

        // Close tab after printing
        window.onafterprint = function () {
            window.close();
        };
    </script>
</body>
</html>