<x-app-layout>
  <main>
    <div class="container bg-white shadow-md rounded my-6 px-5 py-4">
      <div class="row pb-4">
        <p class="h3 text-danger">
          <strong><em>Manage <span class="text-success">Wards</span></em></strong>
        </p>
        <hr />
      </div>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.ipd.index') }}" class="btn btn-secondary mb-3">Back to IPD Dashboard</a>
        @can('Ward create')
          <a href="{{ route('admin.wards.create') }}" class="btn btn-success">+ Add Ward</a>
        @endcan
      </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>S.No.</th>
            <th>Ward Name</th>
            <th>Capacity</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($wards as $ward)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $ward->name }}</td>
            <td>{{ $ward->type }}</td>
            <td>
              @can('Ward edit')
                <a href="{{ route('admin.wards.edit', $ward->id) }}" class="btn btn-warning btn-sm">Edit</a>
              @endcan
              @can('Ward delete')
                <form action="{{ route('admin.wards.destroy', $ward->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this ward?')">Delete</button>
                </form>
              @endcan
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </main>
</x-app-layout>
