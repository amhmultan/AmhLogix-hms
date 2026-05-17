<x-app-layout>
  <div>
       <main>
        <div class="container-fluid py-4 px-5">
             

               <form method="POST" action="{{ route('admin.patients.update',$patient->id)}}">
                @csrf
                @method('put')
                <p class="text-center text-yellow-600 font-black text-4xl">Update Pat<span class="text-green-600 font-black text-4xl">ient Details</span></p>
                <hr class="my-4" />
                <span class="text-danger fw-bold italic"> * </span><span class="fw-bold text-primary italic">Required Fields</span>

                
                 <div class="row pt-5 pb-4">

                   <div class="col-md-2">
                     <label for="mr_number" class="text-gray-700 font-black mr-2">MR. No.</label>
                     <input id="mr_number" type="number" name="mr_number" value="{{ old('id',$patient->id) }}" class="form-control" disabled/>
                   </div>
                   <div class="col-md-4">
                     <label for="name" class="text-gray-700 font-black">Patient Name:<span class="text-danger"> * </span></label>
                     <input id="name" type="text" name="name" value="{{ old('name',$patient->name) }}" class="form-control" />
                   </div>
                   <div class="col-md-4">
                     <label for="name" class="text-gray-700 font-black">Fathers Name:</label>
                     <input id="fname" type="text" name="fname" value="{{ old('fname',$patient->fname) }}" class="form-control" />
                   </div>

                   <div class="col-md-2">
                      <label for="age" class="text-gray-700 font-black">Age (Years)</label>
                      <input type="number" name="age" class="form-control" value="{{ old('age', \Carbon\Carbon::parse($patient->dob)->age) }}" min="0" max="120" required>
                  </div>
                   <!-- <div class="col-md-2">
                     <label for="dob" class="text-gray-700 font-black">Date Of Birth:</label>
                     <input id="dob" type="date" name="dob" value="{{ old('dob', $patient->dob) }}" class="form-control" />
                   </div> -->

                 </div>
                
                 <div class="row">
                  <div class="col-md-2">
                    <label for="gender" class="text-gray-700 font-black">Gender:</label>
                    <select class="form-control" name="gender">
                      <option value=""> ---- Please Select ---- </option>

                      <option value="Male" {{ old('gender', $patient->gender) == 'Male' ? 'selected' : '' }}>Male</option>

                      <option value="Female" {{ old('gender', $patient->gender) == 'Female' ? 'selected' : '' }}>Female</option>

                      <option value="Others" {{ old('gender', $patient->gender) == 'Others' ? 'selected' : '' }}>Others</option>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <label for="marital_status" class="text-gray-700 font-black">Marital Status:</label>
                    <select class="form-control" name="marital_status">
                      <option value=""> ---- Please Select ---- </option>
                      <option value="Single" {{ old('marital_status', $patient->marital_status) == 'Single' ? 'selected' : '' }}>Single</option>
                      <option value="Married" {{ old('marital_status', $patient->marital_status) == 'Married' ? 'selected' : '' }}>Married</option>
                      <option value="Widowed" {{ old('marital_status', $patient->marital_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                      <option value="Divorced" {{ old('marital_status', $patient->marital_status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                      <option value="Separated" {{ old('marital_status', $patient->marital_status) == 'Separated' ? 'selected' : '' }}>Separated</option>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <label for="phone" class="text-gray-700 font-black">Phone Number<span class="text-danger"> * </span></label>
                    <input type="tel" id="phone" name="phone" placeholder="XXXXXXXXXXX" pattern="[0-9]{4}[0-9]{7}" value="{{ old('phone',$patient->phone) }}" class="form-control" required>
                  </div>
                
                  <div class="col-md-3">
                    <label for="email" class="text-gray-700 font-black">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email',$patient->email) }}" placeholder="Please enter your email address" class="form-control" />
                  </div>

                  <div class="col-md-3">
                    <label for="cnic" class="text-gray-700 font-black">CNIC</label>
                    <input type="tel" id="cnic" name="cnic" placeholder="XXXXX-XXXXXXX-X" pattern="[0-9]{5}-[0-9]{7}-[0-9]{1}" value="{{ old('cnic', $patient->cnic) }}" class="form-control" />
                  </div>

                 </div>

                 <div class="row mt-4">

                   <div class="col-md-12">
                     <label for="address" class="text-gray-700 font-black">Address<span class="text-danger"> * </span></label>
                     <textarea name="address" id="address" placeholder="Enter address" class="form-control" rows="5">{{ old('address',$patient->address) }}</textarea>
                   </div>

                 </div>

                 <div class="row mt-4">
                   
                   <div class="col-md-3">
                     <label for="emr_name" class="text-gray-700 font-black">Emergency Name</label>
                     <input id="emr_name" type="text" name="emr_name" value="{{ old('emr_name',$patient->emr_name) }}" class="form-control" />
                   </div>
                   <div class="col-md-3">
                     <label for="relationship" class="text-gray-700 font-black">Relationship</label>
                     <input id="relationship" type="text" name="relationship" value="{{ old('relationship',$patient->relationship) }}" class="form-control" />
                   </div>
                   <div class="col-md-3">
                     <label for="emr_phone" class="text-gray-700 font-black">Number</label>
                     <input type="tel" id="emr_phone" name="emr_phone" placeholder="XXXXXXXXXXX" pattern="[0-9]{4}[0-9]{7}" value="{{ old('emr_phone',$patient->emr_phone) }}" class="form-control" />
                   </div>
                   <div class="col-md-3">
                    <label for="reffered_by" class="text-gray-700 font-black">Reffered By</label>
                    <input id="reffered_by" type="text" name="reffered_by" value="{{ old('reffered_by',$patient->reffered_by) }}" class="form-control" />
                   </div>
                   
                 </div>

                 <div class="row mt-4">

                   <div class="col-md-12">
                     <label for="history" class="text-gray-700 font-black">History</label>
                     <textarea name="history" id="history" placeholder="Enter history" class="form-control" rows="5">{{ old('history',$patient->history) }}</textarea>
                   </div>

                 </div>
                 
                 <div class="row mt-5">

                   <div class="col-md-12 text-center">
                     <a class="btn btn-warning text-primary mx-2" accesskey="b" href="{{ route('admin.patients.index')}}" role="button"><u>B</u>ack</a>
                     <button type="submit" class="btn btn-success mx-2">Submit</button>
                   </div>

                 </div>

               </form> 
           </div>
       </main>
   </div>
</div>
</x-app-layout>
