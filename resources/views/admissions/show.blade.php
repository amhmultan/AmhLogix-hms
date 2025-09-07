<x-app-layout>
  <main>
    <div class="container bg-white shadow-md rounded my-6 px-5 py-4">

      <div class="row pb-4">
        <p class="h3 text-danger">
          <strong><em>Admission <span class="text-success">Details</span></em></strong>
        </p>
        <hr />
      </div>

      <div class="row my-3">
        <div class="col-md-6"><b>Patient:</b> {{ $admission->patient->name }}</div>
        <div class="col-md-6"><b>Doctor:</b> {{ $admission->doctor->name }}</div>
      </div>
      <div class="row my-3">
        <div class="col-md-6"><b>Ward/Bed:</b> {{ $admission->bed->ward->name }} - {{ $admission->bed->bed_number }}</div>
        <div class="col-md-6"><b>Diagnosis:</b> {{ $admission->diagnosis }}</div>
      </div>
      <div class="row my-3">
        <div class="col-md-6"><b>Admission Date:</b> {{ $admission->admission_date }}</div>
        <div class="col-md-6"><b>Status:</b> <span class="badge bg-info">{{ ucfirst($admission->status) }}</span></div>
      </div>

      <div class="row mt-5 text-center">
        <a href="{{ route('admin.admissions.index') }}" class="btn btn-secondary mx-2">Back</a>
        <a href="{{ route('admin.admissions.edit', $admission->id) }}" class="btn btn-warning mx-2">Edit</a>
        @if($admission->status == 'admitted')
          <a href="{{ route('admin.admissions.discharge.form', $admission->id) }}" class="btn btn-danger mx-2">Discharge</a>
        @endif
      </div>

    </div>
  </main>
</x-app-layout>
