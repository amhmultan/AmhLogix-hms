<x-app-layout>
    @push('styles')
        <style>
            #products-table td, 
            #products-table th {
            vertical-align: middle !important;
            }
        </style>
    @endpush
    <main>
        <div class="container-fluid bg-grey py-4 px-5">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <p class="h3 text-danger">
                        <strong><em>Products <span class="text-success">Dashboard</span></em></strong>
                    </p>
                </div>
                <div class="col-sm-6 text-right">
                    @can('Product create')
                        <a href="{{ route('admin.products.create') }}"
                           class="text-decoration-none bg-black text-white font-bold px-5 py-2 rounded shadow hover:bg-blue-500">
                           Add Product
                        </a>
                    @endcan
                </div>
            </div>

            <div class="table-responsive shadow rounded p-3 bg-white mt-5" style="max-height: 600px; overflow-y: auto;">
                <table id="products-table" class="table table-bordered table-striped w-100 text-center align-middle" style="font-size: 0.9rem;">
                    <thead class="bg-indigo-500 text-white text-center sticky-top" style="top: 0; z-index: 10;">
                        <tr>
                            <th class="text-center" style="vertical-align: middle;">ID</th>
                            <th class="text-center" style="vertical-align: middle;">Manufacturer Name</th>
                            <th class="text-center" style="vertical-align: middle;">Brand Name</th>
                            <th class="text-center" style="vertical-align: middle;">Generic</th>
                            <th class="text-center" style="vertical-align: middle;">Class</th>
                            <th class="text-center" style="vertical-align: middle;">Pack Size</th>
                            <th class="text-center" style="vertical-align: middle;">Status</th>
                            <th class="text-center" style="vertical-align: middle;">Created At</th>
                            <th class="text-center" style="vertical-align: middle;">Updated At</th>
                            <th class="text-center" style="vertical-align: middle;">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </main>

    @push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.products.data') }}",
                columns: [
                    { data: 'id', name: 'products.id' },
                    { data: 'manufacturersName', name: 'manufacturers.name' },
                    { data: 'name', name: 'products.name' },
                    { data: 'generic', name: 'products.generic' },
                    { data: 'drug_class', name: 'products.drug_class' },
                    { data: 'pack_size', name: 'products.pack_size' },
                    { data: 'status', orderable: false, searchable: false },
                    { data: 'created_at', name: 'products.created_at' },
                    { data: 'updated_at', name: 'products.updated_at' },
                    { data: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 25,
                order: [[0, 'desc']]
            });
        });
    </script>
    @endpush
</x-app-layout>
