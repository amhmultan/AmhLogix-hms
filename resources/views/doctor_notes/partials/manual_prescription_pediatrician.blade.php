<hr />
<div class="rx-header">Rx</div>
<!-- PRODUCTS -->
<div id="prescriptionProductsSection" class="section-block">
    @include('doctor_notes.partials.prescription_products')
</div>
<div class="container">
    <div class="row">
        <!-- LEFT RX -->
        <div class="col-md-6">
            <!-- PRESCRIPTION TEXT -->
            <strong class="form-label mt-3">Notes:</strong>
            <textarea name="prescription_text"
                class="form-control"
                style="min-height: 500px;">{{ old('prescription_text', $doctorNote->prescription_text ?? '') }}</textarea>
        </div>
        <!-- RIGHT -->
        <div class="col-md-6">

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