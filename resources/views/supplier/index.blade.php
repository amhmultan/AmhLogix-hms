<x-app-layout>
  <main>
      <div class="container-fluid py-4 px-5 overflow-x-auto w-full">

            <div class="row mb-5">
              <div class="col-sm-6">
                <p class="h3 text-danger"><strong><em>Supplier <span class="text-success">Information</span></em></strong></p>
              </div>
              <div class="col-sm-6 text-right">
                @can('Supplier add')
                  <a href="{{route('admin.suppliers.create')}}" class="text-decoration-none bg-black text-white font-bold px-5 py-2 rounded focus:outline-none shadow hover:bg-blue-500 transition-colors" accesskey="n"><u>N</u>ew Supplier</a>
                @endcan
              </div>
            </div>
          
          @if (!$suppliers->isEmpty())
          
          <table id="supplierTable" class="min-w-full bg-white shadow-md rounded text-left border-collapse">
            <thead>
              <tr>
                <th class="py-3 px-1 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">SUPPLIER ID</th>
                <th class="py-3 px-1 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">NAME</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">DESCRIPTION</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">FBR NO.</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">LICENSE NO.</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">ADDRESS</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">CONTACT NUMBER</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">REMARKS</th>
                <th class="py-3 px-3 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">REGISTERED ON</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">UPDATED ON</th>
                <th class="py-3 px-2 bg-indigo-500 font-bold text-sm text-white text-center border border-grey-light">ACTIONS</th>
              </tr>
            </thead>
            <tbody>
              @can('Supplier access')
                @foreach($suppliers as $supplier)
                  <tr>
                    <td class="text-nowrap text-xs px-4 border-grey-light">{{ $supplier->id }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $supplier->name }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $supplier->description }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $supplier->fbr_no }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $supplier->license_no }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $supplier->address }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $supplier->contact }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $supplier->remarks }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $supplier->created_at }}</td>
                    <td class="text-nowrap text-xs px-3 border-grey-light">{{ $supplier->updated_at }}</td>
                    
                    <td class="text-nowrap text-xs px-3 border-grey-light">
                      
                      @can('Supplier edit')
                      <a href="{{route('admin.suppliers.edit',$supplier->id)}}" class="text-decoration-none text-2xl px-3 py-1 text-blue-500" title="Edit Supplier">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      @endcan
  
                      @can('Supplier delete')
                      <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST" class="inline">
                          @csrf
                          @method('delete')
                          <button class="text-decoration-none text-2xl px-3 py-1 text-red-500" title="Delete Supplier" onclick="return confirm('Are you sure you want to delete this supplier?')">
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
    $('#supplierTable').DataTable();
} );
</script>
@endpush
</x-app-layout>