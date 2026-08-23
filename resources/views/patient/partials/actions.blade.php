@can('Patient access')

   <a href="{{ route('admin.patients.print', $patient->id) }}"
      target="_blank"
      title="Print"
      class="text-2xl text-decoration-none text-primary mx-2">
      <i class="fa-solid fa-print"></i>
   </a>

   <a href="{{ route('admin.patients.show', $patient->id) }}"
      title="Show"      
      class="text-2xl text-decoration-none text-dark mx-2">
      <i class="fa-solid fa-eye"></i>
   </a>

@endcan

@can('Patient edit')
<a href="{{ route('admin.patients.edit', $patient->id) }}"
   class="text-2xl text-decoration-none text-success mx-2"
   title="Edit">
   <i class="fa-solid fa-edit"></i>
</a>
@endcan

@can('Patient delete')
<form action="{{ route('admin.patients.destroy', $patient->id) }}"
      method="POST"
      style="display:inline;">
    @csrf
    @method('delete')
    <button class="text-2xl text-decoration-none text-danger mx-2"
            title="Delete"
            onclick="return confirm('Are you sure?')">
        <i class="fa-solid fa-trash"></i>
    </button>
</form>
@endcan