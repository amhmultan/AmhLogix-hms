<x-app-layout>
  @push('styles')
  <style>
    table.dataTable td {
    white-space: normal !important;
    word-break: break-word;
    vertical-align: middle;
    }

    table.dataTable th {
        white-space: nowrap;
    }

    .dataTables_wrapper {
        width: 100%;
    }
  </style>
  @endpush
  <main>
      <div class="container-fluid py-4 px-5">

            <div class="row mb-5">
              <div class="col-sm-6">
                <p class="h3 text-danger"><strong><em>Patients <span class="text-success">Dashboard</span></em></strong></p>
              </div>
              <div class="col-sm-6 text-right">
                @can('Patient create')
                  <a href="{{route('admin.patients.create')}}" class="text-decoration-none bg-black text-white font-bold px-5 py-2 rounded focus:outline-none shadow hover:bg-blue-500 transition-colors" accesskey="n"><u>N</u>ew Patient</a>
                @endcan
              </div>
            </div>
          
          @if (!$patients->isEmpty())
          <div class="bg-white shadow-md rounded p-3 overflow-hidden">
          <table id="patientTable" class="table table-bordered table-striped nowrap w-100">
            <thead>
            <tr class="bg-indigo-500 text-white">
                <th>MR No.</th>
                <th>PATIENT NAME</th>
                <th>FATHERS NAME</th>
                <th>AGE</th>
                <th>GENDER</th>
                <th>MARITAL STATUS</th>
                <th>PHONE</th>
                <th>EMAIL</th>
                <th>CNIC #</th>
                <th>ADDRESS</th>
                <th>REGISTERED ON</th>
                <th>REGISTERED BY</th>
                <th>UPDATED ON</th>
                <th>ACTIONS</th>
            </tr>
            </thead>
            <tbody>
              @can('Patient access')
                @foreach($patients as $patient)
                  <tr class="text-center">
                    <td class="px-4 py-2 border">{{ $patient->id }}</td>
                    <td class="px-4 py-2 border">{{ $patient->name }}</td>
                    <td class="px-4 py-2 border">{{ $patient->fname }}</td>
                    <td class="px-4 py-2 border">
                      @if($patient->dob == null)
                        {{ '' }}
                      @else
                        {{\Carbon\Carbon::parse($patient->dob)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days');}}
                      @endif
                    </td>
                    <td class="px-4 py-2 border">{{ $patient->gender }}</td>
                    <td class="px-4 py-2 border">{{ $patient->marital_status }}</td>
                    <td class="px-4 py-2 border">{{ $patient->phone }}</td>
                    <td class="px-4 py-2 border">{{ $patient->email }}</td>
                    <td class="px-4 py-2 border">{{ $patient->cnic }}</td>
                    <td class="px-4 py-2 border">{{ $patient->address }}</td>
                    <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($patient->created_at)->format('d-m-Y h:i A') }}</td>
                    <td class="px-4 py-2 border">{{ $patient->usersName }}</td>
                    <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($patient->updated_at)->format('d-m-Y h:i A') }}</td>
                    <td class="px-4 py-2 border">
                      @can('Patient access')
                        <a href="{{route('admin.patients.show',$patient->id)}}" class="btn btn-sm btn-primary mb-1">Show</a>
                      @endcan
                      @can('Patient edit')
                      <a href="{{route('admin.patients.edit',$patient->id)}}" class="btn btn-sm btn-warning mb-1">Edit</a>
                      @endcan
  
                      @can('Patient delete')
                      <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST" class="inline">
                          @csrf
                          @method('delete')
                          <button class="btn btn-sm btn-danger mb-1">Delete</button>
                      </form>
                      @endcan
                    </td>
                  </tr>
                @endforeach
                @endcan
            </tbody>
          </table>
          </div>
        @else

          <div class="row flex text-center mt-5 pt-5">
            <div class="col-sm-12">
              <h1 class="h4 italic text-danger">NO RECORD FOUND</h1>
            </div>
          </div>
        
        @endif

      </div>
  </main>
</div>
@push('scripts')

  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

  <script>
  $(document).ready(function () {

      $('#patientTable').DataTable({
          responsive: true,
          autoWidth: false,
          pageLength: 10,
          order: [[0, 'desc']],
          columnDefs: [
              { responsivePriority: 1, targets: 0 },   // MR No
              { responsivePriority: 2, targets: 1 },   // Patient Name
              { responsivePriority: 3, targets: 13 },  // Actions
              { responsivePriority: 4, targets: 6 },   // Phone
          ]
      });

  });
  </script>

@endpush
</x-app-layout>