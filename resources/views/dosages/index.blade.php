<x-app-layout>
    <main>
        <div class="container-fluid py-4 px-5">
            <div class="row mb-5">
                <div class="col-sm-6">
                    <p class="h3 text-danger">
                        <strong><em>Dos<span class="text-success">ages</span></em></strong>
                    </p>
                </div>
                <div class="col-sm-6 text-right">
                    @can('Dosage create')
                    <a href="{{ route('admin.dosages.create') }}"
                        class="text-decoration-none bg-black text-white font-bold px-5 py-2 rounded shadow hover:bg-blue-500 transition-colors"
                        accesskey="a"><u>A</u>dd Dosage
                    </a>
                    @endcan
                </div>
            </div>

            @if(!$dosages->isEmpty())
            <div class="table-responsive bg-white p-3 shadow rounded">
                <table id="dosages-table" class="table w-100 border-collapse py-5 my-2">
                    <thead>
                        <tr class="bg-indigo-500 text-white">
                            <th class="py-3 px-4 border text-center">ID</th>
                            <th class="py-3 px-4 border text-center">Name</th>
                            <th class="py-3 px-4 border text-center">Description</th>
                            <th class="py-3 px-4 border text-center">Status</th>
                            <th class="py-3 px-4 border text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @can('Dosage access')
                        @foreach($dosages as $dosage)
                        <tr class="text-center">
                            <td class="px-4 py-2 border">{{ $dosage->id }}</td>
                            <td class="px-4 py-2 border">{{ $dosage->name }}</td>
                            <td class="px-4 py-2 border">{{ $dosage->description }}</td>
                            <td class="px-4 py-2 border">
                                @if($dosage->status == 0)
                                <span class="text-white inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-white bg-green-500 rounded-full">Active</span>
                                @else
                                <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-white bg-gray-500 rounded-full">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @can('Dosage edit')
                                <a href="{{ route('admin.dosages.edit', $dosage->id) }}" class="text-decoration-none text-2xl px-3 py-1 text-blue-500" title="Edit Dosage">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                @endcan
                                @can('Dosage delete')
                                <form action="{{ route('admin.dosages.destroy', $dosage->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-decoration-none text-2xl px-3 py-1 text-red-500" title="Delete Dosage" onclick="return confirm('Are you sure you want to delete this dosage?')">
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
            @else
            <div class="text-center mt-5">
                <h4 class="text-danger italic">NO RECORD FOUND</h4>
            </div>
            @endif
        </div>
    </main>
    @push('scripts')
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dosages-table').DataTable();
        });
    </script>
    @endpush
</x-app-layout>