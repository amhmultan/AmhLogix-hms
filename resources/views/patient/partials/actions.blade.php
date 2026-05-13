@can('Patient access')
<a href="{{ route('admin.patients.show', $patient->id) }}"
   class="btn btn-sm btn-primary mb-1">
   Show
</a>
@endcan

@can('Patient edit')
<a href="{{ route('admin.patients.edit', $patient->id) }}"
   class="btn btn-sm btn-warning mb-1">
   Edit
</a>
@endcan

@can('Patient delete')
<form action="{{ route('admin.patients.destroy', $patient->id) }}"
      method="POST"
      style="display:inline;">
    @csrf
    @method('delete')
    <button class="btn btn-sm btn-danger mb-1"
            onclick="return confirm('Are you sure?')">
        Delete
    </button>
</form>
@endcan