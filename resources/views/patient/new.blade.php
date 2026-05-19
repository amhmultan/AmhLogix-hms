<x-app-layout>
  <main>
    <div class="container py-4 px-5">
      <form method="POST" action="{{ route('admin.patients.store') }}" enctype="multipart/form-data">
        @csrf
        <p class="text-center text-yellow-600 font-black text-4xl">Patient<span class="text-green-600 font-black text-4xl"> Registration</span></p>
        <hr class="my-4" />
        <span class="text-danger fw-bold italic"> * </span><span class="fw-bold text-primary italic">Required Fields</span>
        <div class="row pt-4 pb-4">
          <div class="col-md-3">
            <label for="name" class="text-gray-700 font-black">Patient Name:<span class="text-danger"> * </span></label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" required/>
          </div>
          <div class="col-md-3">
            <label for="name" class="text-gray-700 font-black">Guardian Name:</label>
            <input id="fname" type="text" name="fname" value="{{ old('fname') }}" class="form-control" />
          </div>
          <div class="col-md-2">
            <label for="age" class="text-gray-700 font-black">Age (Years)</label>
            <input type="number" name="age" class="form-control" min="0" required>
        </div>
          <!-- <div class="col-md-2">
            <label for="name" class="text-gray-700 font-black">Date Of Birth:</label>
            <input id="dob" type="date" name="dob" value="{{ old('dob') }}" class="form-control" />
          </div> -->
          <div class="col-md-2">
            <label for="gender" class="text-gray-700 font-black">Gender:</label>
            <select class="form-control" name="gender">
              <option value=""> ---- Please Select ---- </option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Others">Others</option>
            </select>
          </div>
          <div class="col-md-2">
            <label for="marital_status" class="text-gray-700 font-black">Marital Status:</label>
            <select class="form-control" name="marital_status">
              <option value=""> ---- Please Select ---- </option>
              <option value="Single">Single</option>
              <option value="Married">Married</option>
              <option value="Widowed">Widowed</option>
              <option value="Divorced">Divorced</option>
              <option value="Separated">Separated</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="phone" class="text-gray-700 font-black">Phone Number<span class="text-danger"> * </span></label>
            <input type="tel" id="phone" name="phone" placeholder="xxxxxxxxxxx" pattern="[0-9]{4}[0-9]{7}" value="{{ old('phone') }}" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label for="email" class="text-gray-700 font-black">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address" class="form-control" />
          </div>
          <div class="col-md-4">
            <label for="cnic" class="text-gray-700 font-black">CNIC (with dashes)</label>
            <input type="tel" id="cnic" name="cnic" placeholder="xxxxx-xxxxxxx-x" pattern="[0-9]{5}-[0-9]{7}-[0-9]{1}" value="{{ old('cnic') }}" class="form-control" />
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-md-12">
            <label for="address" class="text-gray-700 font-black">Address<span class="text-danger"> * </span></label>
            <textarea name="address" id="address" placeholder="Enter address" class="form-control" rows="5" required>{{ old('address') }}</textarea>
          </div>
        </div>
        <hr class="my-5" />
        <div class="row">
          <div class="col-md-3">
            <label for="emr_name" class="text-gray-700 font-black">Emergency Person Name</label>
            <input id="emr_name" type="text" name="emr_name" value="{{ old('emr_name') }}" class="form-control" />
          </div>
          <div class="col-md-3">
            <label for="relationship" class="text-gray-700 font-black">Relationship</label>
            <input id="relationship" type="text" name="relationship" value="{{ old('relationship') }}" class="form-control" />
          </div>
          <div class="col-md-3">
            <label for="emr_phone" class="text-gray-700 font-black">Number</label>
            <input type="tel" id="emr_phone" name="emr_phone" placeholder="xxxxxxxxxxx" pattern="[0-9]{4}[0-9]{7}" value="{{ old('phone') }}" class="form-control" />
          </div>
        </div>
        <hr class="my-5" />
        <div class="row">
          <div class="col-md-12">
            <label for="history" class="text-gray-700 font-black">History</label>
            <textarea name="history" id="history" placeholder="Enter history" class="form-control" rows="5">{{ old('history') }}</textarea>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-md-12">
            <label for="reffered_by" class="text-gray-700 font-black">Reffered By</label>
            <input id="reffered_by" type="text" name="reffered_by" value="{{ old('reffered_by') }}" class="form-control" />
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-md-12 text-center">
            <a class="btn btn-info mx-2" href="{{ route('admin.patients.index')}}" accesskey="b" role="button"><u>B</u>ack</a>
            <button type="submit" class="btn btn-success mx-2" accesskey="s" >Submit</button>
          </div>
        </div>
      </form>
    </div>
  </main>
</x-app-layout>