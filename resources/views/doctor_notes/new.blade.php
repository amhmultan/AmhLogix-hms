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
                       class="form-control"
                       placeholder="Enter Token No or MR No">
            </div>

            <div class="col-md-4">

                <label>
                    <input type="radio" name="search_type" value="token"
                        {{ ($searchType ?? 'token') == 'token' ? 'checked' : '' }}>
                    Token No
                </label>

                <label class="ml-3">
                    <input type="radio" name="search_type" value="mr"
                        {{ ($searchType ?? '') == 'mr' ? 'checked' : '' }}>
                    MR No
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

        <div class="form-group m-3">
            <label class="form-label text-dark font-weight-bold">Input Mode</label><br>

            <label>
                <input type="radio" name="mode" value="upload" checked>
                Upload
            </label>

            <label class="ml-3">
                <input type="radio" name="mode" value="manual">
                Manual
            </label>
        </div>

        <div id="uploadSection" class="form-group m-3">
            <label class="form-label text-dark font-weight-bold">Upload Prescription</label>
            <input type="file" name="prescription" class="form-control">
        </div>

        <div id="manualSection" style="display:none;">

            <textarea name="complaints" class="form-control mb-2" placeholder="Complaints"></textarea>
            <textarea name="history" class="form-control mb-2" placeholder="History"></textarea>
            <textarea name="investigations" class="form-control mb-2" placeholder="Investigations"></textarea>
            <textarea name="prescription_text" class="form-control mb-2" placeholder="Prescription"></textarea>
            <textarea name="remarks" class="form-control mb-2" placeholder="Remarks"></textarea>

        </div>

        <div class="text-center mt-4">
            <button class="btn btn-success">Submit</button>
        </div>

    </form>

    @endif

</div>
</main>

<script>
document.querySelectorAll('input[name="mode"]').forEach(radio => {
    radio.addEventListener('change', function () {
        document.getElementById('uploadSection').style.display =
            this.value === 'upload' ? 'block' : 'none';

        document.getElementById('manualSection').style.display =
            this.value === 'manual' ? 'block' : 'none';
    });
});
</script>

</x-app-layout>