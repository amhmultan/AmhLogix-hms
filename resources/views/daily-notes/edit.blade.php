<x-app-layout>
<main>
<div class="container-fluid py-4 px-5">

    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-sm-6">
            <h3 class="text-warning"><strong>Edit <span class="text-success">Daily Note</span></strong></h3>
        </div>
        <div class="col-sm-6 text-end">
            <a href="{{ route('admin.daily-notes.index') }}" class="btn btn-secondary mb-1">Back to Daily Notes</a>
            <a href="{{ route('admin.ipd.index') }}" class="btn btn-secondary mb-1">Back to IPD Dashboard</a>
        </div>
    </div>

    {{-- Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('admin.daily-notes.update', $dailyNote->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Patient Info --}}
        <div class="card mb-4">
            <div class="card-header bg-light"><strong>Patient Information</strong></div>
            <div class="card-body">
                <p><strong>MR No:</strong> {{ $dailyNote->admission->patient->id }}</p>
                <p><strong>Name:</strong> {{ $dailyNote->admission->patient->name }}</p>
                <p><strong>Ward / Bed:</strong> {{ $dailyNote->admission->bed->ward->name ?? '-' }} / {{ $dailyNote->admission->bed->bed_number ?? '-' }}</p>
            </div>
        </div>

        {{-- Notes --}}
        <div class="card mb-4">
            <div class="card-header bg-light"><strong>Daily Notes</strong></div>
            <div class="card-body">
                <textarea name="notes" class="form-control" rows="5">{{ old('notes', $dailyNote->notes) }}</textarea>
            </div>
        </div>

        {{-- Vitals --}}
        <div class="card mb-4">
            <div class="card-header bg-light"><strong>Vitals</strong></div>
            <div class="card-body">
                <div class="row g-3">
                    @php
                        $vitals = ['temperature','pulse','respiration','blood_pressure','oxygen_saturation'];
                    @endphp

                    @foreach($vitals as $vital)
                    <div class="col-md-4">
                        <label class="form-label">{{ ucfirst(str_replace('_',' ',$vital)) }}</label>
                        <input type="text" 
                               class="form-control" 
                               name="vitals[{{ $vital }}]" 
                               value="{{ old('vitals.'.$vital, $dailyNote->vitals[$vital] ?? '') }}" 
                               placeholder="{{ ucfirst(str_replace('_',' ',$vital)) }}">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="text-end">
            <button type="submit" class="btn btn-success">Update Daily Note</button>
        </div>

    </form>
</div>
</main>
</x-app-layout>
