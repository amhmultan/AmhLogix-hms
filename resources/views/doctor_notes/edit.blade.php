<x-app-layout>
<main>
<div class="container bg-white shadow-md rounded my-6 px-5 py-4">

    <div class="row pb-4">
        <h3 class="text-danger">
            <strong><em>Edit <span class="text-success">Doctor Notes</span></em></strong>
        </h3>
    </div>

    <form method="POST"
          action="{{ route('admin.doctor_notes.update', $doctor_notes->id) }}"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <!-- PATIENT INFO -->
        @if($doctor_notes->patient)
        <div class="card mb-4">
            <div class="card-header bg-light font-weight-bold">
                Patient Information
            </div>

            <div class="card-body">

                <div class="row py-2">
                    <div class="col-md-4">
                        <strong>MR No:</strong>
                        {{ $doctor_notes->patient->id }}
                    </div>

                    <div class="col-md-4">
                        <strong>Name:</strong>
                        {{ $doctor_notes->patient->name }}
                    </div>

                    <div class="col-md-4">
                        <strong>Referred By:</strong>
                        {{ $doctor_notes->patient->reffered_by }}
                    </div>
                </div>

                <div class="row py-2">
                    <div class="col-md-12">
                        <strong>Address:</strong>
                        {{ $doctor_notes->patient->address }}
                    </div>
                </div>

            </div>
        </div>
        @endif

        <!-- TOKEN INFO -->
        @if($doctor_notes->token)
        <div class="card mb-4">
            <div class="card-header bg-light font-weight-bold">
                Token Information
            </div>

            <div class="card-body">

                <div class="row py-2">

                    <div class="col-md-4">
                        <strong>Token No:</strong>
                        {{ $doctor_notes->token->token_id ?? $doctor_notes->token->id }}
                    </div>

                    <div class="col-md-4">
                        <strong>Date:</strong>
                        {{ $doctor_notes->token->created_at ?? '' }}
                    </div>

                </div>

            </div>
        </div>
        @endif

        <!-- HIDDEN IDS -->
        <input type="hidden"
               name="fk_patient_id"
               value="{{ $doctor_notes->fk_patient_id }}">

        <input type="hidden"
               name="fk_token_id"
               value="{{ $doctor_notes->fk_token_id }}">

        <!-- MODE -->
        <div class="form-group m-3">

            <label class="form-label text-dark font-weight-bold">
                Input Mode
            </label>
            <br>

            <label>
                <input type="radio"
                       name="mode"
                       value="upload"
                       {{ $doctor_notes->mode == 'upload' ? 'checked' : '' }}>
                Upload
            </label>

            <label class="ml-3">
                <input type="radio"
                       name="mode"
                       value="manual"
                       {{ $doctor_notes->mode == 'manual' ? 'checked' : '' }}>
                Manual
            </label>

        </div>

        <!-- UPLOAD SECTION -->
        <div id="uploadSection"
             class="form-group m-3"
             style="{{ $doctor_notes->mode == 'upload' ? '' : 'display:none;' }}">

            <label class="form-label text-dark font-weight-bold">
                Upload Prescription
            </label>

            @if($doctor_notes->prescription)
                <div class="mb-2">
                    <a href="{{ asset('assets/doctor_notes/'.$doctor_notes->prescription) }}"
                       target="_blank"
                       class="btn btn-sm btn-info">
                        View Current File
                    </a>
                </div>
            @endif

            <input type="file"
                   name="prescription"
                   class="form-control">

        </div>

        <!-- MANUAL SECTION -->
        <div id="manualSection"
             style="{{ $doctor_notes->mode == 'manual' ? '' : 'display:none;' }}">

            {{-- MANUAL PRESCRIPTION PARTIAL --}}
            @include('doctor_notes.partials.manual_prescription')

        </div>

        <!-- BUTTONS -->
        <div class="text-center mt-4">

            <a href="{{ route('admin.doctor_notes.index') }}"
               class="btn btn-warning mx-2">
                Back
            </a>

            <button type="submit"
                    class="btn btn-success mx-2">
                Update
            </button>

        </div>

    </form>

</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // =========================
    // MODE TOGGLE
    // =========================
    let radios = document.querySelectorAll('input[name="mode"]');

    if (radios.length > 0) {

        radios.forEach(radio => {

            radio.addEventListener('change', function () {

                let uploadSection =
                    document.getElementById('uploadSection');

                let manualSection =
                    document.getElementById('manualSection');

                if (uploadSection && manualSection) {

                    uploadSection.style.display =
                        this.value === 'upload'
                        ? 'block'
                        : 'none';

                    manualSection.style.display =
                        this.value === 'manual'
                        ? 'block'
                        : 'none';
                }

            });

        });

    }


    // =========================
    // SELECT2 INIT
    // =========================
    $('#prescription_products').select2({

        placeholder: "Search and select medicines",

        multiple: true,

        ajax: {

            url: "{{ route('admin.products.search') }}",

            dataType: 'json',

            delay: 250,

            data: function (params) {

                return {
                    term: params.term
                };

            },

            processResults: function (data) {

                return {
                    results: data.map(item => ({
                        id: item.id,
                        text: item.name
                    }))
                };

            },

            cache: true

        }

    });


    // =========================
    // OLD PRODUCTS PRELOAD
    // =========================
    let selectedProducts =
        @json($doctor_notes->prescription_products ?? []);

    console.log(selectedProducts);


    if (
        Array.isArray(selectedProducts) &&
        selectedProducts.length > 0
    ) {

        $.ajax({

            url: "{{ route('admin.products.search') }}",

            type: 'GET',

            dataType: 'json',

            data: {
                ids: selectedProducts.join(',')
            },

            success: function (products) {

                products.forEach(function (product) {

                    let option = new Option(
                        product.name,
                        product.id,
                        true,
                        true
                    );

                    $('#prescription_products')
                        .append(option)
                        .trigger('change');

                });

            },

            error: function (xhr) {

                console.log(xhr.responseText);

            }

        });

    }

});
</script>

</x-app-layout>