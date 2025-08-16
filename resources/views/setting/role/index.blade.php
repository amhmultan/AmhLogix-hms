<x-app-layout>
   <div>
        <main class="flex-1 bg-gray-200">
            <div class="container mx-auto px-6 py-5">
                <div class="text-right">
                  @can('Role create')
                    <a href="{{route('admin.roles.create')}}" class="text-decoration-none bg-blue-500 text-white font-bold px-5 py-1 rounded focus:outline-none shadow hover:bg-blue-500 transition-colors ">New Role</a>
                </div>
                @endcan

              <div class="bg-white shadow-md rounded my-6">
                <table class="text-left w-full border-collapse">
                  <thead>
                    <tr>
                      <th class="py-4 px-6 bg-grey-lightest font-bold text-xl text-grey-dark border-b border-grey-light w-2/12">Role Name</th>
                      <th class="py-4 px-6 bg-grey-lightest font-bold text-xl text-grey-dark border-b border-grey-light w-8/12 text-center">Permissions</th>
                      <th class="py-4 px-6 bg-grey-lightest font-bold text-xl text-grey-dark border-b border-grey-light w-3/12 text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @can('Role access')
                      @foreach($roles as $role)
                      <tr class="hover:bg-grey-lighter">
                        <td class="py-4 px-6 border-b border-grey-light">{{ $role->name }}</td>
                        <td class="py-4 px-6 border-b border-grey-light text-center">
                              <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-white bg-gray-500 rounded-full">{{ $role->permissions->count() }}</span>
                        </td>
                        <td class="py-4 px-6 border-b border-grey-light text-right">

                          @can('Role edit')
                          <a href="{{route('admin.roles.edit',$role->id)}}" class="text-decoration-none text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-green hover:bg-green-dark text-blue-400">Edit</a>
                          @endcan

                          @can('Role delete')
                          <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="inline">
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
</x-app-layout>
