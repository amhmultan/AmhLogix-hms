@can('Patient access')

   <a href="{{ route('admin.patients.print', $patient->id) }}"
      target="_blank"
      class="btn btn-sm btn-info">
      Print
   </a>

   <a href="{{ route('admin.patients.show', $patient->id) }}"      
      class="btn btn-sm btn-primary">
      Show
   </a>

@endcan

@can('Patient edit')
<a href="{{ route('admin.patients.edit', $patient->id) }}"
   class="btn btn-sm btn-warning text-light">
   Edit
</a>
@endcan

@can('Patient delete')
<form action="{{ route('admin.patients.destroy', $patient->id) }}"
      method="POST"
      style="display:inline;">
    @csrf
    @method('delete')
    <button class="btn btn-sm btn-danger"
            onclick="return confirm('Are you sure?')">
        Delete
    </button>
</form>
@endcan