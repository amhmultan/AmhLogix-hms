@php
    use Illuminate\Support\Facades\DB;

    $tokenAlreadySaved = false;

    if (!empty($search)) {
        $tokenAlreadySaved = DB::table('doctor_notes')
            ->whereIn('fk_token_id', $tokens->pluck('id'))
            ->exists();
    }
@endphp

<x-app-layout>
    <main>
        <div class="container bg-white shadow-md rounded my-6 px-5 py-4">
            
            <div class="row pb-5">
                <p class="h3 text-danger">
                    <strong><em>Add <span class="text-success">Doctor Notes</span></em></strong>
                </p>
                <hr />
            </div>

            <!-- Token Search Form -->
            <div class="row mb-5">
                <div class="col-sm-3">
                    <form action="" method="GET">
                        <input type="search" name="search" id="search" placeholder="Enter Token Number" class="form-control" value="{{ $search }}">
                </div>
                <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary mx-2">Search</button>
                    </form>
                </div>
            </div>

            {{-- Warning if token already exists --}}
            @if($tokenAlreadySaved)
                <div class="alert alert-danger">
                    Token number <strong>{{ $search }}</strong> is already saved in Doctor Notes.
                </div>
            @endif

            <hr />

            <!-- Token/Patient Details (readonly) -->
            <div class="row my-4">
                <div class="col-md-3">
                    <label class="text-gray-700 font-black">Token No:</label>
                    <select class="form-control" name="fk_token_id" disabled>
                        @if ($search != "")
                            @foreach ($tokens as $token)
                                <option>{{ $token->id }}</option>
                            @endforeach
                        @else
                            <option></option>
                        @endif
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="text-gray-700 font-black">MR No:</label>
                    <select class="form-control" name="fk_patient_id" disabled>
                        @if ($search != "")
                            @foreach ($tokens as $token)
                                <option>{{ $token->fk_patients_id }}</option>
                            @endforeach
                        @else
                            <option></option>
                        @endif
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="text-gray-700 font-black">Patient Name:</label>
                    <select class="form-control" name="fk_patient_name" disabled>
                        @if ($search != "")
                            @foreach ($tokens as $token)
                                <option>{{ $token->name }}</option>
                            @endforeach
                        @else
                            <option></option>
                        @endif
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="text-gray-700 font-black">Token Date:</label>
                    <select class="form-control" name="fk_token_created_at" disabled>
                        @if ($search != "")
                            @foreach ($tokens as $token)
                                <option>{{ $token->created_at }}</option>
                            @endforeach
                        @else
                            <option></option>
                        @endif
                    </select>
                </div>
            </div>

            <hr />

            <!-- Doctor Notes Form -->
            <form method="POST" action="{{ route('admin.doctor_notes.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Hidden patient/token -->
                <select class="form-control" name="fk_patient_id" hidden>
                    @foreach ($tokens as $token)
                        <option value="{{ $token->fk_patients_id }}">{{ $token->fk_patients_id }}</option>
                    @endforeach
                </select>
                <select class="form-control" name="fk_token_id" hidden>
                    @foreach ($tokens as $token)
                        <option value="{{ $token->id }}">{{ $token->id }}</option>
                    @endforeach
                </select>

                <!-- Mode Selection -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="font-black">Select Input Mode:</label><br>
                        <label>
                            <input type="radio" name="mode" value="upload" checked> Upload Prescription
                        </label>
                        <label class="ml-3">
                            <input type="radio" name="mode" value="manual"> Manual Entry
                        </label>
                    </div>
                </div>

                <!-- Upload Section -->
                <div id="uploadSection" class="row mt-4">
                    <div class="col-md-12">
                        <label for="prescription" class="text-gray-700 font-black">Upload Prescription:</label>
                        <input id="prescription" type="file" name="prescription" class="form-control" />
                    </div>
                </div>

                <!-- Manual Entry Section -->
                <div id="manualSection" class="row mt-4" style="display:none;">
                    <div class="col-md-6 mt-2">
                        <label>Complaints</label>
                        <textarea name="complaints" class="form-control">{{ old('complaints') }}</textarea>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>History</label>
                        <textarea name="history" class="form-control">{{ old('history') }}</textarea>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Investigations</label>
                        <textarea name="investigations" class="form-control">{{ old('investigations') }}</textarea>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Prescription</label>
                        <textarea name="prescription_text" class="form-control">{{ old('prescription_text') }}</textarea>
                    </div>
                    <div class="col-md-12 mt-2">
                        <label>Remarks</label>
                        <textarea name="remarks" class="form-control">{{ old('remarks') }}</textarea>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <a class="btn btn-warning mx-2" href="{{ route('admin.doctor_notes.index')}}" role="button">Back</a>
                        <button type="submit" class="btn btn-success mx-2" {{ $tokenAlreadySaved ? 'disabled' : '' }}>Submit</button>
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