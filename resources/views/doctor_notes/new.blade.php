<x-app-layout>
    <main>
        <div class="container bg-white shadow-md rounded my-6 px-5 py-4">

            <div class="row pb-4">
                <h3 class="text-danger">
                    <strong><em>Add <span class="text-success">Doctor Notes</span></em></strong>
                </h3>
            </div>

            <!-- SEARCH -->
            <form method="GET" action="{{ route('admin.doctor_notes.create') }}">
                <div class="row mb-3">

                    <div class="col-md-4">
                        <input type="text"
                            name="search"
                            value="{{ $search ?? '' }}"
                            class="form-control auto-focus"
                            placeholder="Enter Token No or MR No"
                            required>
                    </div>

                    <div class="col-md-4">

                        <label class="ml-3 my-1">
                            <input type="radio"
                                name="search_type"
                                value="mr"
                                {{ ($searchType ?? 'mr') == 'mr' ? 'checked' : '' }}>
                            MR No
                        </label>

                        <label class="ml-3 my-1">
                            <input type="radio"
                                name="search_type"
                                value="token"
                                {{ ($searchType ?? '') == 'token' ? 'checked' : '' }}>
                            Token No
                        </label>

                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary">Search</button>
                    </div>

                </div>
            </form>

            <!-- ALERTS -->

            @if(!empty($search) && empty($patient) && empty($token))
            <div class="alert alert-warning">
                No record found for {{ $search }}
            </div>
            @endif

            @if($tokenAlreadySaved ?? false)
            <div class="alert alert-danger">
                Doctor Notes already exist for this record.
            </div>
            @endif

            <!-- PATIENT INFO -->
            @if($patient)
            <div class="card mb-4">
                <div class="card-header bg-light font-weight-bold">Patient Information</div>
                <div class="card-body">

                    <div class="row py-2">
                        <div class="col-md-4"><strong>MR No:</strong> {{ $patient->id }}</div>
                        <div class="col-md-4"><strong>Name:</strong> {{ $patient->name }}</div>
                        <div class="col-md-4"><strong>Referred By:</strong> {{ $patient->reffered_by }}</div>
                    </div>

                    <div class="row py-2">
                        <div class="col-md-12">
                            <strong>Address:</strong> {{ $patient->address }}
                        </div>
                    </div>

                </div>
            </div>
            @endif

            <!-- TOKEN INFO -->
            @if($token)
            <div class="card mb-4">
                <div class="card-header bg-light font-weight-bold">Token Information</div>
                <div class="card-body">

                    <div class="row py-2">
                        <div class="col-md-4">
                            <strong>Token No:</strong> {{ $token->token_id ?? $token->id }}
                        </div>

                        <div class="col-md-4">
                            <strong>Date:</strong> {{ $token->created_at ?? '' }}
                        </div>
                    </div>

                </div>
            </div>
            @endif



            <!-- FORM -->
            @if($patient || $token)

            <form method="POST"
                action="{{ route('admin.doctor_notes.store') }}"
                enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="fk_patient_id"
                    value="{{ $patient->id ?? $token->mr_no ?? '' }}">

                <input type="hidden" name="fk_token_id"
                    value="{{ $token->id ?? $token->token_id ?? '' }}">

                <div class="row my-4">
                    <div class="col-md-6">
                        <label class="text-gray-700 font-black">Doctor:</label>
                        <select id="doctorSelect" class="form-control" name="fk_doctor_id" required>
                            @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}"
                                data-specialty-id="{{ $doctor->speciality_id ?? '' }}"
                                data-specialty="{{ $doctor->speciality_title ?? 'N/A' }}"
                                {{ $loop->first ? 'selected' : '' }}>
                                {{ $doctor->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="text-gray-700 font-black">Specialty:</label>
                        <div class="form-control mt-2" id="specialtyTitle">--</div>
                        <input type="hidden" name="fk_specialty_id" id="fk_specialty_id">
                    </div>
                </div>

                <hr />

                <div class="form-group m-3">

                    <label class="form-label text-dark font-weight-bold">
                        Input Mode
                    </label><br>

                    <label>
                        <input type="radio"
                            name="mode"
                            value="upload">
                        Upload
                    </label>

                    <label class="ml-3">
                        <input type="radio"
                            name="mode"
                            value="manual"
                            checked>
                        Manual
                    </label>

                </div>

                <div id="uploadSection"
                    class="form-group m-3"
                    style="display:none;">

                    <label class="form-label text-dark font-weight-bold">
                        Upload Prescription
                    </label>

                    <input type="file"
                        name="prescription"
                        class="form-control">

                </div>

                <div id="manualSection"
                    style="display:block;">

                    @include('doctor_notes.partials.manual_prescription')

                </div>

                <div class="text-center mt-4">
                    <button class="btn btn-success">Submit</button>
                </div>

            </form>

            @endif

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // =========================
            // AUTO FOCUS
            // =========================
            setTimeout(function() {

                let input = document.querySelector('.auto-focus');

                if (input) {
                    input.focus();
                    input.select();
                }

            }, 500);


            // =========================
            // MODE TOGGLE
            // =========================
            let radios = document.querySelectorAll('input[name="mode"]');

            function toggleSections(mode) {

                let uploadSection = document.getElementById('uploadSection');
                let manualSection = document.getElementById('manualSection');

                if (!uploadSection || !manualSection) return;

                uploadSection.style.display =
                    mode === 'upload' ? 'block' : 'none';

                manualSection.style.display =
                    mode === 'manual' ? 'block' : 'none';
            }

            // Initial load
            let checkedMode = document.querySelector('input[name="mode"]:checked');

            if (checkedMode) {
                toggleSections(checkedMode.value);
            }

            // Change event
            radios.forEach(radio => {

                radio.addEventListener('change', function() {

                    toggleSections(this.value);

                });

            });


            // ===============================
            // LIVE SEARCH (GLOBAL DELEGATION)
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
                        console.log("AJAX ERROR:", xhr.responseText);
                    }
                });

            });


            // ===============================
            // SELECT ITEM (FIXED & SAFE)
            // ===============================
            $(document).on('click', '.product-item', function(e) {

                e.preventDefault();

                let row = $(this).closest('.medicine-row');

                row.find('.product-input').val($(this).data('name'));
                row.find('.product-id').val($(this).data('id'));

                row.find('.product-suggestions').hide();

            });


            // ===============================
            // CLOSE DROPDOWN OUTSIDE CLICK
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
        // UPDATE SPECIALTY
        // ===============================
        document.addEventListener('DOMContentLoaded', function() {

            const doctorSelect = document.getElementById('doctorSelect');
            const specialtyTitle = document.getElementById('specialtyTitle');
            const specialtyInput = document.getElementById('fk_specialty_id');

            if (!doctorSelect || !specialtyTitle || !specialtyInput) {
                return;
            }

            function updateSpecialty() {

                const option = doctorSelect.options[doctorSelect.selectedIndex];

                specialtyTitle.textContent = option.dataset.specialty || '--';
                specialtyInput.value = option.dataset.specialtyId || '';
            }

            doctorSelect.addEventListener('change', updateSpecialty);

            updateSpecialty();

        });
    </script>
    <script>
        // ===============================
        // ADD ROW (GLOBAL - FIXED)
        // ===============================
        function addMedicineRow() {
            let template = document.querySelector('#medicine-template .medicine-row');

            if (!template) {
                console.error("Medicine template not found");
                return;
            }

            let clone = template.cloneNode(true);

            clone.querySelectorAll('input').forEach(i => i.value = '');
            clone.querySelectorAll('select').forEach(s => s.selectedIndex = 0);

            clone.style.display = 'flex';

            document.getElementById('medicine-container').appendChild(clone);
        }
    </script>

</x-app-layout>