<x-app-layout>
  <main>
      <div class="container-fluid py-4 px-5">

            <div class="row mb-5">
              <div class="col-sm-6">
                <p class="h3 text-danger"><strong><em>Hospital <span class="text-success">Configuration</span></em></strong></p>
              </div>
              <div class="col-sm-6 text-right">
                @can('HospitalConfig create')
                  <a href="{{route('admin.hospitals.create')}}" class="text-decoration-none bg-black text-white font-bold px-5 py-2 rounded focus:outline-none shadow hover:bg-blue-500 transition-colors" accesskey="n"><u>N</u>ew Hospital</a>
                @endcan
              </div>
            </div>
          
          @if (!$hospitals->isEmpty())
            
          <table id="hospitalTable" class="table-responsive bg-white shadow-md rounded text-left w-full border-collapse">
            <thead>
              <tr>
                <th class="py-3 px-1 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">ID</th>
                <th class="py-3 px-1 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">TITLE</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">LOGO</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">PHC REG. NO</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">CONTACT NO</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">EMAIL</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">WEBSITE</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">ADDRESS</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">REMARKS</th>
                <th class="py-3 px-3 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">REGISTERED ON</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">UPDATED ON</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">ACTIONS</th>
              </tr>
            </thead>
            <tbody>
              @can('HospitalConfig access')
                @foreach($hospitals as $hospital)
                  <tr>
                    <td class="text-nowrap text-xs px-4 border-grey-light">{{ $hospital->id }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $hospital->title }}</td>
                    <td class="img img-responsive"><img src="{{ asset('img/'.$hospital->logo) }}" width="100px"></td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $hospital->phc_no }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $hospital->contact }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $hospital->email }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $hospital->website }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $hospital->address }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $hospital->remarks }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $hospital->created_at }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $hospital->updated_at }}</td>
                    
                    <td class="text-nowrap text-xs px-3 border-grey-light">
                      
                      @can('HospitalConfig edit')
                      <a href="{{route('admin.hospitals.edit',$hospital->id)}}" class="text-decoration-none text-2xl px-3 py-1 text-blue-500">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      @endcan
  
                      @can('HospitalConfig delete')
                      <form action="{{ route('admin.hospitals.destroy', $hospital->id) }}" method="POST" class="inline">
                          @csrf
                          @method('delete')
                          <button class="text-decoration-none text-2xl px-3 py-1 text-red-500" type="submit" title="Delete Hospital" onclick="return confirm('Are you sure you want to delete this hospital?')">
                            <i class="fa-solid fa-trash-can"></i>
                          </button>
                      </form>
                      @endcan
                    </td>
                  </tr>
                @endforeach
                @endcan
            </tbody>
          </table>
        
        @else

          <div class="row flex text-center mt-5 pt-5">
            <div class="col-sm-12">
              <h1 class="h4 italic text-danger">NO RECORD FOUND</h1>
            </div>
          </div>
        
        @endif

      </div>

      <div class="container-fluid py-4 px-5">
        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 gap-4">

            @can('Speciality access')
                <a href="{{ route('admin.specialities.index') }}"
                  class="no-underline hover:no-underline group block bg-gradient-to-r from-gray-700 to-gray-900 text-white font-extrabold text-4xl py-8 rounded-2xl shadow-xl hover:from-gray-800 hover:to-gray-950 transition-all text-center relative"
                  accesskey="s">
                  <i class="fa-solid fa-hospital-user fa-3x"></i>
                  <div>Specialities</div>
                </a>
            @endcan

            @can('Doctor access')
                <a href="{{ route('admin.doctors.index') }}"
                  class="no-underline hover:no-underline group block bg-gradient-to-r from-red-500 to-pink-500 text-white font-extrabold text-4xl py-8 rounded-2xl shadow-xl hover:from-red-600 hover:to-pink-600 transition-all text-center relative"
                  accesskey="o">
                  <i class="fas fa-user-md fa-3x"></i>
                  <div>Doctors</div>
                </a>
            @endcan
            
            @can('Dosage access')
                <a href="{{ route('admin.dosages.index') }}"
                  class="no-underline hover:no-underline group block bg-gradient-to-r from-green-500 to-green-700 text-white font-extrabold text-4xl py-8 rounded-2xl shadow-xl hover:from-green-600 hover:to-green-800 transition-all text-center relative"
                  accesskey="d">
                  <i class="fas fa-pills fa-3x"></i>
                  <div>Dosages</div>
                </a>
            @endcan
        </div>
      </div>
  </main>
</div>
@section('script')
  <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready( function () {
      $('#hospitalTable').DataTable();
  } );
</script>  
@stop
</x-app-layout>