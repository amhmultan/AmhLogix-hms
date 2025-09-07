<!DOCTYPE html>
<html>
<head>
    <title>IPD Report</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 5px; text-align: left; }
    </style>
</head>
<body>
<h3>IPD Report</h3>
<table>
    <thead>
        <tr>
            <th>Sr. No.</th>
            <th>MR Number</th>
            <th>Admission ID</th>
            <th>Bed</th>
            <th>Total Billing</th>
        </tr>
    </thead>
    <tbody>
        @foreach($admissions as $key => $admission)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $admission->mr_number }}</td>
            <td>{{ $admission->admission_id }}</td>
            <td>{{ $admission->bed_name }}</td>
            <td>{{ $admission->discharge_date ? $admission->billing_total : '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
