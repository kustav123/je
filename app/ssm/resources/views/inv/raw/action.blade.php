<a href="javascript:void(0)" data-toggle="tooltip" onClick="editStaff('{{ $row->rid }}')" data-original-title="Edit"
    class="edit btn btn-success edit-{{ $row->rid }}">
    <i class="fa fa-pencil" aria-hidden="true"></i>

</a>
<a href="javascript:void(0);"
   id="{{ $row->status === 0 ? 'enable-company' : 'disable-company' }}"
   onClick="{{ $row->status === 0 ? "enableStaff('{$row->rid}')" : "deleteStaff('{$row->rid}')" }}"
   data-toggle="tooltip"
   data-original-title="{{ $row->status === 0 ? 'Enable' : 'Disable' }}"
   class="btn {{ $row->status === 0 ? 'btn-success' : 'btn-danger' }} {{ $row->status === 0 ? 'enable-' : 'delete-' }}{{ $row->rid }}">
    <i class="fa {{ $row->status === 0 ? 'fa-check' : 'fa-ban' }}" aria-hidden="true"></i>
</a>
<a href="javascript:void(0);" id="hist" onClick="getstk('{{ $row->rid }}')" data-toggle="tooltip"
    data-original-title="Disable" class="delete btn btn-info info-{{ $row->rid }}">
    <i class="fas fa-th-list"></i>
</a>
