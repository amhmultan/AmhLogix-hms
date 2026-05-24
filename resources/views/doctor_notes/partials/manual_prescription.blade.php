@push('styles')
<style>

    /* =========================
    WRITING AREA
    ========================= */

    .opd-writing-area{
        display: flex;
        gap: 10px;
        margin-top: 10px;
        min-height: 180mm;
        flex-wrap: wrap;
    }

    /* =========================
    COMMON COLUMN
    ========================= */

    .opd-col{
        padding: 8px;
        font-size: 14px;
        display: flex;
        flex-direction: column;
    }

    /* =========================
    LEFT + RIGHT
    ========================= */

    .left-col,
    .right-col{
        width: 20%;
    }

    /* =========================
    MIDDLE RX
    ========================= */

    .middle-col{
        width: 58%;
        display: flex;
        flex-direction: column;
        min-height: 258mm;
    }

    /* =========================
    RX HEADER
    ========================= */

    .rx-header{
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    /* =========================
    FORM ELEMENTS
    ========================= */

    .section-block{
        margin-bottom: 15px;
    }

    .section-block strong{
        display: block;
        margin-top: 8px;
        margin-bottom: 3px;
        color: #000;
    }

    .section-block textarea{
        resize: vertical;
        min-height: 55px;
    }

    #refractionSection{
        margin-top: 15px;
        
    }

    /* =========================
    MOBILE RESPONSIVE
    ========================= */

    @media(max-width: 992px){

        .left-col,
        .middle-col,
        .right-col{
            width: 100%;
        }

        .middle-col{
            min-height: auto;
        }

    }

</style>
@endpush

<hr/>

<div class="opd-writing-area">

    <!-- LEFT -->
    <div class="opd-col left-col">

        <div class="section-block">

            <strong>C/O:</strong>
            <textarea name="c_o" class="form-control">{{ old('c_o', $doctorNote->c_o ?? '') }}</textarea>

            <strong>O/E:</strong>
            <textarea name="o_e" class="form-control">{{ old('o_e', $doctorNote->o_e ?? '') }}</textarea>

            <strong>VA:</strong>
            <input type="text" name="va" class="form-control"
                   value="{{ old('va', $doctorNote->va ?? '') }}">

            <strong>AT:</strong>
            <input type="text" name="at" class="form-control"
                   value="{{ old('at', $doctorNote->at ?? '') }}">

        </div>

        <div class="section-block">

            <strong>Lids</strong>
            <textarea name="lids" class="form-control">{{ old('lids', $doctorNote->lids ?? '') }}</textarea>

            <strong>Conjunctiva</strong>
            <textarea name="conjunctiva" class="form-control">{{ old('conjunctiva', $doctorNote->conjunctiva ?? '') }}</textarea>

            <strong>Cornea</strong>
            <textarea name="cornea" class="form-control">{{ old('cornea', $doctorNote->cornea ?? '') }}</textarea>

            <strong>A/C</strong>
            <textarea name="ac" class="form-control">{{ old('ac', $doctorNote->ac ?? '') }}</textarea>

            <strong>Lens</strong>
            <textarea name="lens" class="form-control">{{ old('lens', $doctorNote->lens ?? '') }}</textarea>

            <strong>Fundus</strong>
            <textarea name="fundus" class="form-control">{{ old('fundus', $doctorNote->fundus ?? '') }}</textarea>

        </div>

    </div>

    <!-- MIDDLE RX -->
    <div class="opd-col middle-col">

        <div class="rx-header">Rx</div>

        <!-- PRODUCTS -->
        <div id="prescriptionProductsSection" class="section-block">
            @include('doctor_notes.partials.prescription_products')
        </div>

        <!-- PRESCRIPTION TEXT -->
        <textarea name="prescription_text"
                  class="form-control flex-grow-1 mt-4"
                  style="min-height:150px;">{{ old('prescription_text', $doctorNote->prescription_text ?? '') }}</textarea>

        <div id="refractionSection" class="section-block">
            @include('doctor_notes.partials.refraction_card')
        </div>

    </div>

    <!-- RIGHT -->
    <div class="opd-col right-col">

        <div class="section-block">

            <strong>DM</strong>
            <input type="text" name="dm" class="form-control"
                   value="{{ old('dm', $doctorNote->dm ?? '') }}">

            <strong>HTN</strong>
            <input type="text" name="htn" class="form-control"
                   value="{{ old('htn', $doctorNote->htn ?? '') }}">

            <strong>IHD</strong>
            <input type="text" name="ihd" class="form-control"
                   value="{{ old('ihd', $doctorNote->ihd ?? '') }}">

            <strong>Asthma</strong>
            <input type="text" name="asthma" class="form-control"
                   value="{{ old('asthma', $doctorNote->asthma ?? '') }}">

        </div>

    </div>

</div>