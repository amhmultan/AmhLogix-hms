<x-app-layout>
  <main>
    <div class="container bg-white shadow-md rounded my-6 px-5 py-4">

      <div class="row pb-5">
        <p class="h3 text-danger">
          <strong><em>Discharge <span class="text-success">Patient</span></em></strong>
        </p>
        <hr />
      </div>

      {{-- Patient Info --}}
      <div class="row my-4">
        <div class="col-md-6">
          <label class="text-gray-700 font-black">Patient Name:</label>
          <input type="text" class="form-control" value="{{ $admission->patient->name }}" disabled>
        </div>
        <div class="col-md-6">
          <label class="text-gray-700 font-black">Contact Number:</label>
          <input type="text" class="form-control" value="{{ $admission->patient->phone }}" disabled>
        </div>
      </div>

      <div class="row my-4">
        <div class="col-md-6">
          <label class="text-gray-700 font-black">CNIC:</label>
          <input type="text" class="form-control" value="{{ $admission->patient->cnic }}" disabled>
        </div>
        <div class="col-md-6">
          <label class="text-gray-700 font-black">Panel:</label>
          <input type="text" class="form-control" value="{{ $admission->patient->reffered_by }}" disabled>
        </div>
      </div>

      <div class="row my-4">
        <div class="col-md-6">
          <label class="text-gray-700 font-black">Doctor:</label>
          <input type="text" class="form-control" value="{{ $admission->doctor->name ?? 'N/A' }}" disabled>
        </div>
        <div class="col-md-6">
          <label class="text-gray-700 font-black">Bed:</label>
          <input type="text" class="form-control" value="{{ $admission->bed->bed_number }} ({{ ucfirst($admission->bed->ward->name) }})" disabled>
        </div>
      </div>

      <div class="row my-4">
        <div class="col-md-12">
          <label class="text-gray-700 font-black">Diagnosis:</label>
          <textarea class="form-control" rows="3" disabled>{{ $admission->diagnosis }}</textarea>
        </div>
      </div>

      <div class="row my-4">
        <div class="col-md-6">
          <label class="text-gray-700 font-black">Admission Date:</label>
          <input type="text" class="form-control" value="{{ $admission->admission_date->format('d-m-Y H:i') }}" disabled>
        </div>
        <div class="col-md-6">
          <label class="text-gray-700 font-black">Discharge Date:</label>
          <input type="text" class="form-control" value="{{ now()->format('d-m-Y H:i') }}" disabled>
        </div>
      </div>

      <hr />

      <form method="POST" action="{{ route('admin.admissions.discharge.store', $admission->id) }}">
          @csrf

          <div class="row my-4">
              <div class="col-md-12">
                  <label class="text-gray-700 font-black">Clinical Notes:</label>
                  <textarea name="clinical_notes" class="form-control" rows="3"></textarea>
              </div>
          </div>

          <div class="row my-4">
              <div class="col-md-12">
                  <label class="text-gray-700 font-black">Medications on Discharge:</label>
                  <textarea name="medications" class="form-control" rows="3"></textarea>
              </div>
          </div>

          <div class="row my-4">
              <div class="col-md-12">
                  <label class="text-gray-700 font-black">Follow-up Instructions:</label>
                  <textarea name="follow_up" class="form-control" rows="3"></textarea>
              </div>
          </div>

          <div class="row mt-5 text-center">
              <a class="btn btn-warning mx-2" href="{{ route('admin.admissions.index') }}" accesskey="b">Back</a>
              <button type="submit" class="btn btn-danger mx-2">Discharge Patient</button>
          </div>
      </form>


    </div>
  </main>
</x-app-layout>
