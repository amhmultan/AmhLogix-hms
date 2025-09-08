<x-app-layout>
<main>
<div class="container-fluid py-4 px-5">

    {{-- Header and action buttons --}}
    <div class="row mb-4">
        <div class="col-sm-6">
            <h3 class="text-danger"><strong>Daily <span class="text-success">Notes</span></strong></h3>
        </div>
        <div class="col-sm-6 text-end">
            {{-- Back to IPD Dashboard --}}
            <a href="{{ route('admin.ipd.index') }}" class="btn btn-secondary mb-1">Back to IPD Dashboard</a>

            {{-- Add Daily Note dropdown --}}
            <div class="dropdown d-inline">
                @can('IPD_Notes create')
                    <button class="btn btn-primary dropdown-toggle mb-1" type="button" id="addDailyNoteBtn" data-bs-toggle="dropdown" aria-expanded="false">
                        Add Daily Note
                    </button>
                @endcan
                <ul class="dropdown-menu" aria-labelledby="addDailyNoteBtn">
                    @foreach($admissions as $admission)
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.daily-notes.create', $admission->id) }}">
                                {{ $admission->patient->name }} (MR: {{ $admission->patient->id }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- Success message --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Daily Notes table --}}
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#MR</th>
                <th>Patient Name</th>
                <th>Bed / Ward</th>
                <th>Notes</th>
                <th>Vitals</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dailyNotes as $note)
            <tr>
                <td>{{ $note->admission->patient->id }}</td>
                <td>{{ $note->admission->patient->name }}</td>
                <td>{{ $note->admission->bed->ward->name ?? '-' }} / {{ $note->admission->bed->bed_number ?? '-' }}</td>
                <td>{{ Str::limit($note->notes,50) }}</td>
                <td>
                    @if($note->vitals)
                        @foreach($note->vitals as $key => $val)
                            <strong>{{ ucfirst($key) }}:</strong> {{ $val }} <br>
                        @endforeach
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $note->created_at->format('d-m-Y H:i') }}</td>
                <td>
                    @can('IPD_Notes edit')
                        <a href="{{ route('admin.daily-notes.edit', $note->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                    @endcan
                    @can('IPD_Notes delete')
                        <form action="{{ route('admin.daily-notes.destroy', $note->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger mb-1">Delete</button>
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
