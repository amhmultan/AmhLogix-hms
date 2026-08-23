<x-app-layout>
   <div>
        <main>
            <div class="container mx-auto px-6 py-5">
                <div class="mb-4 text-right">
                  @can('User create')
                    <a href="{{route('admin.users.create')}}" class="text-decoration-none bg-black text-white font-bold px-5 py-2 rounded focus:outline-none shadow hover:bg-blue-500 transition-colors" accesskey="n"><u>N</u>ew User</a>
                  @endcan
                </div>
              
              <div class="table-responsive bg-white shadow-md rounded border-collapse p-4">
                <table id="userTable" class="table w-100 border-collapse py-4">
                  <thead>
                    <tr class="bg-indigo-500 text-white">
                      <th class="text-center">Name</th>
                      <th class="text-center">User Name</th>
                      <th class="text-center">Role</th>
                      <th class="text-center">Actions</th>
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
                        <td class="px-4 py-2 border text-center">
                          @can('User edit')
                          <a href="{{route('admin.users.edit',$user->id)}}" title="Edit User" class="text-decoration-none text-2xl px-3 py-1 text-blue-500">
                            <i class="fa-solid fa-pen-to-square"></i>
                          </a>
                          @endcan

                          @can('User delete')
                          <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                              @csrf
                              @method('delete')
                              <button class="text-decoration-none text-2xl px-3 py-1 text-red-500" type="submit" title="Delete User" onclick="return confirm('Are you sure you want to delete this user?')">
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
