<x-app-layout>
    <div class="container bg-white p-4">

        {{-- Action Buttons --}}
        <div class="row mb-4 text-center no-print">
            <div class="col-sm-12">
                <a href="{{ route('admin.doctor_notes.index') }}" class="btn btn-info text-light">Back</a>
                <button class="btn btn-success text-light" onclick="printDiv('printableArea')">Print</button>
            </div>
        </div>

        {{-- Printable Area --}}
        <div class="print-container" id="printableArea">

            @if($doctor_notes->mode === 'upload')
                {{-- UPLOAD MODE --}}
                <h3 class="mb-4 text-danger"><strong><em>Doctor Notes Details</em></strong></h3>

                <p><strong>Patient ID:</strong> {{ $doctor_notes->fk_patient_id }}</p>
                <p><strong>Token ID:</strong> {{ $doctor_notes->fk_token_id }}</p>

                <h5 class="mt-4">Prescription File:</h5>
                @if($doctor_notes->prescription)
                    <p>
                        <a href="{{ asset('assets/'.$doctor_notes->prescription) }}" target="_blank" class="btn btn-primary">
                            View Prescription
                        </a>
                    </p>
                @else
                    <p>No prescription file uploaded.</p>
                @endif

            @else
                {{-- MANUAL MODE --}}
                @if(isset($hospital))
                    <div class="row mb-3">
                        <div class="col-sm-2">
                            <img src="{{ asset('img/' . $hospital->logo) }}"
                                 style="border: 5px solid black; width:150px;height:150px; padding: 5px;"
                                 alt="{{ $hospital->title }} Logo">
                        </div>
                        <div class="col-sm-10">
                            <div class="text-center mb-4">
                                <h2 class="display-6 fw-bold text-uppercase">{{ $hospital->title }}</h2>
                                <p>{{ $hospital->address }}</p>
                                <p>
                                    <strong>Contact:</strong> {{ $hospital->contact }} |
                                    <strong>Email:</strong> {{ $hospital->email }} |
                                    <strong>Website:</strong> {{ $hospital->website }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endif

                @if(isset($token))
                    {{-- Patient Info --}}
                    <div class="fw-bold">Patient Information</div>
                    <table class="table table-bordered w-100">
                        <tbody>
                            <tr>
                                <th>Token No:</th>
                                <td class="text-center">{{ $token->id }}</td>
                                <th>MR No:</th>
                                <td class="text-center">{{ $token->fk_patients_id }}</td>
                                <th>Patient:</th>
                                <td class="text-center">{{ $token->pName }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth:</th>
                                <td class="text-center">{{ $token->pAge }}</td>
                                <th>Age:</th>
                                <td class="text-center">{{ 
                                    $token->pAge
                                    ? \Carbon\Carbon::parse($token->pAge)->age . ' years, ' . \Carbon\Carbon::parse($token->pAge)->month . ' months, ' . \Carbon\Carbon::parse($token->pAge)->day . ' days'
                                    : 'N/A'}}</td>
                                <th>Checkup Date:</th>
                                <td class="text-center">{{ date('d-m-Y', strtotime($token->created_at)) }}</td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td colspan="5">{{ $token->pAddress }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endif

                {{-- Two-Column Layout --}}
                <div class="d-flex two-column">
                    <div class="left-col border-end pe-3" style="max-width:50%; min-height:659px; overflow-y:auto;">
                        <h5 class="fw-bold">Complaints</h5>
                        <p>{{ $doctor_notes->complaints }}</p>

                        <h5 class="fw-bold">History</h5>
                        <p>{{ $doctor_notes->history }}</p>

                        <h5 class="fw-bold">Investigations</h5>
                        <p>{{ $doctor_notes->investigations }}</p>

                        <h5 class="fw-bold">Remarks</h5>
                        <p>{{ $doctor_notes->remarks }}</p>
                    </div>
                    <div class="right-col ps-4 flex-fill">
                        <h1 class="fw-bold">℞</h1>
                        <div class="p-3" style="min-height:200px;">
                            {{ $doctor_notes->prescription_text }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Local Bootstrap & Print Styles --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body { background: #fff !important; font-size: 13px; }
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            @page { size: auto; margin: 15mm; }
        }
    </style>

    {{-- Print Script --}}
    <script>
        function printDiv(printableArea) {
            const printContents = document.getElementById(printableArea).innerHTML;
            const printWindow = window.open('', '', 'height=1500,width=2000');
            printWindow.document.write('<html><head><title>Doctor Notes</title>');
            printWindow.document.write('<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">');
            printWindow.document.write('<style>@media print {.no-print { display: none !important; }}</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(printContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</x-app-layout>
