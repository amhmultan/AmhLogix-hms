<x-app-layout>
<main>
<div class="container-fluid py-4 px-5">

    <div class="row mb-5">
        <div class="col-sm-6">
            <p class="h3 text-danger">
                <strong><em>Prescr<span class="text-success">iptions</span></em></strong>
            </p>
        </div>

        <div class="col-sm-6 text-right">
            @can('DoctorNotes add')
                <a href="{{ route('admin.doctor_notes.create') }}"
                   class="text-decoration-none bg-black text-white font-bold px-5 py-2 rounded shadow hover:bg-blue-500 transition-colors">
                    Add Doctor Notes
                </a>
            @endcan
        </div>
    </div>

    @if(!$doctor_notes->isEmpty())

    <div class="table-responsive bg-white p-3 shadow rounded">

        <table id="doctorNotesTable" class="table w-100 border-collapse">

            <thead>
                <tr class="bg-indigo-500 text-white text-center">
                    <th class="px-4 py-2 text-center">PRESCRIPTION ID</th>
                    <th class="px-4 py-2 text-center">MR NO.</th>
                    <th class="px-4 py-2 text-center">TOKEN NO.</th>
                    <th class="px-4 py-2 text-center">PATIENT NAME</th>
                    <th class="px-4 py-2 text-center">PRESCRIPTION</th>
                    <th class="px-4 py-2 text-center">CHECKUP ON</th>
                    <th class="px-4 py-2 text-center">UPDATED ON</th>
                    <th class="px-4 py-2 text-center">ACTIONS</th>
                </tr>
            </thead>

            <tbody>

            @can('DoctorNotes access')

                @foreach($doctor_notes as $note)

                <tr class="text-center">

                    <td>{{ $note->id }}</td>

                    {{-- MR NO --}}
                    <td>{{ $note->fk_patient_id ?? 'N/A' }}</td>

                    {{-- TOKEN NO (SAFE LEFT JOIN) --}}
                    <td>{{ $note->fk_token_id ?? 'Not Assigned' }}</td>

                    {{-- FIXED FIELD NAME --}}
                    <td>{{ $note->patient_name ?? 'Walk-in Patient' }}</td>

                    {{-- PRESCRIPTION VIEW --}}
                    <td>
                      @if($note->mode === 'upload' && !empty($note->prescription))

                          @php
                              $filePath = public_path('assets/doctor_notes/'.$note->prescription);
                          @endphp

                          @if(file_exists($filePath))
                              <a href="{{ asset('assets/doctor_notes/'.$note->prescription) }}"
                                target="_blank"
                                class="btn btn-sm btn-primary">
                                  View Prescription
                              </a>
                          @else
                              <span class="text-danger">File Missing</span>
                          @endif

                      @else
                          <a href="#" class="btn btn-sm btn-info">
                              Manual (Working)
                          </a>
                      @endif
                  </td>

                    {{-- TOKEN DATE (SAFE LEFT JOIN) --}}
                    <td>
                        {{ \Carbon\Carbon::parse($note->token_date)->format('d-m-y h:i A') ?? 'No Visit' }}
                    </td>
    
                    <td>{{ \Carbon\Carbon::parse($note->updated_at)->format('d-m-y h:i A') }}</td>

                    {{-- ACTIONS --}}
                    <td>

                        @can('DoctorNotes edit')
                            <a href="{{ route('admin.doctor_notes.edit', $note->id) }}"
                               class="btn btn-warning btn-sm mr-2">
                                Edit
                            </a>
                        @endcan

                        @can('DoctorNotes delete')
                        <form action="{{ route('admin.doctor_notes.destroy', $note->id) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this record?')">
                                Delete
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
$(document).ready(function () {
    $('#doctorNotesTable').DataTable({
        order: [[0, 'desc']]
    });
});
</script>
@endpush

</x-app-layout>