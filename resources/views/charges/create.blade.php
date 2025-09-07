<x-app-layout>
<div class="container py-5">
    <h3 class="text-danger mb-4">Add Charges</h3>
    <form method="POST" action="{{ route('admin.charges.store') }}">
        @csrf
        <div class="mb-3">
            <label>Patient / Admitted</label>
            <select name="admission_id" class="form-control">
                @foreach($admissions as $admission)
                    <option value="{{ $admission->id }}">{{ $admission->patient->name }} (MR: {{ $admission->patient->id }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Type</label>
            <input type="text" name="type" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>
        <button class="btn btn-success">Add Charges</button>
        <a href="{{ route('admin.charges.index') }}" class="btn btn-warning">Back</a>
    </form>
</div>
</x-app-layout>
