<a href="javascript:void(0)" data-toggle="tooltip" onClick="editStaff('{{ $row->sid }}')" data-original-title="Edit"
    class="edit btn btn-success edit-{{ $row->sid }}">
    <i class="fa fa-pencil" aria-hidden="true"></i>

</a>
<a href="javascript:void(0);"
   id="{{ $row->status === 0 ? 'enable-company' : 'disable-company' }}"
   onClick="{{ $row->status === 0 ? "enableStaff('{$row->sid}')" : "deleteStaff('{$row->sid}')" }}"
   data-toggle="tooltip"
   data-original-title="{{ $row->status === 0 ? 'Enable' : 'Disable' }}"
   class="btn {{ $row->status === 0 ? 'btn-success' : 'btn-danger' }} {{ $row->status === 0 ? 'enable-' : 'delete-' }}{{ $row->sid }}">
    <i class="fa {{ $row->status === 0 ? 'fa-check' : 'fa-ban' }}" aria-hidden="true"></i>
</a>
<a href="javascript:void(0);" id="Ledger-compnay" onClick="listLedger('{{ $row->sid }}')" data-toggle="tooltip"
    data-original-title="Ledger" class="Ledger btn btn-info Ledger-{{ $row->sid }}">
    <i class="fas fa-comments-dollar" aria-hidden="true"></i>

</a>
