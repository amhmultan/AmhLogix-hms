<x-app-layout>
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
          <div class="table-responsive bg-white shadow-md rounded border-collapse p-3"> 
          <table id="patientTable" class="table w-100 border-collapse">
            <thead>
              <tr class="bg-indigo-500 text-white">
                <th class="py-3 px-4 border text-center">MR No.</th>
                <th class="py-3 px-4 border text-center">PATIENT NAME</th>
                <th class="py-3 px-4 border text-center">FATHERS NAME</th>
                <th class="py-3 px-4 border text-center">AGE</th>
                <th class="py-3 px-4 border text-center">GENDER</th>
                <th class="py-3 px-4 border text-center">MARITAL STATUS</th>
                <th class="py-3 px-4 border text-center">PHONE</th>
                <th class="py-3 px-4 border text-center">EMAIL</th>
                <th class="py-3 px-4 border text-center">CNIC #</th>
                <th class="py-3 px-4 border text-center">ADDRESS</th>
                <th class="py-3 px-4 border text-center">REGISTERED ON</th>
                <th class="py-3 px-4 border text-center">REGISTERED BY</th>
                <th class="py-3 px-4 border text-center">UPDATED ON</th>
                <th class="py-3 px-4 border text-center">ACTIONS</th>
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
                    <td class="px-4 py-2 border">{{ $patient->created_at }}</td>
                    <td class="px-4 py-2 border">{{ $patient->usersName }}</td>
                    <td class="px-4 py-2 border">{{ $patient->updated_at }}</td>
                    
                    <td class="px-4 py-2 border">
                      @can('Patient access')
                        <a href="{{route('admin.patients.show',$patient->id)}}" class="text-decoration-none text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-green hover:bg-green-dark text-green-400">Show</a>
                      @endcan
                      @can('Patient edit')
                      <a href="{{route('admin.patients.edit',$patient->id)}}" class="text-decoration-none text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-green hover:bg-green-dark text-blue-400">Edit</a>
                      @endcan
  
                      @can('Patient delete')
                      <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST" class="inline">
                          @csrf
                          @method('delete')
                          <button class="text-decoration-none text-grey-lighter font-bold py-1 px-1 rounded text-xs bg-blue hover:bg-blue-dark text-red-400">Delete</button>
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
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready( function () {
    $('#patientTable').DataTable({
        autoWidth: false,
        order: [[0, 'desc']],
      });
} );
</script>
@endpush
</x-app-layout>