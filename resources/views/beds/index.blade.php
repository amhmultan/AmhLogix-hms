<x-app-layout>
  <main>
    <div class="container bg-white shadow-md rounded my-6 px-5 py-4">
      <div class="row">
        <p class="h3 text-danger">
          <strong><em>Manage <span class="text-success">Beds</span></em></strong>
        </p>
        <hr />
      </div>
      <div class="d-flex justify-content-between align-items-center mb-3">
        {{-- Back to IPD Dashboard --}}
        <a href="{{ route('admin.ipd.index') }}" class="btn btn-secondary mb-3">Back to IPD Dashboard</a>
        <a href="{{ route('admin.beds.create') }}" class="btn btn-success mb-3"> + Add Bed</a>
      </div>
      
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>S.No.</th>
            <th>Ward</th>
            <th>Bed Number</th>
            <th>Rate per Day</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($beds as $bed)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $bed->ward->name }}</td>
            <td>{{ $bed->bed_number }}</td>
            <td>{{ $bed->rate_per_day }}</td>
            <td>
              <span class="badge {{ $bed->status == 'available' ? 'bg-success' : 'bg-danger' }}">
                {{ ucfirst($bed->status) }}
              </span>
            </td>
            <td>
              <a href="{{ route('admin.beds.edit', $bed->id) }}" class="btn btn-warning btn-sm">Edit</a>
              <form action="{{ route('admin.beds.destroy', $bed->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this bed?')">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </main>
</x-app-layout>
