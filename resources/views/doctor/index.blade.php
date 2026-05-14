<x-app-layout>
  <main>
    <div class="container-fluid py-4">

      <div class="row mb-5">
        <div class="col-sm-6">
          <p class="h3 text-danger">
            <strong><em>Doctors <span class="text-success">Information</span></em></strong>
          </p>
        </div>
        <div class="col-sm-6 text-right">
          @can('Doctor create')
            <a href="{{ route('admin.doctors.create') }}"
               class="text-decoration-none bg-black text-white font-bold px-5 py-2 rounded shadow hover:bg-blue-500 transition"
               accesskey="a"><u>A</u>dd Doctor</a>
          @endcan
        </div>
      </div>

      @if(!$doctors->isEmpty())
        <div class="table-responsive bg-white p-3 shadow rounded">
          <table id="doctorTable" class="table w-100 border-collapse">
            <thead>
              <tr class="bg-indigo-500 text-white">
                <th class="py-3 px-2 border text-center">ID</th>
                <th class="py-3 px-2 border text-center">Picture</th>
                <th class="py-3 px-2 border text-center">Name</th>
                <th class="py-3 px-2 border text-center">Contact</th>
                <th class="py-3 px-2 border text-center">Email</th>
                <th class="py-3 px-2 border text-center">Address</th>
                <th class="py-3 px-2 border text-center">Date of Birth</th>
                <th class="py-3 px-2 border text-center">Specialty</th>
                <th class="py-3 px-2 border text-center">Qualification</th>
                <th class="py-3 px-2 border text-center">CNIC No.</th>
                <th class="py-3 px-2 border text-center">PMDC No.</th>
                <th class="py-3 px-2 border text-center">Remarks</th>
                <th class="py-3 px-2 border text-center">Created On</th>
                <th class="py-3 px-2 border text-center">Updated On</th>
                <th class="py-3 px-2 border text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($doctors as $doctor)
                <tr class="text-center">
                  <td class="px-2 py-2 border">{{ $doctor->id }}</td>
                  <td class="px-2 py-2 border">
                    @if($doctor->pic)
                      <img src="{{ asset('uploads/' . ($doctor->pic ?? 'default.png')) }}" style="width:50px;height:auto;">
                    @else
                      N/A
                    @endif
                  </td>
                  <td class="px-2 py-3 border">{{ $doctor->name }}</td>
                  <td class="px-2 py-3 border">{{ $doctor->contact }}</td>
                  <td class="px-2 py-3 border">{{ $doctor->email }}</td>
                  <td class="px-2 py-3 border">{{ $doctor->address }}</td>
                  <td class="px-2 py-3 border">{{ $doctor->dob }}</td>
                  <td class="px-2 py-3 border">{{ $doctor->sTitle }}</td>
                  <td class="px-2 py-3 border">{{ $doctor->schedule }}</td>
                  <td class="px-2 py-3 border">{{ $doctor->cnic }}</td>
                  <td class="px-2 py-3 border">{{ $doctor->pmdc }}</td>
                  <td class="px-2 py-3 border">{{ $doctor->remarks }}</td>
                  <td class="px-2 py-3 border">{{ $doctor->created_at }}</td>
                  <td class="px-2 py-3 border">{{ $doctor->updated_at }}</td>
                  <td class="px-2 py-3 border">
                    @can('Doctor edit')
                      <a href="{{ route('admin.doctors.edit', $doctor->id) }}"
                         class="btn btn-sm btn-warning mb-1">Edit</a>
                    @endcan

                    @can('Doctor delete')
                      <form action="{{ route('admin.doctors.destroy', $doctor->id) }}"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Are you sure you want to delete this doctor?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                      </form>
                    @endcan
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="row text-center mt-5 pt-5">
          <div class="col-12">
            <h4 class="text-danger">NO RECORD FOUND</h4>
          </div>
        </div>
      @endif

    </div>
  </main>


  @push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function () {
        $('#doctorTable').DataTable({
          order: [[0, 'asc']],
        });
      });
    </script>
  @endpush
</x-app-layout>
