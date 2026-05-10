<x-app-layout>
    <main>
        <div class="container bg-white shadow-md rounded my-6 px-5 py-4">
            
            <div class="row pb-5">
                <p class="h3 text-danger">
                    <strong><em>Edit <span class="text-success">Doctor Notes</span></em></strong>
                </p>
                <hr />
            </div>

            <form method="POST" action="{{ route('admin.doctor_notes.update', $doctor_notes->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Patient and Token Info (readonly) -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="font-black">Token No:</label>
                        <input type="text" class="form-control" value="{{ $doctor_notes->fk_token_id }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label class="font-black">MR No:</label>
                        <input type="text" class="form-control" value="{{ $doctor_notes->fk_patient_id }}" disabled>
                    </div>
                </div>

                <!-- Mode Selection -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="font-black">Select Input Mode:</label><br>
                        <label>
                            <input type="radio" name="mode" value="upload" {{ $doctor_notes->mode == 'upload' ? 'checked' : '' }}>
                            Upload Prescription
                        </label>
                        <label class="ml-3">
                            <input type="radio" name="mode" value="manual" {{ $doctor_notes->mode == 'manual' ? 'checked' : '' }}>
                            Manual Entry
                        </label>
                    </div>
                </div>

                <!-- Upload Section -->
                <div id="uploadSection" class="row mt-4" style="{{ $doctor_notes->mode == 'upload' ? '' : 'display:none;' }}">
                    <div class="col-md-12">
                        @if($doctor_notes->prescription)
                            <p>
                                Current file:
                                <a href="{{ asset('assets/doctor_notes/'.$doctor_notes->prescription) }}" target="_blank">View</a>
                            </p>
                        @endif
                        <label for="prescription" class="font-black">Upload New Prescription:</label>
                        <input id="prescription" type="file" name="prescription" class="form-control" />
                    </div>
                </div>

                <!-- Manual Entry Section -->
                <div id="manualSection" class="row mt-4" style="{{ $doctor_notes->mode == 'manual' ? '' : 'display:none;' }}">
                    <div class="col-md-6 mt-2">
                        <label>Complaints</label>
                        <textarea name="complaints" class="form-control">{{ old('complaints', $doctor_notes->complaints) }}</textarea>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>History</label>
                        <textarea name="history" class="form-control">{{ old('history', $doctor_notes->history) }}</textarea>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Investigations</label>
                        <textarea name="investigations" class="form-control">{{ old('investigations', $doctor_notes->investigations) }}</textarea>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Prescription</label>
                        <textarea name="prescription_text" class="form-control">{{ old('prescription_text', $doctor_notes->prescription_text) }}</textarea>
                    </div>
                    <div class="col-md-12 mt-2">
                        <label>Remarks</label>
                        <textarea name="remarks" class="form-control">{{ old('remarks', $doctor_notes->remarks) }}</textarea>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <a class="btn btn-warning mx-2" href="{{ route('admin.doctor_notes.index') }}" role="button">Back</a>
                        <button type="submit" class="btn btn-success mx-2">Update</button>
                    </div>
                </div>
            </form>

        </div>
    </main>

    <script>
        document.querySelectorAll('input[name="mode"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('uploadSection').style.display = this.value === 'upload' ? 'flex' : 'none';
                document.getElementById('manualSection').style.display = this.value === 'manual' ? 'flex' : 'none';
            });
        });
    </script>
</x-app-layout>
