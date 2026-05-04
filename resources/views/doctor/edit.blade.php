<x-app-layout>
    <div class="container-fluid py-4 px-5">
        <form method="POST" action="{{ route('admin.doctors.update', $doctor->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <p class="text-center text-yellow-600 font-black text-4xl">Update Doc<span class="text-green-600 font-black text-4xl">tor Details</span></p>
            <hr class="my-4" />
            <p><span class="text-danger fw-bold italic">*</span> <span class="fw-bold text-primary italic">Required Fields</span></p>

            <div class="row pt-4 pb-4">
                <div class="col-md-4">
                    <label class="text-gray-700 font-black">Name:<span class="text-danger"> *</span></label>
                    <input type="text" name="name" value="{{ old('name', $doctor->name) }}" class="form-control" required>
                </div>

                <div class="col-md-2">
                    <label class="text-gray-700 font-black">Date of Birth:</label>
                    <input type="date" name="dob" value="{{ old('dob', $doctor->dob) }}" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="text-gray-700 font-black">Cell Number:</label>
                    <input type="tel" name="contact" value="{{ old('contact', $doctor->contact) }}" class="form-control" placeholder="03XXXXXXXXX">
                </div>

                <div class="col-md-3">
                    <label class="text-gray-700 font-black">Picture:</label>
                    @if($doctor->pic)
                        <div class="border-4 rounded-lg border-black p-3 m-1">
                            <img src="{{ asset('uploads/' . ($doctor->pic ?? 'default.png')) }}" width="120px">
                        </div>
                    @endif
                    <input type="file" name="pic" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <label class="text-gray-700 font-black">Email:</label>
                    <input type="email" name="email" value="{{ old('email', $doctor->email) }}" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="text-gray-700 font-black">CNIC:</label>
                    <input type="text" name="cnic" value="{{ old('cnic', $doctor->cnic) }}" class="form-control" placeholder="xxxxx-xxxxxxx-x">
                </div>

                <div class="col-md-3">
                    <label class="text-gray-700 font-black">PMDC Number:<span class="text-danger"> *</span></label>
                    <input type="text" name="pmdc" value="{{ old('pmdc', $doctor->pmdc) }}" class="form-control" required>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-9">
                    <label class="text-gray-700 font-black">Qualification:</label>
                    <textarea name="schedule" class="form-control" rows="3">{{ old('schedule', $doctor->schedule) }}</textarea>
                    <!-- <input type="text" name="schedule" value="{{ old('schedule', $doctor->schedule) }}" class="form-control"> -->
                </div>

                <div class="col-md-3">
                    <label class="text-gray-700 font-black">Speciality:<span class="text-danger"> *</span></label>
                    <select name="speciality_id" class="form-control" required>
                        <option value="">-- Please Select --</option>
                        @foreach ($specialities as $speciality)
                            <option value="{{ $speciality->id }}" {{ $doctor->speciality_id == $speciality->id ? 'selected' : '' }}>
                                {{ $speciality->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <label class="text-gray-700 font-black">Address:</label>
                    <textarea name="address" class="form-control" rows="3">{{ old('address', $doctor->address) }}</textarea>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <label class="text-gray-700 font-black">Remarks:</label>
                    <textarea name="remarks" class="form-control" rows="3">{{ old('remarks', $doctor->remarks) }}</textarea>
                </div>
            </div>

            <div class="row mt-5 text-center">
                <div class="col-md-12">
                    <a href="{{ route('admin.doctors.index') }}" class="btn btn-warning text-primary mx-2">Back</a>
                    <button type="submit" class="btn btn-success mx-2">Update</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
