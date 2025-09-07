<x-app-layout>
  <main>
    <div class="container-fluid py-4 px-5">

      <div class="row mb-5">
        <div class="col-sm-6">
          <p class="h3 text-danger">
            <strong><em>Appointments <span class="text-success">Records</span></em></strong>
          </p>
        </div>
        <div class="col-sm-6 text-end">
          @can('Appointment create')
            <a href="{{ route('admin.appointments.create') }}"
               class="text-decoration-none bg-black text-white font-bold px-5 py-2 rounded shadow hover:bg-blue-500 transition"
               accesskey="a"><u>A</u>dd Appointment</a>
          @endcan
        </div>
      </div>

      @if($appointments->isNotEmpty())
        <div class="table-responsive bg-white p-3 shadow rounded">
          <table id="appointmentTable" class="table w-100 border-collapse">
            <thead>
              <tr class="bg-indigo-500 text-white text-sm text-center">
                <th class="py-3 px-4 border">ID</th>
                <th class="py-3 px-4 border">Patient</th>
                <th class="py-3 px-4 border">Doctor</th>
                <th class="py-3 px-4 border">Date</th>
                <th class="py-3 px-4 border">Time</th>
                <th class="py-3 px-4 border">Status</th>
                <th class="py-3 px-4 border">Notes</th>
                <th class="py-3 px-4 border">Created At</th>
                <th class="py-3 px-4 border">Updated At</th>
                <th class="py-3 px-4 border">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($appointments as $appointment)
                <tr class="text-center text-xs">
                  <td class="px-4 py-2 border">{{ $appointment->id }}</td>
                  <td class="px-4 py-2 border">{{ $appointment->patient_name ?? 'N/A' }}</td>
                  <td class="px-4 py-2 border">{{ $appointment->doctor->name ?? 'N/A' }}</td>
                  <td class="px-4 py-2 border">{{ $appointment->appointment_date }}</td>
                  <td class="px-4 py-2 border">{{ $appointment->appointment_time }}</td>
                  <td class="px-4 py-2 border">{{ ucfirst($appointment->status) }}</td>
                  <td class="px-4 py-2 border">{{ $appointment->notes ?? '—' }}</td>
                  <td class="px-4 py-2 border">{{ $appointment->created_at }}</td>
                  <td class="px-4 py-2 border">{{ $appointment->updated_at }}</td>
                  <td class="px-3 py-2 border">
                    @can('Appointment view')
                      <a href="{{ route('admin.appointments.show', $appointment->id) }}"
                         class="btn btn-sm btn-info mb-1">View</a>
                    @endcan
                    @can('Appointment edit')
                      <a href="{{ route('admin.appointments.edit', $appointment->id) }}"
                         class="btn btn-sm btn-warning mb-1">Edit</a>
                    @endcan
                    @can('Appointment delete')
                      <form action="{{ route('admin.appointments.destroy', $appointment->id) }}"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                      </form>
                    @endcan
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="row text-center mt-5 pt-5">
          <div class="col-12">
            <h4 class="text-danger">NO RECORD FOUND</h4>
          </div>
        </div>
      @endif

    </div>
  </main>

  @push('scripts')
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function () {
        $('#appointmentTable').DataTable({
          order: [[0, 'asc']],
        });
      });
    </script>
  @endpush
</x-app-layout>
