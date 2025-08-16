<x-app-layout>
   <div>
        <main class="flex-1 bg-gray-200">
            <div class="container mx-auto px-6 py-5">
                <div class="text-right mb-4">
                  @can('Permission create')
                    <a href="{{route('admin.permissions.create')}}" class="text-decoration-none bg-black text-white font-bold px-5 py-2 rounded focus:outline-none shadow hover:bg-blue-500 transition-colors" accesskey="n"><u>N</u>ew Permission</a>
                  @endcan
                </div>
                <div class="table-responsive bg-white shadow-md rounded border-collapse p-3">
              
                <table class="table w-100 border-collapse" id="permissionsTable">
                  <thead>
                    <tr class="bg-indigo-500 text-white">
                      <th class="py-4 px-6 bg-grey-lightest font-bold text-xl text-grey-dark border-b border-grey-light">Permission Name</th>
                      
                      <th class="py-4 px-6 bg-grey-lightest font-bold text-xl text-grey-dark border-b border-grey-light text-right">Actions</th>
                    </tr>
                  </thead>
                  <tbody>

                    @can('Permission access')
                      @foreach($permissions as $permission)
                      <tr class="hover:bg-grey-lighter">
                        <td class="py-4 px-6 border-b border-grey-light">{{ $permission->name }}</td>
                        <td class="py-4 px-6 border-b border-grey-light text-right">
                          @can('Permission edit')
                          <a href="{{route('admin.permissions.edit',$permission->id)}}" class="text-decoration-none text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-green hover:bg-green-dark text-blue-400">Edit</a>
                          @endcan

                          @can('Permission delete')
                          <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="inline">
                              @csrf
                              @method('delete')
                              <button class="text-decoration-none text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-blue hover:bg-blue-dark text-red-400">Delete</button>
                          </form>
                          @endcan
                        </td>
                      </tr>
                      @endforeach
                    @endcan
                    
                  </tbody>
                </table>
              </div>
  
            </div>
        </main>
    </div>
</div>
@push('scripts')
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready( function () {
    $('#permissionsTable').DataTable(
    {
      order: [[0, 'asc']],
    });
} );
</script>
@endpush
</x-app-layout>
