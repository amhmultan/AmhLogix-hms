<x-app-layout>
<div class="container bg-white p-3">

    {{-- Action Buttons --}}
    <div class="row mb-3 text-center no-print">
        <div class="col-sm-12">
            <a href="{{ route('admin.admissions.index') }}" class="btn btn-info text-light"><u>B</u>ack</a>
            <button class="btn btn-success text-light" onclick="printDiv('printableArea')" accesskey="p">Print</button>
        </div>
    </div>
    
    <div class="container" id="printableArea">

        {{-- Hospital Header --}}
        @if($hospital ?? false)
        <div class="row mb-2" style="font-size:12px;">
            <div class="col-sm-2 text-center">
                <img src="{{ asset('img/' . $hospital->logo) }}" 
                     style="border: 2px solid black; width:100px; height:100px; padding: 2px;" 
                     alt="{{ $hospital->title }} Logo">
            </div>
            <div class="col-sm-10 text-center">
                <h4 class="fw-bold text-uppercase mb-0">{{ $hospital->title }}</h4>
                <p class="mb-0">{{ $hospital->address }}</p>
                <p class="mb-0">
                    <strong>Contact:</strong> {{ $hospital->contact }} |
                    <strong>Email:</strong> {{ $hospital->email }} |
                    <strong>Website:</strong> {{ $hospital->website }}
                </p>
            </div>
        </div>
        @endif

        <hr style="margin:5px 0;">

        {{-- ADMISSION SLIP Subheading --}}
        <div class="text-center fw-bold mb-2" style="font-size:14px;">ADMISSION SLIP</div>

        {{-- Patient Info --}}
        <div class="fw-bold mb-1" style="font-size:13px;">Patient Information</div>
        <table class="table table-bordered w-100" style="font-size:12px; margin-bottom:5px;">
            <tbody>
                <tr>
                    <th>MR No:</th>
                    <td>{{ $admission->patient->id }}</td>
                    <th>Patient Name:</th>
                    <td>{{ $admission->patient->name }}</td>
                    <th>Panel:</th>
                    <td>{{ $admission->patient->reffered_by ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Contact:</th>
                    <td>{{ $admission->patient->phone }}</td>
                    <th>CNIC:</th>
                    <td>{{ $admission->patient->cnic }}</td>
                    <th>Doctor:</th>
                    <td>{{ $admission->doctor->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Ward / Bed:</th>
                    <td>{{ ucfirst($admission->bed->ward->name ?? '-') }} / {{ $admission->bed->bed_number ?? '-' }}</td>
                    <th>Admission Date:</th>
                    <td>{{ $admission->admission_date->format('d-m-Y H:i') }}</td>
                    @if($admission->status == 'discharged')
                    <tr>
                        <th class="align-middle">Discharge Date:</th>
                        <td class="text-center align-middle">{{ $admission->discharge_date->format('d-m-Y H:i') }}</td>
                    </tr>
                    @endif
                </tr>
                <tr>
                    <th>Diagnosis:</th>
                    <td colspan="3">{{ $admission->diagnosis ?? 'N/A' }}</td>
                    <th>Admission Fees:</th>
                    <td>{{ $admission->admission_fees ? number_format($admission->admission_fees, 2) : '0.00' }}</td>
                </tr>
            </tbody>
        </table>

        @if($admission->status == 'discharged' && $admission->dischargeSummary)
        <div class="fw-bold mb-1" style="font-size:13px;">Discharge Summary</div>
        <table class="table table-bordered w-100" style="font-size:12px; margin-bottom:5px;">
            <tbody>
                <tr>
                    <th>Clinical Notes</th>
                    <td>{{ $admission->dischargeSummary->notes ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Medications on Discharge</th>
                    <td>{{ $admission->dischargeSummary->medications ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Follow-up Instructions</th>
                    <td>{{ $admission->dischargeSummary->follow_up ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>
        @endif
        
        {{-- Spacer --}}
        <div style="height:650px;"></div>

        {{-- Doctor Signature --}}
        <div class="text-end mt-2" style="font-size:12px;">
            <div>Doctor's Signature</div>
        </div>

    </div>
</div>

{{-- Print Script --}}
<script>
    function printDiv(printableArea) {
        const printContents = document.getElementById(printableArea).innerHTML;
        const printWindow = window.open('', '', 'height=800,width=1000');
        printWindow.document.write('<html><head><title>MR No: {{ $admission->patient->id }}</title>');
        // use CDN for bootstrap
        printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">');
        printWindow.document.write('<style>@media print {.no-print { display: none !important; } table { font-size:12px; } }</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(printContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>
</x-app-layout>
