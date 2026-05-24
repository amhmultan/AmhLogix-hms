<!DOCTYPE html>
<html lang="en">

<head>

    <title>Patient OPD Print - {{ $patient->name }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu&display=swap" rel="stylesheet">


    <style>
    /* =========================
    FONTS
    ========================= */
    @font-face {
        font-family: 'JameelNoori', 'Noto Nastaliq Urdu', serif;
        src: url("{{ asset('fonts/JameelNooriNastaleeq.ttf') }}") format('truetype'),
            url("{{ asset('fonts/NotoNastaliqUrdu-Regular.ttf') }}") format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    .urdu-text {
        font-family: 'JameelNoori', 'Noto Nastaliq Urdu', serif;
        direction: rtl;
        font-size: 40px;
        line-height: 1.6;
        margin-top: 10px;
        color: rgb(77, 6, 192);
    }

    .footer-urdu-remarks {
        font-family: 'JameelNoori', 'Noto Nastaliq Urdu', serif;
        direction: rtl;
        font-size: 14px;
        line-height: 1.4;
        color: rgb(0, 0, 0);
    }

    .footer-urdu-remarks-again {
        font-family: 'JameelNoori', 'Noto Nastaliq Urdu', serif;
        direction: rtl;
        font-size: 20px;
        line-height: 1.4;
        color: rgb(77, 6, 192);
    }

    pre{
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
    .opd-page{
        position: relative;
        width: 210mm;
        min-height: 297mm;
        margin: 0 auto;
        padding: 6mm;
        padding-bottom: 30mm; /* ✅ reserve footer space */
        background: #fff;
        box-sizing: border-box;
    }

    /* =========================
    HEADER STRIP
    ========================= */
    .opd-strip{
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

    .opd-block{
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 2px;
        border-right: 1px solid #ddd;
        padding-right: 10px;
    }

    .opd-block:last-child{
        border-right: none;
    }

    .opd-item{
        display: flex;
        gap: 6px;
        white-space: nowrap;
    }

    .opd-item strong{
        min-width: 70px;
        font-weight: 800;
        color: #222;
    }

    /* =========================
    WRITING AREA
    ========================= */
    .opd-writing-area{
        display: flex;
        gap: 10px;
        margin-top: 10px;

        /* ✅ FIXED HEIGHT (balanced) */
        min-height: 180mm;
    }

    /* Base columns */
    .opd-col{
        /* border: 1px solid #ddd; */
        padding: 8px;
        font-size: 14px;
        display: flex;
        flex-direction: column;
    }

    /* LEFT + RIGHT */
    .left-col,
    .right-col{
        width: 20%;
        /* border-radius: 4px;
        border: 2px solid #000000; */
    }

    /* MIDDLE RX */
    .middle-col{
        width: 60%;
        display: flex;
        flex-direction: column;
        min-height: 247mm;
    }

    /* RX */
    .rx-header{
        font-size: 36px;
        font-weight: bold;
    }

    .rx-space{
        flex: 1;
    }

    #refractionSection {
        position: absolute;
        right: 6mm;
        bottom: 28mm;
        width: 50%;
        max-width: 120mm;
        box-sizing: border-box;
    }

    .rx-footer{
        margin-top: auto;
        padding-top: 5px;
        text-align: right;
    }

    .signature-line{
        font-size: 13px;
        font-weight: 800;
    }

    /* SIDE CONTENT */
    .col-title{
        font-weight: 900;
        text-decoration: underline;
        text-align: center;
        margin-bottom: 15px;
        padding-bottom: 5px;
    }

    .section-block{
        margin-bottom: 8px;
        font-size: 16px;
    }

    .section-detail{
        margin-bottom: 40px;
        display: block;
    }

    .line-space{
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

        html, body{
            width: 210mm;
            height: 297mm;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        body{
            font-size: 18px;
            line-height: 1.4;
        }

        .header-wrap {
            font-size: 18px;
        }

        .opd-page{
            width: 100%;
            min-height: 100%;
            padding: 0;
            padding-bottom: 30mm; /* ✅ keep footer space */
        }

        .opd-strip{
            font-size: 14px;
            padding: 6px 8px;
            margin-top: 12px;
        }

        .opd-col{
            font-size: 18px;
        }

        .rx-header{
            font-size: 34px;
        }

        .line-space{
            height: 16px;
        }

        .opd-writing-area{
            min-height: 220mm;
        }

        .opd-col{
            page-break-inside: avoid;
        }
    }

    </style>
</head>

<body>
    
    <div class="container bg-white shadow-sm rounded mb-5 my-2 pb-3">

        @can('Patient access')

            <!-- A4 WRAPPER -->
            <div id="printableArea" class="opd-page">

                <!-- HEADER -->
                <div class="row header-wrap align-items-center">

                    <div class="col-sm-4 text-left">
                        <h2 class="text-uppercase font-weight-bold mt-2" style="font-family: Arial Black;">
                            {{ $hospitals->title }}
                        </h2>
                    <div>
                            {{ $hospitals->address }} <br/>
                            PHC REG. No. {{ $hospitals->phc_no }}
                    </div>
                    </div>

                    <div class="col-sm-4 text-center">
                        <span class="footer-urdu-remarks-again">ھوالشافی</span><br/>
                        <img src="{{ asset('img/'.$hospitals->logo) }}" width="250px" alt="Hospital Logo" class="rounded mx-auto d-block"/>
                    </div>

                    <div class="col-sm-4 text-right">
                        <p class="urdu-text">
                            {{ $doctors->name }}
                        </p>
                        <div>
                            <pre>{{ $doctors->schedule }}</pre>
                            <span style="margin-top: 5px; display: block;">PMDC No. {{ $doctors->pmdc }}</span>
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
                            <strong class="section-detail">C/O:</strong><br>
                            <strong class="section-detail">O/E:</strong><br>
                            <strong class="section-detail">VAく</strong><br>
                            <strong class="section-detail">ATく</strong><br>
                        </div>

                        <div class="section-block">
                            <strong class="section-detail">Lids</strong><br>
                            <strong class="section-detail">Conjunctiva</strong><br>
                            <strong class="section-detail">Cornea</strong><br>
                            <strong class="section-detail">A/C</strong><br>
                            <strong class="section-detail">Lens</strong><br>
                            <strong class="section-detail">Fundus</strong>
                        </div>
                    </div>

                    <!-- MIDDLE RX -->
                    <div class="middle-col">

                        <!-- <div class="rx-header">℞</div> -->

                        <div class="rx-space"></div>

                        <div id="refractionSection">
                            @include('patient.partials.refraction_card')
                        </div>

                        <!-- DOCTOR SIGNATURE INSIDE RX -->
                        <!-- <div class="rx-footer">
                            <div class="signature-line">----------------------<br/>Doctor's Signature</div>
                        </div> -->

                    </div>

                    <!-- RIGHT -->
                    <div class="opd-col right-col">

                        <div class="h6 col-title">History</div>

                        <div class="section-block">
                            <strong>DM:</strong>
                            <div class="line-space"></div>
                        </div>

                        <div class="section-block">
                            <strong>HTN:</strong>
                            <div class="line-space"></div>
                        </div>

                        <div class="section-block">
                            <strong>IHD:</strong>
                            <div class="line-space"></div>
                        </div>

                        <div class="section-block">
                            <strong>Asthma:</strong>
                            <div class="line-space"></div>
                        </div>
                                                
                    </div>
                    
                </div>
                    <!-- MAIN FOOTER  -->
                    <div class="footer">
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <span class="footer-urdu-remarks">ٹائم لینے کے لئے صبح 9 بجے اس نمبر پر رابطہ کریں:</span> {{ $hospitals->contact }}
                            </div>
                            <div class="col-sm-6 text-right">
                                <span class="footer-urdu-remarks">(بروزجمعۃالمبارک کلینک بندرہےگا)</span>
                            </div>
                        </div>
                        <span class="footer-urdu-remarks-again">{{ $doctors->remarks }}</span>
                    </div>
            </div>
        @endcan
    </div>

    <!-- PRINT SCRIPT -->
    <script>
        function triggerPrintAndClose() {

            // Open print dialog
            window.print();
        }

        window.onload = function () {

            setTimeout(function () {
                triggerPrintAndClose();
            }, 500);
        };

        // This fires after user prints OR cancels print dialog
        window.onafterprint = function () {

            setTimeout(function () {
                window.close();
            }, 200);
        };
    </script>
</body>
</html>