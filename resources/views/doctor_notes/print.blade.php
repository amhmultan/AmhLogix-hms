<x-app-layout>

@push('styles')
<style>

/* =========================
   FONT (URDU)
========================= */
@font-face {
    font-family: 'JameelNoori';
    src: url('/fonts/JameelNooriNastaleeq.woff2') format('woff2'),
         url('/fonts/JameelNooriNastaleeq.ttf') format('truetype');
}

.urdu-text {
    font-family: 'JameelNoori', 'Noto Nastaliq Urdu', serif;
    direction: rtl;
    font-size: 40px;
    line-height: 1.6;
    color: rgb(77, 6, 192);
}

/* =========================
   A4 PAGE
========================= */
.print-page{
    width: 210mm;
    min-height: 297mm;
    margin: auto;
    padding: 8mm;
    background: #fff;
    box-sizing: border-box;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    border-bottom:2px solid #000;
    padding-bottom:8px;
    margin-bottom:10px;
}

.header h2{
    font-weight:800;
    font-size:18px;
}

/* PATIENT STRIP */
.patient-box{
    display:flex;
    justify-content:space-between;
    border:1px solid #000;
    padding:8px;
    font-size:14px;
    margin-bottom:10px;
}

/* BODY */
.body-area{
    min-height:180mm;
    border:1px solid #ddd;
    padding:10px;
}

/* RX */
.rx{
    font-size:42px;
    font-weight:bold;
}

/* FOOTER */
.footer{
    position:absolute;
    bottom:10mm;
    left:8mm;
    right:8mm;
    border-top:1px solid #000;
    padding-top:6px;
    font-size:13px;
    text-align:center;
}

/* PRINT FIX */
@media print {
    @page { size: A4; margin: 10mm; }

    body{
        margin:0;
        -webkit-print-color-adjust: exact;
    }

    .no-print{
        display:none !important;
    }
}

</style>
@endpush


{{-- ACTION BUTTONS --}}
<div class="container mt-3 text-center no-print">
    <a href="{{ route('admin.doctor_notes.index') }}" class="btn btn-info">Back</a>

    <button onclick="printDiv('printArea')" class="btn btn-success">
        Print
    </button>
</div>


@php
    // =========================
    // SESSION DATA HANDLING
    // =========================
    $note = session('doctor_note'); 
    // expected structure from controller:
    // ['patient'=>..., 'doctor'=>..., 'prescription'=>..., 'remarks'=>...]

    $patient = $note['patient'] ?? null;
    $doctor = $note['doctor'] ?? null;
    $prescription = $note['prescription'] ?? null;
@endphp


<div id="printArea" class="print-page">

    {{-- HEADER --}}
    <div class="header">
        <div>
            <h2>{{ $doctor['name'] ?? 'Doctor Name' }}</h2>
            <div>{{ $doctor['qualification'] ?? '' }}</div>
        </div>

        <div class="text-right">
            <strong>Prescription</strong><br>
            {{ date('d-m-Y') }}
        </div>
    </div>


    {{-- PATIENT STRIP --}}
    <div class="patient-box">
        <div>
            <div><strong>MR#:</strong> {{ $patient['id'] ?? '' }}</div>
            <div><strong>Name:</strong> {{ $patient['name'] ?? '' }}</div>
            <div><strong>Father:</strong> {{ $patient['fname'] ?? '' }}</div>
        </div>

        <div>
            <div><strong>Age:</strong> {{ $patient['age'] ?? '' }}</div>
            <div><strong>Gender:</strong> {{ $patient['gender'] ?? '' }}</div>
            <div><strong>Phone:</strong> {{ $patient['phone'] ?? '' }}</div>
        </div>

        <div style="max-width:40%;">
            <strong>Address:</strong><br>
            {{ $patient['address'] ?? '' }}
        </div>
    </div>


    {{-- BODY --}}
    <div class="body-area">

        <div class="rx">℞</div>

        <div style="margin-top:10px; font-size:16px; line-height:2;">
            {!! nl2br(e($prescription ?? '')) !!}
        </div>

        <div style="margin-top:40px; text-align:right;">
            <strong>Doctor Signature</strong>
            <br><br>---------------------
        </div>

    </div>


    {{-- FOOTER --}}
    <div class="footer">
        {{ $note['remarks'] ?? 'Thank you for visiting' }}
    </div>

</div>


<script>
function printDiv(id){
    let content = document.getElementById(id).innerHTML;
    let original = document.body.innerHTML;

    document.body.innerHTML = content;
    window.print();
    document.body.innerHTML = original;
    location.reload();
}
</script>

</x-app-layout>