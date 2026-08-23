<x-app-layout>
  <div>
    <main class="">
      <div class="container mx-auto px-6 py-5">
        <div class="text-right mb-4">
          @can('Permission create')
          <a href="{{route('admin.permissions.create')}}" class="text-decoration-none bg-black text-white font-bold px-5 py-2 rounded focus:outline-none shadow hover:bg-blue-500 transition-colors" accesskey="n"><u>N</u>ew Permission</a>
          @endcan
        </div>
        <div class="table-responsive bg-white shadow-md rounded p-3">

          <table class="table w-100" id="permissionsTable">
            <thead>
              <tr class="bg-indigo-500 text-white">
                <th class="text-start">Permission Name</th>

                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>

              @can('Permission access')
              @foreach($permissions as $permission)
              <tr class="hover:bg-grey-lighter">
                <td class="py-4 px-6 border-b border-grey-light">{{ $permission->name }}</td>
                <td class="py-4 px-6 border-b border-grey-light text-right">
                  @can('Permission edit')
                  <a href="{{route('admin.permissions.edit',$permission->id)}}" class="text-decoration-none text-1xl px-3 py-1 text-blue-500">
                    <i class="fa-solid fa-pen-to-square"></i>  Edit
                  </a>
                  @endcan

                  @can('Permission delete')
                  <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="inline">
                    @csrf
                    @method('delete')
                    <button class="text-decoration-none text-1xl px-3 py-1 text-red-500" type="submit" title="Delete Permission" onclick="return confirm('Are you sure you want to delete this permission?')">
                      <i class="fa-solid fa-trash-can"></i>  Delete
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
    $(document).ready(function() {
      $('#permissionsTable').DataTable({
        order: [
          [1, 'desc']
        ],
      });
    });
  </script>
  @endpush
</x-app-layout>