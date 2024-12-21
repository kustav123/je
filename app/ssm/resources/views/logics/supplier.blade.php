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

            ajax: "{{ url('suppliers') }}",
            columns: [{
                    data: 'sid',
                    name: 'sid',
                    orderable: false
                },
                {
                    data: 'merchant_name',
                    name: 'merchant_name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'mobile',
                    name: 'mobile'
                },
                {
                    data: 'address',
                    name: 'address',
                    className: 'wrap-text',
                    render: function(data, type, row) {
                        // Check if the address is blank and return formatted result
                        var address = row.address ? row.address : '';
                        var state = row.state ? row.state : '';

                        if (address && state) {
                            return address + ' - ' + state;
                        } else if (state) {
                            return state;
                        } else {
                            return address;
                        }
                    }

                },
                {
                    data: 'gst',
                    name: 'gst'
                },
                {
                    data: 'due_ammount',
                    name: 'due_ammount'
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
            ],
            columnDefs: [
            {
                targets: 4, // Email column
                width: '250px', // Set the fixed width for the email column
            }
            ],

            autoWidth: false

        });
    });
    const add = () => {
    $('#suppForm').trigger("reset");
    $('#SuppModal').html("Add Supplier");
    $('#addSuppModal').modal('show');

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

$('#suppForm').on('submit', function (e) {
    e.preventDefault();

    let formData = $(this).serialize();
    let url = '/suppliers/store';

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        success: function (data) {
            // Handle success
            $.notify(data.message, "success");
            $('#addSuppModal').modal('hide');
            window.location.href = '/suppliers';
        },
        error: function (xhr, status, error) {
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
            url: "{{ url('suppliers/edit') }}",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(res) {
                $('.edit-' + id).html(`Edit`);
                $('#SuppModal').html("Edit Client");
                $('#addSuppModal').modal('show');
                $('#id').val(res.sid);
                $('#purpose').val('update');
                $('#name').val(res.merchant_name);
                $('#email').val(res.email);
                $('#mobile').val(res.mobile);
                $('#mobile').attr('disabled', true);
                $('#address').val(res.address)
                $('#state').val(res.state);
                $('#gst').val(res.gst);
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
                url: "{{ url('suppliers/disable') }}",
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
                url: "{{ url('suppliers/enable') }}",
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
function listLedger(sid) {
    // Redirect to the desired URL with the sid as clid
    window.location.href = '/fetch-by-clid?clid=' + sid;
}
</script>
