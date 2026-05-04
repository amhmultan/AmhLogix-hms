<x-app-layout>
  <main>
    <div class="container-fluid py-4 px-5">
      <form method="POST" action="{{ route('admin.doctors.store') }}" enctype="multipart/form-data">
        @csrf

        <p class="text-center text-yellow-600 font-black text-4xl">
          Add Doc<span class="text-green-600 font-black text-4xl">tor Details</span>
        </p>
        <hr class="my-4" />
        <p>
          <span class="text-danger fw-bold italic">*</span>
          <span class="fw-bold text-primary italic">Required Fields</span>
        </p>

        <div class="row pt-4 pb-4">
          <div class="col-md-4">
            <label class="text-gray-700 font-black">Name:<span class="text-danger"> *</span></label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Enter name" required>
          </div>

          <div class="col-md-3">
            <label class="text-gray-700 font-black">Picture:</label>
            <input type="file" name="pic" class="form-control">
          </div>

          <div class="col-md-2">
            <label class="text-gray-700 font-black">Date of Birth:</label>
            <input type="date" name="dob" value="{{ old('dob') }}" class="form-control">
          </div>

          <div class="col-md-3">
            <label class="text-gray-700 font-black">Cell Number:</label>
            <input type="tel" name="contact" value="{{ old('contact') }}" class="form-control" placeholder="03XXXXXXXXX" pattern="[0-9]{4}[0-9]{7}">
          </div>
        </div>

        <div class="row">
          <div class="col-md-5">
            <label class="text-gray-700 font-black">Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter email address">
          </div>

          <div class="col-md-4">
            <label class="text-gray-700 font-black">CNIC <span class="fw-bold text-success italic">(with dashes)</span></label>
            <input type="text" name="cnic" value="{{ old('cnic') }}" class="form-control" placeholder="xxxxx-xxxxxxx-x" pattern="[0-9]{5}-[0-9]{7}-[0-9]{1}">
          </div>

          <div class="col-md-3">
            <label class="text-gray-700 font-black">PMDC Number:<span class="text-danger"> *</span></label>
            <input type="text" name="pmdc" value="{{ old('pmdc') }}" class="form-control" placeholder="Enter PMDC Number" required>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-9">
            <label class="text-gray-700 font-black">Qualification:</label>
            <input type="text" name="schedule" value="{{ old('schedule') }}" class="form-control">
          </div>

          <div class="col-md-3">
            <label class="text-gray-700 font-black">Speciality:<span class="text-danger"> *</span></label>
            <select name="speciality_id" class="form-control" required>
              <option value="">-- Please Select --</option>
              @foreach($specialities as $speciality)
                <option value="{{ $speciality->id }}" {{ old('speciality_id') == $speciality->id ? 'selected' : '' }}>
                  {{ $speciality->title }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-12">
            <label class="text-gray-700 font-black">Address:</label>
            <textarea name="address" class="form-control" rows="3" placeholder="Enter address">{{ old('address') }}</textarea>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-12">
            <label class="text-gray-700 font-black">Remarks:</label>
            <textarea name="remarks" class="form-control" rows="3" placeholder="Enter remarks">{{ old('remarks') }}</textarea>
          </div>
        </div>

        <div class="row mt-5 text-center">
          <div class="col-md-12">
            <a href="{{ route('admin.doctors.index') }}" class="btn btn-info mx-2" accesskey="b">Back</a>
            <button type="submit" class="btn btn-success mx-2" accesskey="s">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </main>
</x-app-layout>