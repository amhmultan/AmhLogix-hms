<x-app-layout>
  <main>
    <div class="container bg-white shadow-md rounded my-6 px-5 py-4">
      
      <form method="POST" action="{{ route('admin.tokens.update', $token->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <p class="h3 text-danger">
          <strong><em>Update <span class="text-success">Token</span></em></strong>
        </p>
        <hr />

        {{-- Patient Information (read-only) --}}
        <div class="row pt-4 pb-4">
          <div class="col-md-2">
            <label class="text-gray-700 font-black">MR#</label>
            <input type="text" class="form-control" value="{{ $token->fk_patients_id }}" disabled>
          </div>

          <div class="col-md-5">
            <label class="text-gray-700 font-black">Patient Name</label>
            <input type="text" class="form-control" value="{{ $token->patient->name ?? $token->pName }}" disabled>
          </div>

          <div class="col-md-5">
            <label class="text-gray-700 font-black">Contact Number</label>
            <input type="text" class="form-control" value="{{ $token->patient->phone ?? $token->phone }}" disabled>
          </div>
        </div>

        <div class="row pb-4">
          <div class="col-md-6">
            <label class="text-gray-700 font-black">Referred By</label>
            <input type="text" class="form-control" value="{{ $token->patient->reffered_by ?? $token->reffered_by }}" disabled>
          </div>

          <div class="col-md-6">
            <label class="text-gray-700 font-black">CNIC</label>
            <input type="text" class="form-control" value="{{ $token->patient->cnic ?? $token->cnic }}" disabled>
          </div>
        </div>

        <hr />

        {{-- Editable Fields --}}
        <div class="row my-4">
          <div class="col-md-6">
            <label for="fk_doctors_id" class="text-gray-700 font-black">Update Doctor:</label>
            <select class="form-control" name="fk_doctors_id" required>
              <option value="">-- Select Doctor --</option>
              @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}" 
                  {{ old('fk_doctors_id', $token->fk_doctors_id) == $doctor->id ? 'selected' : '' }}>
                  {{ $doctor->name }}
                </option>
              @endforeach
            </select>
            @error('fk_doctors_id')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="col-md-6">
            <label for="fk_specialty_id" class="text-gray-700 font-black">Update Speciality:</label>
            <select class="form-control" name="fk_specialty_id" required>
              <option value="">-- Select Speciality --</option>
              @foreach ($specialities as $speciality)
                <option value="{{ $speciality->id }}" 
                  {{ old('fk_specialty_id', $token->fk_specialty_id) == $speciality->id ? 'selected' : '' }}>
                  {{ $speciality->title ?? $speciality->stitle }}
                </option>
              @endforeach
            </select>
            @error('fk_specialty_id')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <label for="fees" class="text-gray-700 font-black">Fees:</label>
            <input id="fees" type="number" name="fees" 
              value="{{ old('fees', $token->fees) }}" 
              class="form-control @error('fees') is-invalid @enderror" 
              oninput="calculateBalance()" required>
            @error('fees')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="denomination" class="text-gray-700 font-black">Denomination:</label>
            <input id="denomination" type="number" name="denomination" 
              value="{{ old('denomination', $token->denomination) }}" 
              class="form-control @error('denomination') is-invalid @enderror" 
              oninput="calculateBalance()" required>
            @error('denomination')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="balance" class="text-gray-700 font-black">Balance:</label>
            <input id="balance" type="number" name="balance" 
              value="{{ old('balance', $token->balance) }}" 
              class="form-control" readonly>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-md-12 text-center">
            <a class="btn btn-info mx-2" href="{{ route('admin.tokens.index')}}" accesskey="b">
              <u>B</u>ack
            </a>
            <button type="submit" class="btn btn-success mx-2">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </main>

  @section('script')
    <script type="text/javascript">
      function calculateBalance() {
          let fees = parseFloat(document.getElementById('fees').value) || 0;
          let denomination = parseFloat(document.getElementById('denomination').value) || 0;
          let balance = fees - denomination;
          document.getElementById('balance').value = balance.toFixed(2);
      }
    </script>
  @endsection
</x-app-layout>
