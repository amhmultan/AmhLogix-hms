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

            {{-- DISCHARGE SLIP Subheading --}}
            <div class="text-center fw-bold mb-2" style="font-size:14px;">DISCHARGE SLIP</div>

            {{-- Patient Info --}}
            <div class="fw-bold mb-1" style="font-size:13px;">Patient Information</div>
            <table class="table table-bordered w-100" style="font-size:12px; margin-bottom:5px;">
                <tbody>
                    <tr>
                        <th>MR No:</th>
                        <td>{{ $admission->patient->id }}</td>
                        <th>Patient Name:</th>
                        <td>{{ $admission->patient->name }}</td>
                        <th>Reffered By:</th>
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
                        <th>Discharge Date:</th>
                        <td>{{ $admission->discharge_date ? $admission->discharge_date->format('d-m-Y H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Diagnosis:</th>
                        <td colspan="3">{{ $admission->diagnosis ?? 'N/A' }}</td>
                        <th>Admission Fees:</th>
                        <td>{{ $admission->admission_fees ? number_format($admission->admission_fees, 2) : '0.00' }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- Discharge Summary --}}
            <div class="fw-bold mb-1" style="font-size:13px;">Discharge Summary</div>
            <table class="table table-bordered w-100" style="font-size:12px; margin-bottom:5px;">
                <tbody>
                    <tr>
                        <th>Clinical Notes</th>
                        <td>{{ $admission->dischargeSummary->clinical_notes ?? 'N/A' }}</td>
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

            {{-- Charges & Billing --}}
            <div class="fw-bold mb-1" style="font-size:13px;">Billing Information</div>
            <table class="table table-bordered w-100" style="font-size:12px;">
                <thead>
                    <tr>
                        <th>Particular</th>
                        <th class="text-end">Amount (PKR)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Admission Fees</td>
                        <td class="text-end">{{ number_format($admission->admission_fees ?? 0, 2) }}</td>
                    </tr>

                    <tr>
                        <td>Room Charges ({{ $totalDays }} day(s) × {{ number_format($admission->bed->rate_per_day ?? 0, 2) }})</td>
                        <td class="text-end">{{ number_format($roomAmount, 2) }}</td>
                    </tr>

                    @foreach($admission->charges as $charge)
                    <tr>
                        <td>{{ $charge->description }}</td>
                        <td class="text-end">{{ number_format($charge->amount, 2) }}</td>
                    </tr>
                    @endforeach

                    <tr>
                        <th>Total</th>
                        <th class="text-end">
                            {{ number_format(
                            ($admission->admission_fees ?? 0) +
                            $roomAmount +
                            $admission->charges->sum('amount'),
                            2
                        ) }}
                        </th>
                    </tr>

                </tbody>
            </table>

            {{-- Spacer --}}
            <div style="height:400px;"></div>

            {{-- Doctor Signature --}}
            <div class="text-end mt-2" style="font-size:12px;">
                <div>Doctor's Signature</div>
            </div>

        </div>
    </div>

    {{-- Print Script --}}
    <script>
        function printDiv(printableArea) {

            let content = document.getElementById(printableArea).innerHTML;

            let printWindow = window.open('', '_blank');

            let styles = '';

            document.querySelectorAll('link[rel="stylesheet"], style').forEach(el => {
                styles += el.outerHTML;
            });

            printWindow.document.write(`
                <html>
                <head>
                    <title>Discharge Slip</title>
                    ${styles}
                    <style>
                        @page {
                            size: A4 portrait;
                            margin: 10mm;
                        }
                    </style>
                </head>
                <body>
                    ${content}
                </body>
                </html>
            `);

            printWindow.document.close();

            printWindow.onload = function() {
                setTimeout(() => {
                    printWindow.print();
                }, 50);
            };

            printWindow.onafterprint = function() {
                printWindow.close();
            };
        }
    </script>
</x-app-layout>