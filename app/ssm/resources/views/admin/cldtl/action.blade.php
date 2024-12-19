<a href="javascript:void(0)" data-toggle="tooltip" onClick="printch('{{ $row->id }}')" data-original-title="Edit"
    class="edit btn btn-success edit-{{ $row->id }}">
    <i class="fa fa-print" aria-hidden="true"></i>
</a>

<a href="javascript:void(0)" data-toggle="tooltip" onClick="getDeliveryableAllData('{{ $row->id }}')" data-original-title="Edit"
    class="edit btn btn-success edit-{{ $row->Job }}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>

<a href="javascript:void(0)" data-toggle="tooltip" onClick="getJObData('{{ $row->id }}')" data-original-title="Edit"
    class="edit btn btn-success edit-{{ $row->Job }}">
    <i class="fa fa-minus" aria-hidden="true"></i>
</a>

