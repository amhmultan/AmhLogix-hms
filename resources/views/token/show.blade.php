<x-app-layout>

@push('styles')
<style>
/* =========================
   FONTS
========================= */
@font-face {
    font-family: 'JameelNoori';
    src: url('/fonts/JameelNooriNastaleeq.woff2') format('woff2'),
         url('/fonts/JameelNooriNastaleeq.ttf') format('truetype');
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
    font-size: 12px;
    line-height: 1.4;
    color: rgb(0, 0, 0);
}

.footer-urdu-remarks-again {
    font-family: 'JameelNoori', 'Noto Nastaliq Urdu', serif;
    direction: rtl;
    font-size: 18px;
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
    border: 1px solid #ddd;
    padding: 8px;
    font-size: 14px;
    display: flex;
    flex-direction: column;
}

/* LEFT + RIGHT */
.left-col,
.right-col{
    width: 20%;
    border-radius: 4px;
    border: 2px solid #000000;
}

/* MIDDLE RX */
.middle-col{
    width: 60%;
    display: flex;
    flex-direction: column;
    min-height: 258mm;
}

/* RX */
.rx-header{
    font-size: 36px;
    font-weight: bold;
}

.rx-space{
    flex: 1;
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

    /* ✅ IMPORTANT FIX */
    .opd-writing-area{
        min-height: 190mm;
    }

    .opd-col{
        page-break-inside: avoid;
    }
}
</style>
@endpush

<!-- ACTION BUTTONS -->
<div class="container mt-3 text-center">

    <a href="{{ route('admin.tokens.index')}}" class="btn btn-info text-light">Back</a>

    <input class="btn btn-success text-light"
           type="button"
           onclick="printDiv('printableArea')"
           value="Print" />

</div>

<div class="container bg-white shadow-sm rounded mb-5 my-2 pb-3">

@can('Patient access')

<div id="printableArea" class="opd-page">

    <!-- HEADER -->
    <div class="row header-wrap align-items-center">

        <div class="col-sm-4 text-left">
            <h2 class="text-uppercase font-weight-bold mt-2" style="font-family: Arial Black;">
                {{ $hospital->title ?? '' }}
            </h2>
            <div>
                {{ $hospital->address ?? '' }} <br/>
                PHC REG. No. {{ $hospital->phc_no ?? '' }}
            </div>
        </div>

        <div class="col-sm-4 text-center">
            <span class="footer-urdu-remarks-again">ھوالشافی</span><br/>
            <img src="{{ asset('img/'.($hospital->logo ?? '')) }}" width="250px"
                 class="rounded mx-auto d-block"/>
        </div>

        <div class="col-sm-4 text-right">
            <p class="urdu-text">
                {{ $doctor->name ?? 'N/A' }}
            </p>
            <div>
                <pre>{{ $doctor->schedule ?? '' }}</pre>
                <span>PMDC No. {{ $doctor->pmdc ?? '' }}</span>
            </div>
        </div>

    </div>

    <div class="text-right mx-3 mb-2 mt-3">
        <strong>VCO Taken:</strong> ☐
    </div>

    <!-- PATIENT STRIP -->
    <div class="opd-strip">

        <div class="opd-block">
            <div class="opd-item"><strong>MR#</strong> {{ $patient->id ?? '' }}</div>
            <div class="opd-item"><strong>Name</strong> {{ $patient->name ?? 'N/A' }}</div>
            <div class="opd-item"><strong>Guardian</strong> {{ $patient->fname ?? '' }}</div>
            <div class="opd-item"><strong>Gender</strong> {{ $patient->gender ?? '' }}</div>
        </div>

        <div class="opd-block">
            <div class="opd-item"><strong>Age</strong> {{ $patient->age_detailed ?? '' }}</div>
            <div class="opd-item"><strong>Marital</strong> {{ $patient->marital_status ?? '' }}</div>
            <div class="opd-item"><strong>Phone</strong> {{ $patient->phone ?? '' }}</div>
            <div class="opd-item"><strong>CNIC</strong> {{ $patient->cnic ?? '' }}</div>
        </div>

        <div class="opd-block">
            <div class="opd-item">
                <strong>Address</strong>
                <span style="white-space: normal;">{{ $patient->address ?? '' }}</span>
            </div>
            <div class="opd-item">
                <strong>Date</strong>
                {{ optional($patient->created_at)->format('d-m-Y h:i A') ?? '' }}
            </div>
        </div>

    </div>

    <!-- WRITING AREA -->
    <div class="opd-writing-area">

        <!-- LEFT -->
        <div class="opd-col left-col">
            <div class="section-block">
                <strong>C/O:</strong><br>
                <strong class="ml-3">-VA</strong><br>
                <strong class="ml-3">-AT</strong><br>
                <strong class="ml-3">-mmHg</strong><br>
            </div>

            <div class="section-block">
                <strong>O/E:</strong><br>
                <strong class="ml-3">-Lids</strong><br>
                <strong class="ml-3">-Cornea</strong><br>
                <strong class="ml-3">-A/C</strong><br>
                <strong class="ml-3">-Lens</strong><br>
                <strong class="ml-3">-Fundus</strong>
            </div>
        </div>

        <!-- MIDDLE -->
        <div class="middle-col">

            <div class="rx-header">℞</div>

            <div class="rx-space"></div>

            <div class="rx-footer">
                <div class="signature-line">
                    ----------------------<br/>Doctor's Signature
                </div>
            </div>

        </div>

        <!-- RIGHT -->
        <div class="opd-col right-col">

            <div class="col-title">History</div>

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

    <!-- FOOTER -->
    <div class="footer">
        <div class="row">
            <div class="col-sm-6 text-left">
                <span class="footer-urdu-remarks">ٹائم لینے کے لئے صبح 9 بجے اس نمبر پر رابطہ کریں:</span> {{ $hospital->contact }}
            </div>
            <div class="col-sm-6 text-right">
                <span class="footer-urdu-remarks">(بروز جمعہ المبارک کلینک بند رہے گا)</span>
            </div>
        </div>
        <span class="footer-urdu-remarks-again">
            {{ $doctor->remarks ?? '' }}
        </span>
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