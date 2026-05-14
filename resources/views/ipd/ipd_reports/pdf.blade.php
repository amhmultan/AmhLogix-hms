<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>IPD Report PDF</title>
    <style>

        @page {
            margin: 35px 45px 35px 45px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #000;
        }

        h2 {
            margin: 5px 0;
        }

        /* =========================
        HEADER
        ========================= */

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .header-table td {
            border: none;
            vertical-align: top;
        }

        /* =========================
        FILTERS
        ========================= */

        .filters {
            margin: 8px 0 12px;
            font-size: 9px;
            padding: 5px;
            /* border: 1px solid #ccc; */
        }

        /* =========================
        MAIN TABLE
        ========================= */

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            font-size: 10px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* =========================
        COLUMN WIDTHS
        ========================= */

        .col-sr       { width: 4%; }
        .col-mr       { width: 7%; }
        .col-patient  { width: 12%; }
        .col-panel    { width: 10%; }
        .col-adm      { width: 7%; }
        .col-date     { width: 14%; }
        .col-dis      { width: 14%; }
        .col-doc      { width: 14%; }
        .col-ward     { width: 10%; }
        .col-bill     { width: 8%; }

        /* =========================
        FOOTER
        ========================= */

        .footer {
            position: fixed;
            bottom: -18px;
            left: 0;
            right: 0;
            height: 30px;
            font-size: 8px;
            text-align: center;
        }

    </style>
</head>
<body>
    {{-- Hospital Header --}}
    @if($hospital)
    <table class="header-table">
        <tr>
            <td width="20%" style="text-align:center;">
                <img src="{{ public_path('img/' . $hospital->logo) }}" 
                     style="border: 2px solid black; width:100px; height:80px; padding:5px;" 
                     alt="{{ $hospital->title }} Logo">
            </td>
            <td width="80%" style="text-align:left; vertical-align: top;">
                <h2 style="margin:0; text-transform:uppercase; font-size: 22px;">{{ $hospital->title }}</h2>
                <p style="margin:2px 0;">{{ $hospital->address }}</p>
                <p style="margin:2px 0;">
                    <strong>Contact:</strong> {{ $hospital->contact }} |
                    <strong>Email:</strong> {{ $hospital->email }} |
                    <strong>Website:</strong> {{ $hospital->website }}
                </p>
            </td>
        </tr>
    </table>
    @endif

    <h1 style="text-align: center; margin-bottom: 10px; text-decoration: underline;">IPD Report</h1>

    {{-- Filters Applied --}}
    <div class="filters">
        @if(request('from_date') && request('to_date'))
            <strong>Date: </strong>{{ request('from_date') }} to {{ request('to_date') }} <br>
        @endif
        @if(request('doctor_id'))
            @php
                $doc = $doctors->firstWhere('id', request('doctor_id'));
            @endphp
            <strong>Doctor: </strong>{{ $doc ? $doc->name . ' (' . $doc->speciality->title . ')' : 'N/A' }} <br>
        @endif
        @if(request('panel_name'))
            <strong>Panel: </strong>{{ request('panel_name') }} <br>
        @endif
        @if(request('bed_id'))
            @php
                $bed = $beds->firstWhere('id', request('bed_id'));
            @endphp
            <strong>Ward / Bed:</strong> {{ $bed ? $bed->ward_name . ' / ' . $bed->bed_number : 'N/A' }} <br>
        @endif
        @if(request('status'))
            <strong>Status: </strong>{{ request('status') }} <br>
        @endif
        @if(!request('from_date') && !request('to_date') && !request('doctor_id') && !request('panel_name') && !request('bed_id') && !request('status'))
            <strong>Filters:</strong> None
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-sr">No.</th>
                <th class="col-mr">MR#</th>
                <th class="col-patient">Patient Name</th>
                <th class="col-panel">Referred By</th>
                <th class="col-adm">Admission ID</th>
                <th class="col-date">Admission Date</th>
                <th class="col-dis">Discharge Date</th>
                <th class="col-doc">Doctor / Speciality</th>
                <th class="col-ward">Ward / Bed</th>
                <th class="col-bill">Bill</th>
            </tr>
        </thead>
        <tbody>

        @foreach($admissions as $key => $admission)

            @php

                $admissionDate = \Carbon\Carbon::parse($admission->admission_date);

                $dischargeDate = $admission->discharge_date
                    ? \Carbon\Carbon::parse($admission->discharge_date)
                    : now();

                $days = max(1, $admissionDate->diffInDays($dischargeDate));

                $bedCharges = $admission->bed->rate_per_day ?? 0;

                $roomAmount = $days * $bedCharges;

                $otherCharges = $admission->charges->sum('amount');

                $totalBill =
                    ($admission->admission_fees ?? 0)
                    + $roomAmount
                    + $otherCharges;

            @endphp

            <tr>

                <td>{{ $key + 1 }}</td>

                <td>
                    {{ $admission->patient->id ?? '-' }}
                </td>

                <td>
                    {{ $admission->patient->name ?? '-' }}
                </td>

                <td>
                    {{ $admission->patient->reffered_by ?? '-' }}
                </td>

                <td>
                    {{ $admission->id }}
                </td>

                <td>
                    {{ optional($admission->admission_date)->format('d/m/y h:i A') }}
                </td>

                <td>
                    {{ $admission->discharge_date
                        ? \Carbon\Carbon::parse($admission->discharge_date)->format('d/m/y h:i A')
                        : 'Admitted'
                    }}
                </td>

                <td>
                    {{ $admission->doctor->name ?? '-' }}
                    /
                    {{ $admission->doctor->speciality->title ?? '-' }}
                </td>

                <td>
                    {{ $admission->bed->ward->name ?? '-' }}
                    /
                    {{ $admission->bed->bed_number ?? '-' }}
                </td>

                <td>
                    {{ number_format($totalBill, 2) }}
                </td>

            </tr>

        @endforeach

        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        Report generated by: {{ auth()->user()->name ?? 'System' }} on {{ now()->format('d M Y, h:i A') }} | Page <span class="pagenum"></span>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("DejaVu Sans", "normal");
                $size = 9;

                // Left side footer: generated by + date
                $text_left = "Report generated by: ' . (auth()->user()->name ?? 'System') . '";
                $date_text = "Generated on: ' . now()->format("d M Y, h:i A") . '";
                $pdf->text(35, 820, $text_left, $font, $size);
                $pdf->text(35, 835, $date_text, $font, $size);

                // Right side footer: page numbers
                $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
                $pdf->text(720, 835, $pageText, $font, $size);
            ');
        }
    </script>
</body>
</html>
