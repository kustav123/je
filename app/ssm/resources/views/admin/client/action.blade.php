
<a href="javascript:void(0);" id="Ledger-compnay" onClick="listLedger('{{ $row->userId }}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Transaction" class="Ledger btn btn-primary Ledger-{{ $row->userId }}">
    <i class="fa fa-inr" aria-hidden="true"></i>

</a>
<a href="javascript:void(0);" id="getch" onClick="getch('{{ $row->userId }}')" data-bs-toggle="tooltip" data-bs-placement="top" title="History" class="ledger btn btn-info ledger-{{ $row->userId }}">
    <i class="fa fa-book" aria-hidden="true"></i>
</a>

<a href="javascript:void(0)" data-toggle="tooltip" onClick="editStaff('{{ $row->userId }}')"
    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User" data-user-id="{{ $row->userId }}" class="edit btn btn-warning">
    <i class="fa fa-pencil" aria-hidden="true"></i>
 </a>

<a href="javascript:void(0);"
   id="{{ $row->status === 0 ? 'enable-company' : 'disable-company' }}"
   onClick="{{ $row->status === 0 ? "enableStaff('{$row->userId}')" : "deleteStaff('{$row->userId}')" }}"
   data-bs-toggle="tooltip" data-bs-placement="top" title="Status"   data-original-title="{{ $row->status === 0 ? 'Enable' : 'Disable' }}"
   class="btn {{ $row->status === 0 ? 'btn-success' : 'btn-danger' }} {{ $row->status === 0 ? 'enable-' : 'delete-' }}{{ $row->userId }}">
    <i class="fa {{ $row->status === 0 ? 'fa-check' : 'fa-trash' }}" aria-hidden="true"></i>
</a>
