<x-app-layout>
  <main>
    <div class="container bg-white shadow-md rounded my-6 px-5 py-4">

      <div class="row pb-4">
        <h3 class="text-danger">
          <strong><em>Add <span class="text-success">Bed</span></em></strong>
        </h3>
        <hr />
      </div>

      <form method="POST" action="{{ route('admin.beds.store') }}">
        @csrf

        <div class="row my-3">
          <div class="col-md-6">
            <label class="font-black">Ward:</label>
            <select name="ward_id" class="form-control" required>
              <option value="">-- Select Ward --</option>
              @foreach ($wards as $ward)
                <option value="{{ $ward->id }}">{{ $ward->name }} ({{ ucfirst($ward->type) }})</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6">
            <label class="font-black">Bed Number:</label>
            <input type="text" name="bed_number" value="{{ old('bed_number') }}" class="form-control" required>
          </div>
        </div>

        <div class="row my-3">
          <div class="col-md-6">
            <label class="font-black">Rate per Day:</label>
            <input type="number" name="rate_per_day" class="form-control" step="0.01" required>
          </div>
          <div class="col-md-6">
            <label class="font-black">Status:</label>
            <select name="status" class="form-control" required>
              <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
              <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
            </select>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-12 text-center">
            <a href="{{ route('admin.beds.index') }}" class="btn btn-warning mx-2">Back</a>
            <button type="submit" class="btn btn-success mx-2">Save</button>
          </div>
        </div>
      </form>

    </div>
  </main>
</x-app-layout>
