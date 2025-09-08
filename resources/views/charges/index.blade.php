<x-app-layout>
<div class="container bg-white shadow-md rounded my-6 px-5 py-4">
    <div class="row pb-4">
        <p class="h3 text-danger">
          <strong><em>Manage Admitted <span class="text-success">Patients Charges</span></em></strong>
        </p>
        <hr />
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.ipd.index') }}" class="btn btn-secondary">Back to IPD Dashboard</a>
        @can('IPD_Billing create')
            <a href="{{ route('admin.charges.create') }}" class="btn btn-primary">Add Charges</a>
        @endcan
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Patient</th>
                <th>MR No</th>
                <th>Type</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($charges as $charge)
            <tr>
                <td>{{ $charge->id }}</td>
                <td>{{ $charge->admission->patient->name ?? '-' }}</td>
                <td>{{ $charge->admission->patient->id ?? '-' }}</td>
                <td>{{ $charge->type }}</td>
                <td>{{ $charge->description }}</td>
                <td>{{ number_format($charge->amount,2) }}</td>
                <td>
                    @can('IPD_Billing edit')
                        <a href="{{ route('admin.charges.edit', $charge->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    @endcan
                    @can('IPD_Billing delete')
                        <form action="{{ route('admin.charges.destroy', $charge->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this charge?')">Delete</button>
                        </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-app-layout>
