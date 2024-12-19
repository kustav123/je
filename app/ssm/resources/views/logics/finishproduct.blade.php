<script type="text/javascript">
    var isDataEdit = false;

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,

            ajax: "{{ url('finishproducts') }}",
            columns: [{
                    data: 'fid',
                    name: 'fid',
                    orderable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'unit',
                    name: 'unit'
                },
                {
                    data: 'current_stock',
                    name: 'current_stock'
                },
                {
                    data: 'remarks',
                    name: 'remarks'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
            ],
            order: [
                [0, 'desc']
            ]
        });
    });

    const add = () => {
    $('#finForm').trigger("reset");
    $('#FinModal').html("Add Finish Product");
    $('#addFinModal').modal('show');

    $('#id').val('');
    $('#purpose').val('insert');
    $("#btn-save").html('Add');

    // Clear previous errors
    clearErrors();
}

const clearErrors = () => {
    $('.form-group').removeClass('has-error');
    $('.help-block').remove();
    $("#btn-save").html('Add');
}

$('#finForm').on('submit', function (e) {
    e.preventDefault();

    let formData = $(this).serialize();
    let url = 'finishproducts/store';

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        success: function (data) {
            // Handle success
            $.notify(data.message, "success");
            $('#addFinModal').modal('hide');
            window.location.href = '/finishproducts';
        },
        error: function (xhr) {
            if (xhr.status != 200) {
                clearErrors()
                $.notify(xhr.responseJSON.message);
            }
        }
    });
});
    const editStaff = (id) => {

        $('.edit-' + id).html(`
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>`);

        $.ajax({
            type: "POST",
            url: "{{ url('finishproducts/edit') }}",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(res) {
                $('.edit-' + id).html(`Edit`);
                $('#FinModal').html("Edit Finish Product");
                $('#addFinModal').modal('show');
                $('#id').val(res.fid);
                $('#purpose').val('update');
                $('#name').val(res.name);
                $('#name').attr('disabled', true);
                $('#unit').val(res.unit);
                $('#unit').attr('disabled', true);
                $('#remarks').val(res.remarks);
                $("#btn-save").html('Update');

            },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', xhr.responseText);
            // Handle error
        }
        });
    }
    const deleteStaff = (id) => {
    const deleteButton = $('.delete-' + id);

    deleteButton.html(`
        <div class="spinner-border spinner-border-sm" role="status">
            <span class="sr-only">Loading...</span>
        </div>`);

    Swal.fire({
        title: 'Are you sure?',
        text: "Disable Record? Only Admin can undo!!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, disable it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "{{ url('finishproducts/disable') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    Swal.fire(
                        'Disabled!',
                        'Successfully disabled item.',
                        'success'
                    );
                    deleteButton.html(`<i class="fa fa-ban" aria-hidden="true"></i>`);

                    var oTable = $('#dataTable').dataTable();
                    oTable.fnDraw(false);
                },
                error: function(err) {
                    Swal.fire(
                        'Error!',
                        'Error disabling item.',
                        'error'
                    );
                    deleteButton.html(`<i class="fa fa-ban" aria-hidden="true"></i>`);
                }
            });
        } else {
            deleteButton.html(`<i class="fa fa-ban" aria-hidden="true"></i>`);
        }
    });
}
const enableStaff = (id) => {
    const deleteButton = $('.delete-' + id);

    deleteButton.html(`
        <div class="spinner-border spinner-border-sm" role="status">
            <span class="sr-only">Loading...</span>
        </div>`);

    Swal.fire({
        title: 'Are you sure!!!',
        text: "Enable Record? Entry will be visible to all users",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, enable it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "{{ url('finishproducts/enable') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    Swal.fire(
                        'Enabled!',
                        'Successfully enabled item.',
                        'success'
                    );
                    deleteButton.html(`<i class="fa fa-ban" aria-hidden="true"></i>`);

                    var oTable = $('#dataTable').dataTable();
                    oTable.fnDraw(false);
                },
                error: function(err) {
                    Swal.fire(
                        'Error!',
                        'Error enableing item.',
                        'error'
                    );
                    deleteButton.html(`<i class="fa fa-ban" aria-hidden="true"></i>`);
                }
            });
        } else {
            deleteButton.html(`<i class="fa fa-ban" aria-hidden="true"></i>`);
        }
    });
}

</script>
