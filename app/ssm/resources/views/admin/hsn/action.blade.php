<a href="javascript:void(0)" data-toggle="tooltip" onClick="editStaff('{{ $row->id }}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
    class="edit btn btn-success edit-{{ $row->id }}">
    <i class="fa fa-pencil" aria-hidden="true"></i>

</a>
<a href="javascript:void(0);"
   id="{{ $row->status === 0 ? 'enable-company' : 'disable-company' }}"
   onClick="{{ $row->status === 0 ? "enableStaff('{$row->id}')" : "deleteStaff('{$row->id}')" }}"
   data-toggle="tooltip"
   data-original-title="{{ $row->status === 0 ? 'Enable' : 'Disable' }}"
   class="btn {{ $row->status === 0 ? 'btn-success' : 'btn-danger' }} {{ $row->status === 0 ? 'enable-' : 'delete-' }}{{ $row->id }}">
    <i class="fa {{ $row->status === 0 ? 'fa-check' : 'fa-ban' }}" aria-hidden="true"></i>
</a>
