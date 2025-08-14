<x-app-layout>
   <div>
        <main class="flex-1 bg-gray-200">
            <div class="container mx-auto px-6 py-5">
                <div class="mb-4 text-right">
                  @can('User create')
                    <a href="{{route('admin.users.create')}}" class="text-decoration-none bg-black text-white font-bold px-5 py-2 rounded focus:outline-none shadow hover:bg-blue-500 transition-colors" accesskey="n"><u>N</u>ew User</a>
                  @endcan
                </div>

              <div class="table-responsive bg-white shadow-md rounded border-collapse p-3">
                <table id="userTable" class="table w-100 border-collapse">
                  <thead>
                    <tr class="bg-indigo-500 text-white">
                      <th class="py-3 px-4 border text-center">Name</th>
                      <th class="py-3 px-4 border text-center">User Name</th>
                      <th class="py-3 px-4 border text-center">Role</th>
                      <th class="py-3 px-4 border text-right">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    @can('User access')
                      @foreach($users as $user)
                      <tr class="hover:bg-grey-lighter">
                        <td class="px-4 py-2 border text-center">{{ $user->name }}</td>
                        <td class="px-4 py-2 border text-center">{{ $user->email }}</td>
                        <td class="px-4 py-2 border text-center">
                            @foreach($user->roles as $role)
                              <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-white bg-gray-500 rounded-full">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-4 py-2 border text-right">
                          @can('User edit')
                          <a href="{{route('admin.users.edit',$user->id)}}" class="text-decoration-none text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-green hover:bg-green-dark text-blue-400">Edit</a>
                          @endcan

                          @can('User delete')
                          <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
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
      $('#userTable').DataTable(
      {
        order: [[0, 'desc']],
      });
  } );
  </script>
  @endpush
</x-app-layout>
