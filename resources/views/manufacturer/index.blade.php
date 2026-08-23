<x-app-layout>
  <main>
      <div class="container-fluid py-4 px-5 overflow-x-auto w-full">

            <div class="row mb-5">
              <div class="col-sm-6">
                <p class="h3 text-danger"><strong><em>Manufacturer <span class="text-success">Information</span></em></strong></p>
              </div>
              <div class="col-sm-6 text-right">
                @can('Manufacturer add')
                  <a href="{{route('admin.manufacturers.create')}}" class="text-decoration-none bg-black text-white font-bold px-5 py-2 rounded focus:outline-none shadow hover:bg-blue-500 transition-colors" accesskey="n"><u>N</u>ew Manufacturer</a>
                @endcan
              </div>
            </div>
          
          @if (!$manufacturers->isEmpty())
          <div class="table-responsive bg-white p-3 shadow rounded">
              <table id="manufacturerTable" class="table w-100 border-collapse py-5 my-2">
                  <thead>
                    <tr class="bg-indigo-500 text-white">
                      <th class="py-3 px-4 border text-center">ID</th>
                      <th class="py-3 px-4 border text-center">NAME</th>
                      <th class="py-3 px-4 border text-center">DESCRIPTION</th>
                      <th class="py-3 px-4 border text-center">FBR NO.</th>
                      <th class="py-3 px-4 border text-center">ADDRESS</th>
                      <th class="py-3 px-4 border text-center">LOGO</th>
                      <th class="py-3 px-4 border text-center">CONTACT NUMBER</th>
                      <th class="py-3 px-4 border text-center">EMAIL</th>
                      <th class="py-3 px-4 border text-center">WEBSITE</th>
                      <th class="py-3 px-4 border text-center">REMARKS</th>
                      <th class="py-3 px-4 border text-center">REGISTERED ON</th>
                      <th class="py-3 px-4 border text-center">UPDATED ON</th>
                      <th class="py-3 px-4 border text-center">ACTIONS</th>
                    </tr>
            </thead>
            <tbody>
              @can('Manufacturer access')
                @foreach($manufacturers as $manufacturer)
                  <tr class="text-center">
                    <td class="px-4 py-2 border">{{ $manufacturer->id }}</td>
                    <td class="px-4 py-2 border">{{ $manufacturer->name }}</td>
                    <td class="px-4 py-2 border">{{ $manufacturer->description }}</td>
                    <td class="px-4 py-2 border">{{ $manufacturer->fbr_no }}</td>
                    <td class="px-4 py-2 border">{{ $manufacturer->address }}</td>
                    <td class="img img-responsive"><img src="{{ asset('img/'.$manufacturer->logo) }}"></td>
                    <td class="px-4 py-2 border">{{ $manufacturer->contact }}</td>
                    <td class="px-4 py-2 border">{{ $manufacturer->email }}</td>
                    <td class="px-4 py-2 border">{{ $manufacturer->website }}</td>
                    <td class="px-4 py-2 border">{{ $manufacturer->remarks }}</td>
                    <td class="px-4 py-2 border">{{ $manufacturer->created_at }}</td>
                    <td class="px-4 py-2 border">{{ $manufacturer->updated_at }}</td>
                    
                    <td class="px-4 py-2 border">
                      
                      @can('Manufacturer edit')
                      <a href="{{route('admin.manufacturers.edit',$manufacturer->id)}}" class="text-decoration-none text-2xl px-3 py-1 text-blue-500" title="Edit Manufacturer">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      @endcan
  
                      @can('Manufacturer delete')
                      <form action="{{ route('admin.manufacturers.destroy', $manufacturer->id) }}" method="POST" class="inline">
                          @csrf
                          @method('delete')
                          <button class="text-decoration-none text-2xl px-3 py-1 text-red-500" title="Delete Manufacturer" onclick="return confirm('Are you sure you want to delete this manufacturer?')">
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
  </main>
</div>
@push('scripts')
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready( function () {
    $('#manufacturerTable').DataTable();
} );
</script>
@endpush
</x-app-layout>