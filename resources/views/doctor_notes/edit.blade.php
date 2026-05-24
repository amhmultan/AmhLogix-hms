<x-app-layout>
    <main>
        <div class="container bg-white shadow-md rounded my-6 px-5 py-4">

            <div class="row pb-4">
                <h3 class="text-danger">
                    <strong><em>Edit <span class="text-success">Doctor Notes</span></em></strong>
                </h3>
            </div>

            <form method="POST"
                action="{{ route('admin.doctor_notes.update', $doctorNote->id) }}"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <!-- PATIENT INFO -->
                @if($doctorNote->patient)
                <div class="card mb-4">
                    <div class="card-header bg-light font-weight-bold">
                        Patient Information
                    </div>

                    <div class="card-body">

                        <div class="row py-2">
                            <div class="col-md-4"><strong>MR No:</strong> {{ $doctorNote->patient->id }}</div>
                            <div class="col-md-4"><strong>Name:</strong> {{ $doctorNote->patient->name }}</div>
                            <div class="col-md-4"><strong>Referred By:</strong> {{ $doctorNote->patient->reffered_by }}</div>
                        </div>

                        <div class="row py-2">
                            <div class="col-md-12">
                                <strong>Address:</strong> {{ $doctorNote->patient->address }}
                            </div>
                        </div>

                    </div>
                </div>
                @endif

                <!-- TOKEN INFO -->
                @if($doctorNote->token)
                <div class="card mb-4">
                    <div class="card-header bg-light font-weight-bold">
                        Token Information
                    </div>

                    <div class="card-body">

                        <div class="row py-2">
                            <div class="col-md-4">
                                <strong>Token No:</strong> {{ $doctorNote->token->token_id ?? $doctorNote->token->id }}
                            </div>

                            <div class="col-md-4">
                                <strong>Date:</strong> {{ $doctorNote->token->created_at ?? '' }}
                            </div>
                        </div>

                    </div>
                </div>
                @endif

                <!-- HIDDEN IDS -->
                <input type="hidden" name="fk_patient_id" value="{{ $doctorNote->fk_patient_id }}">
                <input type="hidden" name="fk_token_id" value="{{ $doctorNote->fk_token_id }}">

                <!-- MODE -->
                <div class="form-group m-3">

                    <label class="form-label text-dark font-weight-bold">Input Mode</label><br>

                    <label>
                        <input type="radio" name="mode" value="upload"
                            {{ $doctorNote->mode == 'upload' ? 'checked' : '' }}>
                        Upload
                    </label>

                    <label class="ml-3">
                        <input type="radio" name="mode" value="manual"
                            {{ $doctorNote->mode == 'manual' ? 'checked' : '' }}>
                        Manual
                    </label>

                </div>

                <!-- UPLOAD SECTION -->
                <div id="uploadSection"
                    class="form-group m-3"
                    @if($doctorNote->mode == 'upload')
                    style=""
                    @else
                    style="display:none;"
                    @endif>

                    <label class="form-label text-dark font-weight-bold">
                        Upload Prescription
                    </label>

                    @if($doctorNote->prescription)
                    <div class="mb-2">
                        <a href="{{ asset('assets/doctor_notes/'.$doctorNote->prescription) }}"
                            target="_blank"
                            class="btn btn-sm btn-info">
                            View Current File
                        </a>
                    </div>
                    @endif

                    <input type="file" name="prescription" class="form-control">

                </div>

                <!-- MANUAL SECTION -->
                <div id="manualSection"
                    @if($doctorNote->mode == 'manual')
                    style=""
                    @else
                    style="display:none;"
                    @endif>

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
        document.addEventListener('DOMContentLoaded', function() {

            // =========================
            // MODE TOGGLE
            // =========================
            let radios = document.querySelectorAll('input[name="mode"]');

            function toggleSections(mode) {

                let uploadSection =
                    document.getElementById('uploadSection');

                let manualSection =
                    document.getElementById('manualSection');

                if (!uploadSection || !manualSection) return;

                uploadSection.style.display =
                    mode === 'upload' ?
                    'block' :
                    'none';

                manualSection.style.display =
                    mode === 'manual' ?
                    'block' :
                    'none';
            }

            // INITIAL LOAD
            let checkedMode =
                document.querySelector('input[name="mode"]:checked');

            if (checkedMode) {
                toggleSections(checkedMode.value);
            }

            // CHANGE EVENT
            radios.forEach(radio => {

                radio.addEventListener('change', function() {

                    toggleSections(this.value);

                });

            });


            // ===============================
            // LIVE SEARCH
            // ===============================
            $(document).on('keyup', '.product-input', function() {

                let input = $(this);

                let row = input.closest('.medicine-row');

                let box = row.find('.product-suggestions');

                let query = input.val();

                if (query.length < 1) {

                    box.hide();

                    return;
                }

                $.ajax({

                    url: "{{ route('admin.products.search') }}",

                    data: {
                        term: query
                    },

                    success: function(data) {

                        console.log("RESULTS:", data);

                        box.html('').show();

                        if (!data || data.length === 0) {

                            box.hide();

                            return;
                        }

                        data.forEach(function(item) {

                            box.append(`

                        <a href="javascript:void(0)"
                           class="list-group-item list-group-item-action product-item"
                           data-id="${item.id}"
                           data-name="${item.name}"
                           style="cursor:pointer;">

                            ${item.name}

                        </a>

                    `);

                        });

                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                    }

                });

            });


            // ===============================
            // SELECT ITEM
            // ===============================
            $(document).on('click', '.product-item', function(e) {

                e.preventDefault();

                let row =
                    $(this).closest('.medicine-row');

                row.find('.product-input')
                    .val($(this).data('name'));

                row.find('.product-id')
                    .val($(this).data('id'));

                row.find('.product-suggestions')
                    .hide();

            });


            // ===============================
            // CLOSE DROPDOWN
            // ===============================
            $(document).on('click', function(e) {

                if (!$(e.target).closest('.medicine-row').length) {

                    $('.product-suggestions').hide();

                }

            });


            // ===============================
            // REMOVE ROW
            // ===============================
            $(document).on('click', '.remove-row', function() {

                $(this).closest('.medicine-row').remove();

            });

        });


        // ===============================
        // ADD ROW
        // ===============================
        function addMedicineRow() {

            let template =
                document.querySelector('#medicine-template .medicine-row');

            if (!template) {

                console.error("Medicine template not found");

                return;
            }

            let clone = template.cloneNode(true);

            clone.querySelectorAll('input').forEach(i => {

                i.value = '';

            });

            clone.querySelectorAll('select').forEach(s => {

                s.selectedIndex = 0;

            });

            clone.style.display = 'flex';

            document.getElementById('medicine-container')
                .appendChild(clone);

        }
    </script>

</x-app-layout>