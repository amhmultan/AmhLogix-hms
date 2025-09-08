<x-app-layout>
<main>
<div class="container-fluid bg-white shadow-md rounded my-6 px-5 py-4">

  <div class="row pb-4">
    <h3 class="text-danger">
      <strong><em>In-Patient <span class="text-success">Admissions</span></em></strong>
    </h3>
    <hr />
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('admin.ipd.index') }}" class="btn btn-secondary mb-3">Back to IPD Dashboard</a>
    @can('IPD_Admission create')
      <a href="{{ route('admin.admissions.create') }}" 
        class="btn btn-lg btn-gradient bg-gradient-to-r from-purple-600 to-indigo-500 text-white font-bold shadow hover:from-purple-700 hover:to-indigo-600 transition-all">Admit New Patient</a>
    @endcan
  </div>
  <table class="table table-bordered table-striped">
    <thead class="bg-indigo-600 text-white">
      <tr>
        <th>#MR</th>
        <th>Patient Name</th>
        <th>Doctor</th>
        <th>Ward / Bed</th>
        <th>Admission Fees</th>
        <th>Status</th>
        <th>Admission Date</th>
        <th>Discharge Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($admissions as $admission)
      <tr>
        <td>{{ $admission->patient->id }}</td>
        <td>{{ $admission->patient->name }}</td>
        <td>{{ $admission->doctor->name ?? 'N/A' }}</td>
        <td>{{ $admission->bed->ward->name ?? '-' }} / {{ $admission->bed->bed_number ?? '-' }}</td>
        <td>{{ number_format($admission->admission_fees ?? 0, 2) }}</td>
        <td>
          @if($admission->status == 'admitted')
            <span class="badge bg-success">Admitted</span>
          @else
            <span class="badge bg-secondary">Discharged</span>
          @endif
        </td>
        <td>{{ $admission->admission_date->format('d-m-Y H:i') }}</td>
        <td>{{ $admission->discharge_date ? $admission->discharge_date->format('d-m-Y H:i') : '-' }}</td>

        <td class="space-x-1">
          {{-- Edit --}}
          @can('IPD_Admission edit')
          <a href="{{ route('admin.admissions.edit', $admission->id) }}" 
             class="btn btn-sm btn-info mb-1">Edit</a>
          @endcan

          @if($admission->status == 'admitted')
            {{-- Admission Slip (Admitted Only) --}}
            @can('IPD_Admission access')
              <a href="{{ route('admin.admissions.print', $admission->id) }}" class="btn btn-sm btn-primary mb-1">Admission Slip</a>
            @endcan
            {{-- Discharge button --}}
            @can('Discharge access')
              <a href="{{ route('admin.admissions.discharge', $admission->id) }}" class="btn btn-sm btn-warning mb-1">Discharge</a>
            @endcan
          @endif
            {{-- Discharge Slip (Discharged Only) --}}
            @if($admission->status == 'discharged')
              @can('Discharge access')
                <a href="{{ route('admin.admissions.discharge-slip', $admission->id) }}" class="btn btn-sm btn-success mb-1">Discharge Slip</a>
              @endcan
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

</div>
</main>
</x-app-layout>
