<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<div class="title">
    OPD Token Report
</div>

<div>
    <strong>From:</strong> {{ $request->from_date ?? 'Start' }}
    |
    <strong>To:</strong> {{ $request->to_date ?? 'End' }}
</div>

<br>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Patient</th>
            <th>Referred By</th>
            <th>MR #</th>
            <th>Doctor</th>
            <th>Speciality</th>
            <th>Fees</th>
        </tr>
    </thead>

    <tbody>
        @foreach($records as $index => $row)
        <tr>
            <td>{{ $index + 1 }}</td>

            <td>
                {{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y h:i A') }}
            </td>

            <td>{{ $row->patient?->name ?? '-' }}</td>
            <td>{{ $row->patient?->reffered_by ?? '-' }}</td>
            <td>{{ $row->patient?->id ?? '-' }}</td>
            <td>{{ $row->doctor?->name ?? '-' }}</td>
            <td>{{ $row->speciality?->title ?? '-' }}</td>
            <td>{{ number_format($row->denomination ?? 0, 2) }}</td>
        </tr>
        @endforeach

        <!-- Totals -->
        <tr>
            <td colspan="6" class="right"><strong>Totals:</strong></td>
            <td><strong>{{ $totalTokens }}</strong></td>
            <td><strong>{{ number_format($totalAmount, 2) }}</strong></td>
        </tr>
    </tbody>
</table>

</body>
</html>