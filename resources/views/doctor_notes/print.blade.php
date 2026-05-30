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

        pre {
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
            font-size: 14px;
            display: flex;
            flex-direction: column;
        }

        /* LEFT + RIGHT */
        .left-col {
            width: 20%;
            /* border-radius: 4px;
    border: 2px solid #000000; */
        }

        .right-col {
            width: 20%;
            text-align: right;
            /* border-radius: 4px;
    border: 2px solid #000000; */
        }

        /* MIDDLE RX */
        .middle-col {
            width: 60%;
            display: flex;
            flex-direction: column;
            min-height: 197mm
                /* 297mm total - 20mm top/bottom padding - 30mm footer - 50mm header = 197mm writing space */
            ;
        }

        /* RX */
        .rx-header {
            font-size: 36px;
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

            .rx-header {
                font-size: 30px;
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

    <!-- ACTION BUTTONS -->
    <div class="container mt-3 text-center">

        <a href="{{ route('admin.doctor_notes.index') }}" class="btn btn-info text-light">Back</a>

        <input class="btn btn-success text-light"
            type="button"
            onclick="printDiv('printableArea')"
            value="Print" />

        @can('Patient edit')
        <a href="{{ route('admin.doctor_notes.edit', $note->id) }}" class="btn btn-warning">
            Edit
        </a>
        @endcan

    </div>
    <div class="container bg-white shadow-sm rounded mb-5 my-2 pb-3">

        @can('Patient access')

        <!-- A4 WRAPPER -->
        <div id="printableArea" class="opd-page">

            <!-- HEADER -->
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
                        {{ $doctor->name ?? 'N/A' }}
                    </p>
                    <div>
                        <pre>{{ $doctor->schedule ?? 'N/A' }}</pre>
                        <span style="margin-top: 5px; display: block;">PMDC No. {{ $doctor->pmdc  ?? 'N/A' }}</span>
                    </div>
                </div>

            </div>


            <div class="text-right my-2">
                <strong class="">VCO Taken:</strong> <span class="h2 align-middle mx-2">☐</span>
            </div>

            <!-- PATIENT STRIP -->
            <div class="opd-strip">

                <div class="opd-block">
                    <div class="opd-item"><strong>MR#</strong> {{ $patient->id }}</div>
                    <div class="opd-item"><strong>Name</strong> {{ $patient->name }}</div>
                    <div class="opd-item"><strong>Guardian</strong> {{ $patient->fname }}</div>
                    <div class="opd-item"><strong>Gender</strong> {{ $patient->gender }}</div>
                </div>

                <div class="opd-block">
                    <div class="opd-item"><strong>Age</strong> {{ $patient->age_detailed }}</div>
                    <div class="opd-item"><strong>Marital</strong> {{ $patient->marital_status }}</div>
                    <div class="opd-item"><strong>Phone</strong> {{ $patient->phone }}</div>
                    <div class="opd-item"><strong>CNIC</strong> {{ $patient->cnic }}</div>
                </div>

                <div class="opd-block">
                    <div class="opd-item">
                        <strong>Address</strong>
                        <span style="white-space: normal;">{{ $patient->address }}</span>
                    </div>
                    <div class="opd-item">
                        <strong>Date</strong>
                        {{ optional($patient->created_at)->format('d-m-Y h:i A') }}
                    </div>
                </div>

            </div>

            <!-- WRITING AREA -->
            <div class="opd-writing-area">

                <!-- LEFT -->
                <div class="opd-col left-col">

                    <div class="section-block">
                        <strong>C/O:</strong>
                        <div class="section-detail">
                            {{ $note->c_o ?? '-' }}
                        </div>
                    </div>

                    <div class="section-block">
                        <strong>O/E:</strong>
                        <div class="section-detail">
                            {{ $note->o_e ?? '-' }}
                        </div>
                    </div>

                    <div class="section-block">
                        <strong>VA:</strong>
                        <div class="section-detail">
                            {{ $note->va ?? '-' }}
                        </div>
                    </div>

                    <div class="section-block">
                        <strong>AT:</strong>
                        <div class="section-detail">
                            {{ $note->at ?? '-' }}
                        </div>
                    </div>

                    <div class="section-block">
                        <strong>Lids:</strong>
                        <div class="section-detail">
                            {{ $note->lids ?? '-' }}
                        </div>
                    </div>

                    <div class="section-block">
                        <strong>Conjunctiva:</strong>
                        <div class="section-detail">
                            {{ $note->conjunctiva ?? '-' }}
                        </div>
                    </div>

                    <div class="section-block">
                        <strong>Cornea:</strong>
                        <div class="section-detail">
                            {{ $note->cornea ?? '-' }}
                        </div>
                    </div>

                    <div class="section-block">
                        <strong>AC:</strong>
                        <div class="section-detail">
                            {{ $note->ac ?? '-' }}
                        </div>
                    </div>

                    <div class="section-block">
                        <strong>Lens:</strong>
                        <div class="section-detail">
                            {{ $note->lens ?? '-' }}
                        </div>
                    </div>

                    <div class="section-block">
                        <strong>Fundus:</strong>
                        <div class="section-detail">
                            {{ $note->fundus ?? '-' }}
                        </div>
                    </div>

                </div>

                <!-- MIDDLE RX -->
                <div class="middle-col" style="min-width:0;">

                    <div class="rx-space">

                        {{-- =========================
                            PRESCRIPTION TEXT
                        ========================= --}}
                        @if(!empty($note->prescription_text))
                        {!! nl2br(e($note->prescription_text)) !!}
                        <br><br>
                        @endif


                                    {{-- =========================
                            PRESCRIPTION PRODUCTS
                        ========================= --}}

                        @if($items->count())

                        @foreach($items as $item)

                        <div class="my-1">

                            <strong>
                                {{ $loop->iteration }}. {{ $item['name'] ?? 'Unknown Product' }}
                            </strong>

                            <br>

                            <span style="display: inline-block; margin-top: 8px;">

                                @if(!empty($item['dosage']))
                                <span dir="ltr" style="unicode-bidi: plaintext;">
                                    {{ $item['dosage'] }}
                                </span>
                                &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
                                @endif

                                @if(!empty($item['duration']))
                                <span dir="ltr" style="unicode-bidi: plaintext;">
                                    {{ $item['duration'] }}
                                </span>
                                &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
                                @endif

                                @if(!empty($item['remarks']))
                                <span dir="auto" style="unicode-bidi: plaintext;">
                                    {{ $item['remarks'] }}
                                </span>
                                @endif

                            </span>

                        </div>

                        @endforeach

                        @endif

                    </div>
                </div>



                <!-- RIGHT -->
                <div class="opd-col right-col">

                    <div class="h6 col-title">History</div>

                    <div class="section-block">
                        <strong>DM:</strong>
                        <div class="section-detail">
                            {{ $note->dm ?? '-' }}
                        </div>
                    </div>

                    <div class="section-block">
                        <strong>HTN:</strong>
                        <div class="section-detail">
                            {{ $note->htn ?? '-' }}
                        </div>
                    </div>

                    <div class="section-block">
                        <strong>IHD:</strong>
                        <div class="section-detail">
                            {{ $note->ihd ?? '-' }}
                        </div>
                    </div>

                    <div class="section-block">
                        <strong>Asthma:</strong>
                        <div class="section-detail">
                            {{ $note->asthma ?? '-' }}
                        </div>
                    </div>

                    <div id="refractionSection" class="section-block">
                        <div class="table-responsive">
                            <table class="table mb-0 eye-table">
                                <thead>
                                    <tr>
                                        <th colspan="4">Right Eye (OD)</th>
                                        <th colspan="4">Left Eye (OS)</th>
                                    </tr>
                                    <tr>
                                        <th>SPH</th>
                                        <th>CYL</th>
                                        <th>AXIS</th>
                                        <th>VA</th>

                                        <th>SPH</th>
                                        <th>CYL</th>
                                        <th>AXIS</th>
                                        <th>VA</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>
                                            {{ $note->right_sph ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $note->right_cyl ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $note->right_axis ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $note->right_va ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $note->left_sph ?? '-' }}
                                        <td>
                                            {{ $note->left_cyl ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $note->left_axis ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $note->left_va ?? '-' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="3">
                                            {{ $note->right_add ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $note->right_pd ?? '-' }}
                                        </td>
                                        <td colspan="3">
                                            {{ $note->left_add ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $note->left_pd ?? '-' }}
                                        </td>
                                    </tr>

                                    <!-- <tr>
                                        <td colspan="4">
                                            {{ $note->right_remarks ?? '-' }}
                                        </td>
                                        <td colspan="4">
                                            {{ $note->left_remarks ?? '-' }}
                                        </td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
            
        </div>

        @endcan
    </div>

    <!-- PRINT SCRIPT -->
    <script>
        function printDiv(divName) {
            let printContents = document.getElementById(divName).innerHTML;
            let originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>

</x-app-layout>