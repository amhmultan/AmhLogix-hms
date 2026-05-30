<x-app-layout>
  <main>
    <div class="container bg-white shadow-md rounded my-6 px-5 py-4">

      <div class="row pb-5">
        <p class="h3 text-danger">
          <strong><em>Add <span class="text-success">Token</span></em></strong>
        </p>
        <hr />
      </div>

      <div class="row mb-5">
        <div class="col-sm-3">
          <form action="" method="GET">
            <input type="search" name="search" id="search" placeholder="Enter MR Number" class="form-control">
        </div>
        <div class="col-sm-9">
          <button type="submit" class="btn btn-primary mx-2">Search</button>
          </form>
        </div>
      </div>

      <hr />

      <div class="row my-4">
        <div class="col-md-6">
          <label for="fk_patients_id" class="text-gray-700 font-black">Patient Name:</label>
          <select class="form-control" name="fk_patients_id" disabled>
            @if ($search != "")
              @foreach ($data['patients'] as $patient)
                <option>{{ $patient->name }}</option>
              @endforeach
            @else
              <option></option>
            @endif
          </select>
        </div>
        <div class="col-md-6">
          <label class="text-gray-700 font-black">Contact Number:</label>
          <select class="form-control" disabled>
            @if ($search != "")
              @foreach ($data['patients'] as $patient)
                <option>{{ $patient->phone }}</option>
              @endforeach
            @else
              <option></option>
            @endif
          </select>
        </div>
      </div>
      <div class="row my-4">
        <div class="col-md-6">
          <label class="text-gray-700 font-black">Panel:</label>
          <select class="form-control" disabled>
            @if ($search != "")
              @foreach ($data['patients'] as $patient)
                <option>{{ $patient->reffered_by }}</option>
              @endforeach
            @else
              <option></option>
            @endif
          </select>
        </div>
        <div class="col-md-6">
          <label class="text-gray-700 font-black">CNIC:</label>
          <select class="form-control" disabled>
            @if ($search != "")
              @foreach ($data['patients'] as $patient)
                <option>{{ $patient->cnic }}</option>
              @endforeach
            @else
              <option></option>
            @endif
          </select>
        </div>

      </div>

      <hr />

      <form method="POST" action="{{ route('admin.tokens.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Hidden Patient ID --}}
        <input type="hidden" name="fk_patients_id" value="{{ request('search') }}">

        <div class="row my-4">
          <div class="col-md-6">
            <label class="text-gray-700 font-black">Doctor:</label>
            <select id="doctorSelect" class="form-control" name="fk_doctors_id" required>
                @foreach ($data['doctors'] as $doctor)
                    <option value="{{ $doctor->id }}"
                            data-specialty-id="{{ $doctor->specialty->id ?? '' }}"
                            data-specialty="{{ $doctor->specialty->title ?? 'N/A' }}"
                            {{ $loop->first ? 'selected' : '' }}>
                        {{ $doctor->name }}
                    </option>
                @endforeach
            </select>
          </div>

          <div class="col-md-6">
            <label class="text-gray-700 font-black">Specialty:</label>
            <div class="form-control mt-2" id="specialtyTitle">--</div>
            <input type="hidden" name="fk_specialty_id" id="fk_specialty_id">
          </div>
        </div>

        <hr />

        <div class="row mt-4">
          <div class="col-md-4">
            <label for="fees" class="text-gray-700 font-black">Total Fees:</label>
            <input id="fees" type="number" name="fees" value="{{ old('fees') }}" class="form-control" oninput="calculateBalance()" required />
          </div>
          <div class="col-md-4">
            <label for="denomination" class="text-gray-700 font-black">Cash Received:</label>
            <input id="denomination" type="number" name="denomination" value="{{ old('denomination') }}" class="form-control" oninput="calculateBalance()" required />
          </div>
          <div class="col-md-4">
            <label for="balance" class="text-gray-700 font-black">Balance:</label>
            <input id="balance" type="number" name="balance" value="" class="form-control" readonly />
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-md-12 text-center">
            <a class="btn btn-warning mx-2" href="{{ route('admin.tokens.index')}}" accesskey="b" role="button"><u>B</u>ack</a>
            <button type="submit" class="btn btn-success mx-2">Submit</button>
          </div>
        </div>
      </form>

    </div>
  </main>

  @push('scripts')
    <script>
      function calculateBalance() {
        let fees = parseFloat(document.getElementById('fees').value) || 0;
        let denomination = parseFloat(document.getElementById('denomination').value) || 0;
        let balance = fees - denomination;
        document.getElementById('balance').value = balance.toFixed(2);
      }

      document.addEventListener('DOMContentLoaded', function () {
        const doctorSelect = document.getElementById('doctorSelect');
        const specialtyTitle = document.getElementById('specialtyTitle');
        const specialtyInput = document.getElementById('fk_specialty_id');
      });
      
      document.addEventListener('DOMContentLoaded', function () {

        const doctorSelect = document.getElementById('doctorSelect');
        const specialtyTitle = document.getElementById('specialtyTitle');
        const specialtyInput = document.getElementById('fk_specialty_id');

        function updateSpecialty() {
            const selected = doctorSelect.options[doctorSelect.selectedIndex];

            const specialtyText = selected.getAttribute('data-specialty') || '--';
            const specialtyId = selected.getAttribute('data-specialty-id') || '';

            specialtyTitle.textContent = specialtyText;
            specialtyInput.value = specialtyId;
        }

        // 🔁 Your existing logic (unchanged, just wrapped)
        doctorSelect.addEventListener('change', updateSpecialty);

        // 🔥 AUTO SELECT FIRST DOCTOR (if placeholder exists)
        if (doctorSelect.selectedIndex === 0 && doctorSelect.options.length > 1) {
            doctorSelect.selectedIndex = 1;
        }

        // 🔥 IMPORTANT: trigger on page load
        updateSpecialty();

    });
    </script>
  @endpush

</x-app-layout>