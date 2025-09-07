<x-app-layout>
<div class="container py-5">
    <h3 class="text-danger mb-4">Edit Charge</h3>

    <form method="POST" action="{{ route('admin.charges.update', $charge->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Patient / Admission</label>
            <select name="admission_id" class="form-control">
                @foreach($admissions as $admission)
                    <option value="{{ $admission->id }}" {{ $admission->id==$charge->admission_id?'selected':'' }}>
                        {{ $admission->patient->name }} (MR: {{ $admission->patient->id }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Type</label>
            <input type="text" name="type" class="form-control" value="{{ $charge->type }}" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $charge->description }}</textarea>
        </div>
        <div class="mb-3">
            <label>Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control" value="{{ $charge->amount }}" required>
        </div>
        <button class="btn btn-success">Update Charge</button>
    </form>
</div>
</x-app-layout>
