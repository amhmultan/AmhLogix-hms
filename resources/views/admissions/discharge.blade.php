<x-app-layout>
  <main>
    <div class="container-fluid bg-white shadow-md rounded my-6 px-5 py-4">

      <div class="row pb-1">
        <p class="h3 text-danger">
          <strong><em>Discharge <span class="text-success">Patient</span></em></strong>
        </p>
        <hr />
      </div>

      {{-- Patient Info --}}
      <div class="row my-2">
        <div class="col-md-3">
          <label class="text-gray-700 font-black">Patient Name:</label>
          <input type="text" class="form-control" value="{{ $admission->patient->name }}" disabled>
        </div>
        <div class="col-md-3">
          <label class="text-gray-700 font-black">Contact Number:</label>
          <input type="text" class="form-control" value="{{ $admission->patient->phone }}" disabled>
        </div>
        <div class="col-md-3">
          <label class="text-gray-700 font-black">CNIC:</label>
          <input type="text" class="form-control" value="{{ $admission->patient->cnic }}" disabled>
        </div>
        <div class="col-md-3">
          <label class="text-gray-700 font-black">Reffered By:</label>
          <input type="text" class="form-control" value="{{ $admission->patient->reffered_by }}" disabled>
        </div>
      </div>
      <div class="row my-2">
        <div class="col-md-3">
          <label class="text-gray-700 font-black">Doctor:</label>
          <input type="text" class="form-control" value="{{ $admission->doctor->name ?? 'N/A' }}" disabled>
        </div>
        <div class="col-md-3">
          <label class="text-gray-700 font-black">Bed:</label>
          <input type="text" class="form-control" value="{{ $admission->bed->bed_number }} ({{ ucfirst($admission->bed->ward->name) }})" disabled>
        </div>
        <div class="col-md-3">
          <label class="text-gray-700 font-black">Admission On:</label>
          <input type="text" class="form-control" value="{{ $admission->admission_date->format('d-m-Y h:i A') }}" disabled>
        </div>
        <div class="col-md-3">
          <label class="text-gray-700 font-black">Discharge On:</label>
          <input type="text" class="form-control" value="{{ now()->format('d-m-Y h:i A') }}" disabled>
        </div>
      </div>
      <div class="row my-4">
        <div class="col-md-12">
          <label class="text-gray-700 font-black">Diagnosis:</label>
          <textarea class="form-control" rows="3" disabled>{{ $admission->diagnosis }}</textarea>
        </div>
      </div>

      <hr />

      <form method="POST" action="{{ route('admin.admissions.discharge.store', $admission->id) }}">
        @csrf
        <div class="row my-4">
          <div class="col-md-3">
            <label class="text-gray-700 font-black">DM:</label>
            <input type="text" name="dm" placeholder="DM">
          </div>
          <div class="col-md-3">
            <label class="text-gray-700 font-black">HTN:</label>
            <input type="text" name="htn" placeholder="HTN">
          </div>
          <div class="col-md-3">
            <label class="text-gray-700 font-black">IHD:</label>
            <input type="text" name="ihd" placeholder="IHD">
          </div>
          <div class="col-md-3">
            <label class="text-gray-700 font-black">ASTHMA:</label>
            <input type="text" name="asthma" placeholder="Asthma">
          </div>
        </div>

        <div class="row my-4">
          <div class="col-md-6">
            <label class="text-gray-700 font-black">Clinical Notes:</label>
            <textarea name="clinical_notes" class="form-control" rows="3"></textarea>
          </div>
          <div class="col-md-6">
            <label class="text-gray-700 font-black">Follow-up Instructions:</label>
            <textarea name="follow_up" class="form-control" rows="3"></textarea>
          </div>
        </div>

        <div class="row my-4">
          <div class="col-md-12">
            <label class="text-gray-700 font-black">Medications on Discharge:</label>
            <!-- <textarea name="medications" class="form-control" rows="3"></textarea> -->
            <!-- PRODUCTS -->
            <div id="prescriptionProductsSection" class="section-block">
              @include('admissions.partials.prescription_products')
            </div>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-12 text-center">
            <a class="btn btn-warning mx-2" href="{{ route('admin.admissions.index') }}" accesskey="b">Back</a>
            <button type="submit" class="btn btn-danger mx-2">Discharge</button>
          </div>
        </div>
      </form>
    </div>
  </main>
  <script>
    // Products search script
    document.addEventListener('DOMContentLoaded', function() {
      // ===============================
      // LIVE SEARCH (GLOBAL DELEGATION)
      // ===============================
      $(document).on('keyup', '.product-input', function() {

        let input = $(this);
        let row = input.closest('.medicine-row');
        let box = row.find('.product-suggestions');

        let query = input.val();

        if (query.length < 1) {
          box.hide();
          return;
        }

        $.ajax({
          url: "{{ route('admin.products.search') }}",
          data: {
            term: query
          },

          success: function(data) {

            console.log("RESULTS:", data);

            box.html('').show();

            if (!data || data.length === 0) {
              box.hide();
              return;
            }

            data.forEach(function(item) {

              box.append(`
                    <a href="javascript:void(0)"
                       class="list-group-item list-group-item-action product-item"
                       data-id="${item.id}"
                       data-name="${item.name}"
                       style="cursor:pointer;">
                        ${item.name}
                    </a>
                `);

            });

          },
          error: function(xhr) {
            console.log("AJAX ERROR:", xhr.responseText);
          }
        });

      });


      // ===============================
      // SELECT ITEM (FIXED & SAFE)
      // ===============================
      $(document).on('click', '.product-item', function(e) {

        e.preventDefault();

        let row = $(this).closest('.medicine-row');

        row.find('.product-input').val($(this).data('name'));
        row.find('.product-id').val($(this).data('id'));

        row.find('.product-suggestions').hide();

      });


      // ===============================
      // CLOSE DROPDOWN OUTSIDE CLICK
      // ===============================
      $(document).on('click', function(e) {

        if (!$(e.target).closest('.medicine-row').length) {
          $('.product-suggestions').hide();
        }

      });


      // ===============================
      // REMOVE ROW
      // ===============================
      $(document).on('click', '.remove-row', function() {
        $(this).closest('.medicine-row').remove();
      });
    });
  </script>
  <script>
    // ===============================
    // ADD ROW (GLOBAL - FIXED)
    // ===============================
    let medicineIndex = document.querySelectorAll('.medicine-row').length;

    function addMedicineRow() {

      let template = document.querySelector('#medicine-template .medicine-row');
      let clone = template.cloneNode(true);

      // reset values
      clone.querySelectorAll('input').forEach(i => i.value = '');
      clone.querySelectorAll('select').forEach(s => s.selectedIndex = 0);

      // assign correct names (IMPORTANT)
      clone.querySelector('.product-id')
        .setAttribute('name', `items[${medicineIndex}][product_id]`);

      clone.querySelector('select')
        .setAttribute('name', `items[${medicineIndex}][dosage_id]`);

      clone.querySelector('input[placeholder="Duration"]')
        .setAttribute('name', `items[${medicineIndex}][duration]`);

      clone.querySelector('input[placeholder="Remarks"]')
        .setAttribute('name', `items[${medicineIndex}][remarks]`);

      document.getElementById('medicine-container').appendChild(clone);

      medicineIndex++;
    }
  </script>
</x-app-layout>