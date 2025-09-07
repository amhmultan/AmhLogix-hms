<x-app-layout>
  <main>
    <div class="container bg-white shadow-md rounded my-6 px-5 py-4">

      <div class="row pb-5">
        <p class="h3 text-danger">
          <strong><em>Admit <span class="text-success">Patient</span></em></strong>
        </p>
        <hr />
      </div>

      {{-- Search Patient by MR Number --}}
      <div class="row mb-5">
        <div class="col-sm-3">
          <form action="" method="GET">
            <input type="search" name="search" id="search" placeholder="Enter MR Number" class="form-control">
        </div>
        <div class="col-sm-9">
          <button type="submit" class="btn btn-primary mx-2">Search</button>
          </form>
        </div>
      </div>

      <hr />

      {{-- Patient Info --}}
      <div class="row my-4">
        <div class="col-md-6">
          <label class="text-gray-700 font-black">Patient Name:</label>
          <select class="form-control" disabled>
            @if ($search != "")
              @foreach ($patients as $patient)
                <option>{{ $patient->name }}</option>
              @endforeach
            @else
              <option></option>
            @endif
          </select>
        </div>
        <div class="col-md-6">
          <label class="text-gray-700 font-black">Contact Number:</label>
          <select class="form-control" disabled>
            @if ($search != "")
              @foreach ($patients as $patient)
                <option>{{ $patient->phone }}</option>
              @endforeach
            @else
              <option></option>
            @endif
          </select>
        </div>
      </div>

      <div class="row my-4">
        <div class="col-md-6">
          <label class="text-gray-700 font-black">CNIC:</label>
          <select class="form-control" disabled>
            @if ($search != "")
              @foreach ($patients as $patient)
                <option>{{ $patient->cnic }}</option>
              @endforeach
            @else
              <option></option>
            @endif
          </select>
        </div>
        <div class="col-md-6">
          <label class="text-gray-700 font-black">Panel:</label>
          <select class="form-control" disabled>
            @if ($search != "")
              @foreach ($patients as $patient)
                <option>{{ $patient->reffered_by }}</option>
              @endforeach
            @else
              <option></option>
            @endif
          </select>
        </div>
      </div>

      <hr />

      {{-- Admission Form --}}
      <form method="POST" action="{{ route('admin.admissions.store') }}">
        @csrf

        {{-- Hidden Patient ID --}}
        <select class="form-control" name="patient_id" hidden>
          @foreach ($patients as $patient)
            <option value="{{ $patient->id }}" selected>{{ $patient->id }} - {{ $patient->name }}</option>
          @endforeach
        </select>

        <div class="row my-4">
          <div class="col-md-6">
            <label class="text-gray-700 font-black">Doctor:</label>
            <select id="doctorSelect" class="form-control" name="doctor_id" required>
              <option value="">-- Select Doctor --</option>
              @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6">
              <label class="font-black">Select Bed:</label>
              <select name="bed_id" class="form-control" required>
                  <option value="">-- Select Available Bed --</option>
                  @foreach ($beds as $bed)
                      <option value="{{ $bed->id }}">
                          {{ $bed->bed_number }} ({{ ucfirst($bed->ward->name) }} - {{ ucfirst($bed->ward->type) }})
                      </option>
                  @endforeach
              </select>
          </div>
        </div>

        <div class="row my-4">
          <div class="col-md-6">
            <label class="text-gray-700 font-black">Admission Fees:</label>
            <input type="number" name="admission_fees" class="form-control" placeholder="Enter Admission Fees" value="{{ old('admission_fees') }}" required>
          </div>
        </div>

        <div class="row my-4">
          <div class="col-md-12">
            <label class="text-gray-700 font-black">Diagnosis:</label>
            <textarea name="diagnosis" rows="3" class="form-control">{{ old('diagnosis') }}</textarea>
          </div>
        </div>

        <div class="row mt-5 text-center">
          <a class="btn btn-warning mx-2" href="{{ route('admin.admissions.index') }}" accesskey="b" role="button"><u>B</u>ack</a>
          <button type="submit" class="btn btn-success mx-2">Submit</button>
        </div>
      </form>

    </div>
  </main>
</x-app-layout>
