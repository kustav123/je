<a href="javascript:void(0)" data-toggle="tooltip" onClick="editStaff('{{ $row->fid }}')" data-original-title="Edit"
    class="edit btn btn-success edit-{{ $row->fid }}">
    <i class="fa fa-pencil" aria-hidden="true"></i>

</a>
<a href="javascript:void(0);"
   id="{{ $row->status === 0 ? 'enable-company' : 'disable-company' }}"
   onClick="{{ $row->status === 0 ? "enableStaff('{$row->fid}')" : "deleteStaff('{$row->fid}')" }}"
   data-toggle="tooltip"
   data-original-title="{{ $row->status === 0 ? 'Enable' : 'Disable' }}"
   class="btn {{ $row->status === 0 ? 'btn-success' : 'btn-danger' }} {{ $row->status === 0 ? 'enable-' : 'delete-' }}{{ $row->fid }}">
    <i class="fa {{ $row->status === 0 ? 'fa-check' : 'fa-ban' }}" aria-hidden="true"></i>
</a>
