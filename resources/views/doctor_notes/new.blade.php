<x-app-layout>
    <main>
        <div class="container bg-white shadow-md rounded my-6 px-5 py-4">

            <div class="row pb-4">
                <h3 class="text-danger">
                    <strong><em>Add <span class="text-success">Doctor Notes</span></em></strong>
                </h3>
            </div>

            <!-- Token Search Form -->
            <form method="GET" action="{{ route('admin.doctor_notes.create') }}" class="row mb-4">
                <div class="col-sm-4">
                    <input type="search" name="search" id="search" 
                           placeholder="Enter Token Number" 
                           class="form-control" 
                           value="{{ $search }}">
                </div>
                <div class="col-sm-8">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

            <!-- Alerts -->
            @if($search && !$token)
                <div class="alert alert-warning">
                    No token found for <strong>{{ $search }}</strong>.
                </div>
            @endif

            @if($tokenAlreadySaved)
                <div class="alert alert-danger">
                    Token number <strong>{{ $search }}</strong> is already saved in Doctor Notes.
                </div>
            @endif

            @if($token)
                <!-- Patient Info Card -->
                <div class="card mb-4">
                    <div class="card-header bg-light font-weight-bold">Patient Information</div>
                    <div class="card-body">
                        <div class="row py-2">
                            <div class="col-md-4"><strong>Token No:</strong> {{ $token->id }}</div>
                            <div class="col-md-4"><strong>MR No:</strong> {{ $token->fk_patients_id }}</div>
                            <div class="col-md-4"><strong>Date & Time:</strong> {{ $token->created_at }}</div>
                        </div>
                        <div class="row py-2">
                            <div class="col-md-4"><strong>Patient Name:</strong> {{ $token->name }}</div>
                            <div class="col-md-4"><strong>DOB:</strong> {{ $token->pAge ?? 'N/A' }}</div>
                            <div class="col-md-4"><strong>Panel:</strong> {{ $token->reffered_by }}</div>
                        </div>
                        <div class="row py-2">
                            <div class="col-md-12"><strong>Address:</strong> {{ $token->pAddress }}</div>
                        </div>
                    </div>
                </div>

                <!-- Doctor Notes Form -->
                <form method="POST" action="{{ route('admin.doctor_notes.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Hidden IDs -->
                    <input type="hidden" name="fk_patient_id" value="{{ $token->fk_patients_id }}">
                    <input type="hidden" name="fk_token_id" value="{{ $token->id }}">

                    <!-- Mode Selection -->
                    <div class="form-group">
                        <label class="font-weight-bold">Select Input Mode:</label><br>
                        <label><input type="radio" name="mode" value="upload" checked> Upload Prescription</label>
                        <label class="ml-3"><input type="radio" name="mode" value="manual"> Manual Entry</label>
                    </div>

                    <!-- Upload Section -->
                    <div id="uploadSection" class="form-group">
                        <label for="prescription" class="font-weight-bold">Upload Prescription:</label>
                        <input id="prescription" type="file" name="prescription" class="form-control" />
                    </div>

                    <!-- Manual Section -->
                    <div id="manualSection" style="display:none;">
                        <div class="form-group">
                            <label>Complaints</label>
                            <textarea name="complaints" class="form-control">{{ old('complaints') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>History</label>
                            <textarea name="history" class="form-control">{{ old('history') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Investigations</label>
                            <textarea name="investigations" class="form-control">{{ old('investigations') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Prescription</label>
                            <textarea name="prescription_text" class="form-control">{{ old('prescription_text') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea name="remarks" class="form-control">{{ old('remarks') }}</textarea>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="text-center mt-4">
                        <a class="btn btn-warning mx-2" href="{{ route('admin.doctor_notes.index') }}">Back</a>
                        <button type="submit" class="btn btn-success mx-2" {{ $tokenAlreadySaved ? 'disabled' : '' }}>Submit</button>
                    </div>
                </form>
            @endif
        </div>
    </main>

    <script>
        document.querySelectorAll('input[name="mode"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('uploadSection').style.display = this.value === 'upload' ? 'block' : 'none';
                document.getElementById('manualSection').style.display = this.value === 'manual' ? 'block' : 'none';
            });
        });
    </script>
</x-app-layout>
