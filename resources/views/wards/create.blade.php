<x-app-layout>
  <main>
    <div class="container bg-white shadow-md rounded my-6 px-5 py-4">

      <div class="row pb-4">
        <h3 class="text-danger">
          <strong><em>Add <span class="text-success">Ward</span></em></strong>
        </h3>
        <hr />
      </div>

      <form method="POST" action="{{ route('admin.wards.store') }}">
        @csrf

        <div class="row my-3">
          <div class="col-md-6">
            <label class="font-black">Ward Name:</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
          </div>

          <div class="col-md-6">
            <label class="font-black">Ward Type:</label>
            <select name="type" class="form-control" required>
              <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General</option>
              <option value="private" {{ old('type') == 'private' ? 'selected' : '' }}>Private</option>
              <option value="icu" {{ old('type') == 'icu' ? 'selected' : '' }}>ICU</option>
            </select>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-12 text-center">
            <a href="{{ route('admin.wards.index') }}" class="btn btn-warning mx-2">Back</a>
            <button type="submit" class="btn btn-success mx-2">Save</button>
          </div>
        </div>
      </form>

    </div>
  </main>
</x-app-layout>
