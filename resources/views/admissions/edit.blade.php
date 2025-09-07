<x-app-layout>
  <main>
    <div class="container bg-white shadow-md rounded my-6 px-5 py-4">

      <div class="row pb-5">
        <p class="h3 text-danger">
          <strong><em>Edit <span class="text-success">Admission</span></em></strong>
        </p>
        <hr />
      </div>

      <form method="POST" action="{{ route('admin.admissions.update', $admission->id) }}">
        @csrf
        @method('PUT')

        <div class="row my-4">
          <div class="col-md-6">
            <label class="text-gray-700 font-black">Doctor:</label>
            <select class="form-control" name="doctor_id" required>
              @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}" {{ $admission->doctor_id == $doctor->id ? 'selected' : '' }}>
                  {{ $doctor->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
              <label class="font-black">Select Bed:</label>
              <select name="bed_id" class="form-control" required>
                  <option value="">-- Select Bed --</option>
                  @foreach ($beds as $bed)
                      <option value="{{ $bed->id }}"
                          {{ $admission->bed_id == $bed->id ? 'selected' : '' }}>
                          {{ $bed->bed_number }} ({{ ucfirst($bed->ward->name) }} - {{ ucfirst($bed->ward->type) }})
                      </option>
                  @endforeach
              </select>
          </div>
        </div>

        <div class="row my-4">
          <div class="col-md-6">
            <label class="text-gray-700 font-black">Admission Fees:</label>
            <input type="number" name="admission_fees" class="form-control"
                  value="{{ $admission->admission_fees }}" required>
          </div>
        </div>
        
        <div class="row my-4">
          <div class="col-md-12">
            <label class="text-gray-700 font-black">Diagnosis:</label>
            <textarea name="diagnosis" rows="3" class="form-control">{{ $admission->diagnosis }}</textarea>
          </div>
        </div>

        <div class="row mt-5 text-center">
          <a class="btn btn-warning mx-2" href="{{ route('admin.admissions.index')}}">Back</a>
          <button type="submit" class="btn btn-success mx-2">Update</button>
        </div>
      </form>

    </div>
  </main>
</x-app-layout>
