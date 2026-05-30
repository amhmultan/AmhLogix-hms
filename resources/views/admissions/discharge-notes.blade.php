<x-app-layout>
    @push('styles')
    <style>
        /* =========================
   FONTS
========================= */
        @font-face {
            font-family: 'JameelNoori';
            src: url('{{ asset("fonts/JameelNooriNastaleeq.woff2") }}') format('woff2'),
            url('{{ asset("fonts/JameelNooriNastaleeq.ttf") }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        .urdu-text {
            font-family: 'JameelNoori', 'Noto Nastaliq Urdu', serif;
            direction: rtl;
            font-size: 50px;
            line-height: 1.6;
            margin-top: 10px;
            color: rgb(77, 6, 192);
        }

        .footer-urdu-remarks {
            font-family: 'JameelNoori', 'Noto Nastaliq Urdu', serif;
            direction: rtl;
            font-size: 18px;
            line-height: 1.4;
            color: rgb(0, 0, 0);
        }

        .footer-urdu-remarks-again {
            font-family: 'JameelNoori', 'Noto Nastaliq Urdu', serif;
            direction: rtl;
            font-size: 26px;
            line-height: 1.4;
            color: rgb(77, 6, 192);
        }

        #content-pre{
            font-family: 'Noto Nastaliq Urdu', serif;
            font-size: 18px;
            overflow: hidden;
        }

        #header-pre{
            font-family: 'Noto Nastaliq Urdu', serif;
            direction: rtl;
            font-size: 18px;
            line-height: 2.2;
            margin: 0;
            overflow: hidden;
            margin-top: 10px;
            border: 0;
        }

        /* =========================
   A4 PAGE WRAPPER
========================= */
        .opd-page {
            position: relative;
            width: 210mm;
            min-height: auto;
            height: auto;
            margin: 0 auto;
            padding: 6mm;
            padding-bottom: 30mm;
            /* ✅ reserve footer space */
            background: #fff;
            box-sizing: border-box;
            page-break-after: avoid;
        }

        /* =========================
   HEADER STRIP
========================= */
        .opd-strip {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            padding: 6px 10px;
            border: 2px solid #000;
            border-radius: 4px;
            font-size: 12.5px;
            line-height: 1.5;
            background: #fff;
            margin-top: 10px;
        }

        .opd-block {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
            border-right: 1px solid #ddd;
            padding-right: 10px;
        }

        .opd-block:last-child {
            border-right: none;
        }

        .opd-item {
            display: flex;
            gap: 6px;
            white-space: nowrap;
        }

        .opd-item strong {
            min-width: 70px;
            font-weight: 800;
            color: #222;
        }

        /* =========================
   WRITING AREA
========================= */
        .opd-writing-area {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            min-height: auto;
        }

        /* =========================
       CONTAINER FIX
    ========================= */
        .table-responsive {
            border: 1px solid #000 !important;
            border-radius: 5px;
            width: 100% !important;
            display: block !important;
            overflow: visible !important;
            page-break-inside: avoid;
            margin-bottom: 10px;
        }

        /* =========================
       TABLE FIX
    ========================= */
        .eye-table {
            width: 100% !important;
            max-width: 100% !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            /* IMPORTANT */
            margin: 0 !important;
        }

        /* =========================
       CELLS FIX
    ========================= */
        .eye-table th,
        .eye-table td {
            border: 1px solid #000 !important;
            padding: 6px !important;
            text-align: center !important;
            vertical-align: middle !important;
            font-size: 14px !important;
            word-wrap: break-word;
        }

        /* =========================
       HEADER FIX
    ========================= */
        .eye-table thead th {
            font-weight: bold;
            background: #f2f2f2 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            border: 1px solid #000 !important;
        }

        /* =========================
       ROW HEIGHT CONTROL
    ========================= */
        .eye-table tbody td {
            height: auto !important;
        }

        /* =========================
       REMOVE SCROLL BEHAVIOR
    ========================= */
        html,
        body {
            overflow: visible !important;
            height: auto !important;
        }

        /* Base columns */
        .opd-col {
            /* border: 1px solid #ddd; */
            padding: 8px;
            font-size: 16px;
            display: flex;
            flex-direction: column;
        }

        /* LEFT + RIGHT */
        .left-col {
            width: 80%;
            /* border-radius: 4px;
            border: 2px solid #000000; */
        }

        .right-col {
            width: 20%;
            text-align: right;
            /* border-radius: 4px;
            border: 2px solid #000000; */
            min-height: 170mm
                /* 297mm total - 20mm top/bottom padding - 30mm footer - 50mm header = 197mm writing space */
            ;
        }

        /* RX */
        .rx-header {
            font-size: 16px;
            font-weight: bold;
        }

        .rx-space {
            font-size: 16px;
            font-family: 'Noto Nastaliq Urdu', serif;
            padding-top: 20px;
            padding-left: 60px;
            line-height: 1.5;
        }

        #refractionSection {
            position: absolute;
            right: 6mm;
            bottom: 26mm;
            width: 50%;
            max-width: 120mm;
            box-sizing: border-box;
        }

        .rx-footer {
            margin-top: auto;
            padding-top: 5px;
            text-align: right;
        }

        .signature-line {
            font-size: 13px;
            font-weight: 800;
        }

        /* SIDE CONTENT */
        .col-title {
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            text-align: right;
            padding-bottom: 5px;
        }

        .section-block {
            margin-bottom: 8px;
            font-size: 16px;
        }

        .section-detail {
            margin-bottom: 40px;
            display: block;
        }

        .line-space {
            border-bottom: 1px dotted #bbb;
            height: 18px;
            margin-top: 2px;
        }

        /* HEADER */
        .header-item {
            margin-bottom: 10px;
            font-size: 36px;
        }

        .header-item-details {
            font-size: 36px;
            line-height: 1.4;
        }

        .header-wrap {
            font-size: 14px;
        }

        /* =========================
        FOOTER (FIXED & SAFE)
        ========================= */
        .footer {
            position: absolute;
            bottom: 10mm;
            left: 6mm;
            right: 6mm;
            font-size: 14px;
            border-top: 1px solid #000;
            padding-top: 6px;
            text-align: center;
        }

        /* =========================
        PRINT SETTINGS
        ========================= */
        @media print {

            @page {
                size: A4 portrait;
                margin: 10mm;
            }

            html,
            body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            body {
                font-size: 16px;
                line-height: 1.3;
            }

            .header-wrap {
                font-size: 16px;
            }

            .urdu-text {
                font-size: 50px;
            }

            .footer-urdu-remarks {
                font-size: 20px;
            }

            .footer-urdu-remarks-again {
                font-size: 26px;
                line-height: 1.4;
                color: rgb(77, 6, 192);
            }

            .opd-page {
                width: 100%;
                min-height: auto;
                padding: 0;
                padding-bottom: 20mm;
                max-height: calc(297mm - 20mm);
                box-sizing: border-box;
            }

            .opd-strip {
                font-size: 12px;
                padding: 4px 6px;
                margin-top: 10px;
            }

            .opd-col {
                font-size: 14px;
                page-break-inside: avoid;
            }

            /* LEFT + RIGHT */
            .left-col {
                width: 80%;
                /* border-radius: 4px;
            border: 2px solid #000000; */
            }

            .right-col {
                width: 20%;
                text-align: right;
                /* border-radius: 4px;
                border: 2px solid #000000; */
                min-height: 160mm
                    /* 297mm total - 20mm top/bottom padding - 30mm footer - 50mm header = 197mm writing space */
                ;
            }

            .rx-header {
                font-size: 18px;
            }

            .rx-space {
                font-size: 14px;
                padding-top: 15px;
                padding-left: 40px;
            }

            .line-space {
                height: 14px;
            }

            .section-block {
                margin-bottom: 4px;
            }

            .section-detail {
                margin-bottom: 20px;
            }

            .footer {
                bottom: 5mm;
                font-size: 12px;
                padding-top: 4px;
            }

            /* Remove forced minimum height to prevent extra page breaks */
            .opd-writing-area {
                min-height: auto;
            }

            #refractionSection {
                position: absolute;
                right: 6mm;
                bottom: 21mm;
                width: 50%;
                max-width: 120mm;
                box-sizing: border-box;
            }
        }
    </style>
    @endpush



    {{-- Action Buttons --}}
    <div class="row my-3 text-center">
        <div class="col-sm-12">
            <a href="{{ route('admin.admissions.index') }}" class="btn btn-info text-light mx-2"><u>B</u>ack</a>
            <button class="btn btn-success text-light mx-2" onclick="printDiv('printableArea')" accesskey="p">Print</button>
        </div>
    </div>

    <div class="container opd-page" id="printableArea">

        <!-- HOSPITAL HEADER -->
        @if($hospital ?? false)
        <div class="row header-wrap align-items-center">

            <div class="col-sm-4 text-left">
                <h2 class="text-uppercase font-weight-bold mt-2" style="font-family: Arial Black;">
                    {{ $hospital->title }}
                </h2>
                <div>
                    {{ $hospital->address }} <br />
                    PHC REG. No. {{ $hospital->phc_no }}
                </div>
            </div>

            <div class="col-sm-4 text-center">
                <span class="footer-urdu-remarks-again">ھوالشافی</span><br />
                <img src="{{ asset('img/'.$hospital->logo) }}" width="250px" alt="Hospital Logo" class="rounded mx-auto d-block" />
            </div>

            <div class="col-sm-4 text-right">
                <p class="urdu-text">
                    {{ $doctor->name }}
                </p>
                <div>
                    <pre id="header-pre">{{ $doctor->schedule }}</pre>
                    <span style="margin-top: 5px; display: block;">PMDC No. {{ $doctor->pmdc }}</span>
                </div>
            </div>

        </div>

        <div class="text-right my-2">
            <strong class="">VCO Taken:</strong> <span class="h2 align-middle mx-2">☐</span>
        </div>
        @endif

        {{-- Patient Info --}}
        <div class="opd-strip">
            <div class="opd-block">
                <div class="opd-item"><strong>MR#</strong> {{ $admission->patient->id }}</div>
                <div class="opd-item"><strong>Patient Name:</strong> {{ $admission->patient->name }}</div>
                <div class="opd-item"><strong>Reffered By:</strong> {{ $admission->patient->reffered_by ?? '-' }}</div>
                <div class="opd-item"><strong>Gender:</strong> {{ $admission->patient->gender ?? '-' }}</div>
            </div>
            <div class="opd-block">
                <div class="opd-item"><strong>Contact:</strong> {{ $admission->patient->phone ?? '-' }}</div>
                <div class="opd-item"><strong>CNIC:</strong> {{ $admission->patient->cnic ?? '-' }}</div>
                <div class="opd-item"><strong>Doctor:</strong> {{ $admission->doctor->name ?? '-' }}</div>
                <div class="opd-item"><strong>Ward / Bed:</strong> {{ ucfirst($admission->bed->ward->name ?? '-') }} / {{ $admission->bed->bed_number ?? '-' }}</div>
            </div>
            <div class="opd-block">
                <div class="opd-item"><strong>Admission On:</strong> {{ $admission->admission_date->format('d-m-Y H:i') }}</div>
                <div class="opd-item"><strong>Discharge On:</strong> {{ $admission->discharge_date ? $admission->discharge_date->format('d-m-Y H:i') : '-' }}</div>
                <div class="opd-item"><strong>Diagnosis:</strong>{{ $admission->diagnosis ?? 'N/A' }}</div>
            </div>
        </div>

        {{-- DISCHARGE NOTES Subheading --}}
        <h5 style="font-family: 'Times New Roman', serif; text-decoration: underline;" class="text-center fw-bold my-3">DISCHARGE NOTES</h5>
        <div class="opd-writing-area">
            <!-- LEFT -->
            <div class="opd-col left-col">
                <pre class="text-left mb-5" id="content-pre">{{ $admission->dischargeSummary->clinical_notes ?? 'N/A' }}</pre>
                <div class="rx-header">Follow-up Instructions:</div>{{ $admission->dischargeSummary->follow_up ?? 'N/A' }}
                <div class="rx-header">Rx</div>{{ $admission->dischargeSummary->medications ?? 'N/A' }}

            </div>
            <!-- RIGHT -->
            <div class="opd-col right-col">
                <h6 class="fw-bold">(History)</h6>

                <div class="section-block">
                    <strong>DM:</strong><br/>
                    {{ $admission->dischargeSummary->dm ?? ' - ' }}
                </div>

                <div class="section-block">
                    <strong>HTN:</strong><br/>
                    {{ $admission->dischargeSummary->htn ?? ' - ' }}
                </div>

                <div class="section-block">
                    <strong>IHD:</strong><br/>
                    {{ $admission->dischargeSummary->ihd ?? ' - ' }}
                </div>

                <div class="section-block">
                    <strong>Asthma:</strong><br/>
                    {{ $admission->dischargeSummary->asthma ?? ' - ' }}
                </div>
            </div>
        </div>

        <!-- DOCTOR SIGNATURE INSIDE RX -->
        <div class="rx-footer">
            <div class="signature-line">----------------------<br />Doctor's Signature</div>
        </div>
        <!-- MAIN FOOTER  -->
        <div class="footer">
            <div class="row">
                <div class="col-sm-6 text-left">
                    <span class="footer-urdu-remarks">ٹائم لینے کے لئے صبح 9 بجے اس نمبر پر رابطہ کریں:</span> <strong>{{ $hospital->contact }}</strong>
                </div>
                <div class="col-sm-6 text-right">
                    <span class="footer-urdu-remarks">(بروزجمعۃالمبارک کلینک بندرہےگا)</span>
                </div>
            </div>
            <span class="footer-urdu-remarks-again">{{ $doctor->remarks  ?? 'N/A' }}</span>
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
                    <title>Discharge Notes</title>
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