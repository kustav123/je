<a href="javascript:void(0)" data-toggle="tooltip" onClick="editStaff('{{ $row->id }}')" data-original-title="Edit"
    class="edit btn btn-success edit-{{ $row->id }}">
    Edit
</a>
<a href="javascript:void(0);" id="delete-compnay" onClick="deleteStaff('{{ $row->id }}')" data-toggle="tooltip"
    data-original-title="Delete" class="delete btn btn-danger delete-{{ $row->id }}">
    Delete
</a>
