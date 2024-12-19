<a href="javascript:void(0)" data-toggle="tooltip" onClick="getJob('{{ $row->Job }}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Job History"
    class="edit btn btn-info edit-{{ $row->Job }}">
    <i class="fa fa-info" aria-hidden="true"></i>

</a>
<a href="javascript:void(0)" data-toggle="tooltip" onClick="jobCard('{{ $row->Job }}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Reprint Jobcard"
    class="edit btn btn-secondary edit-{{ $row->Job }}">
<i class="fa fa-print" aria-hidden="true"></i>

</a>
<a href="javascript:void(0)" data-toggle="tooltip" onClick="updateJob('{{ $row->Job }}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Manage"
    class="edit btn btn-success edit-{{ $row->Job }}">
    <i class="fa fa-wrench" aria-hidden="true"></i>
</a>

@if ($row->status !== "Delivery Challan Generated" && $row->status !== "Invoice Generated" && $row->status !== "Delivered")
<a href="javascript:void(0)" data-toggle="tooltip" onClick="redirectToEditJob('{{ $row->Job }}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Job"
    class="edit btn btn-danger danger-{{ $row->Job }}">
        <i class="fas fa-edit" aria-hidden="true"></i>
</a>
@endif
