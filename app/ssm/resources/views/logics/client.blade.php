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


            ajax: "{{ url('clients') }}",
            columns: [{
                    data: 'userId',
                    name: 'id',
                    orderable: false
                },
                {
                    data: 'name',
                    name: 'name'
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
                    data: 'mobile_additonal',
                    name: 'mobile_additonal'
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
                // {
                //     data: 'job',
                //     name: 'job'
                // },
                {
                    data: 'remarks',
                    name: 'remarks'
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,

                },
            ],
            order: [
                [0, 'desc']
            ],
            columnDefs: [
            {
                targets: 5, // Email column
                width: '250px', // Set the fixed width for the email column
            }
            ],

            autoWidth: false

        });
    });

    const add = (mobileNumber) => {
    $('#staffForm').trigger("reset");
    $('#staffModal').html("Add Client");
    $('#addStaffModal').modal('show');

    $('#id').val('');
    $('#purpose').val('insert');
    $("#btn-save").html('Add');

    // Update mobile number input value
    $('#mobile').val(mobileNumber);

    // Clear previous errors
    clearErrors();
}

const clearErrors = () => {
    $('.form-group').removeClass('has-error');
    $('.help-block').remove();
    $("#btn-save").html('Add');
}

$('#staffForm').on('submit', function (e) {
    e.preventDefault();

    let formData = $(this).serialize();
    let url = '/clients/store';

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            // Handle success
            console.log('Data successfully inserted:', data); // Log success message for debugging
            $.notify(data.message, "success");
            $('#addStaffModal').modal('hide');

            // Prompt the user
            if (confirm('Do you want to create a job for this client?')) {
                // Redirect to add job page with mobile number
                let mobileNumber = $('#mobile').val(); // Assuming the mobile input has id="mobile"
                window.location.href = `/addjobpage?mob=${mobileNumber}`;
            } else {
                // Reload the current page
                window.location.href = '/clients'; // Redirect to /clients
            }
        },
        error: function (xhr, status, error) {
            // Handle errors
            console.error('Error inserting data:', error); // Log error for debugging
            clearErrors();
            $.notify(xhr.responseJSON.message);
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
            url: "{{ url('clients/edit') }}",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(res) {
                $('.edit-' + id).html(`Edit`);
                $('#staffModal').html("Edit Client");
                $('#addStaffModal').modal('show');
                $('#id').val(res.userId);
                $('#purpose').val('update');
                $('#name').val(res.name);
                $('#email').val(res.email);
                $('#mobile').val(res.mobile);
                $('#address').val(res.address)
                $('#state').val(res.state);
                $("#btn-save").html('Update');
            }
        });
    }

   const deleteStaff = (id) => {
    const deleteButton = $('.delete-' + id);

    deleteButton.html(`
        <div class="spinner-border spinner-border-sm" role="status">
            <span class="sr-only">Loading...</span>
        </div>`);

    // First, check for dependencies via the `/client/check` route
    $.ajax({
        type: "POST",
        url: "{{ url('clients/check') }}", // The URL for checking dependencies
        data: { id: id },
        dataType: 'json',
        success: function(res) {
            // If no dependencies found (result is 'yes')
            if (res.result === 'yes') {
                Swal.fire({
                    title: 'No dependency found!',
                    text: "Safe to delete or disable the user. Please choose an action:",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-trash" aria-hidden="true"></i> Delete',
                    cancelButtonText: '<i class="fa fa-ban" aria-hidden="true"></i> Disable',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If "Delete" is selected, call delete route
                        $.ajax({
                            type: "POST",
                            url: "{{ url('clients/rm') }}",
                            data: { id: id },
                            dataType: 'json',
                            success: function(res) {
                                Swal.fire('Deleted!', 'Successfully deleted user.', 'success');
                                deleteButton.html(`<i class="fa fa-trash" aria-hidden="true"></i>`);
                                var oTable = $('#dataTable').dataTable();
                                oTable.fnDraw(false);
                            },
                            error: function(err) {
                                Swal.fire('Error!', 'Error deleting user.', 'error');
                                deleteButton.html(`<i class="fa fa-trash" aria-hidden="true"></i>`);
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        // If "Disable" is selected, call disable route
                        $.ajax({
                            type: "POST",
                            url: "{{ url('clients/disable') }}",
                            data: { id: id },
                            dataType: 'json',
                            success: function(res) {
                                Swal.fire('Disabled!', 'Successfully disabled user.', 'success');
                                deleteButton.html(`<i class="fa fa-ban" aria-hidden="true"></i>`);
                                var oTable = $('#dataTable').dataTable();
                                oTable.fnDraw(false);
                            },
                            error: function(err) {
                                Swal.fire('Error!', 'Error disabling user.', 'error');
                                deleteButton.html(`<i class="fa fa-ban" aria-hidden="true"></i>`);
                            }
                        });
                    }
                });
            }
            // If dependencies (jobs) are found (result is 'false')
            else if (res.result === 'false') {
                Swal.fire({
                    title: 'Jobs Found!',
                    text: "The user has associated jobs. Do you want to disable the user instead?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, disable it!',
                    cancelButtonText: 'No',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If "Yes" to disable, call disable route
                        $.ajax({
                            type: "POST",
                            url: "{{ url('clients/disable') }}",
                            data: { id: id },
                            dataType: 'json',
                            success: function(res) {
                                Swal.fire('Disabled!', 'Successfully disabled user.', 'success');
                                deleteButton.html(`<i class="fa fa-trash" aria-hidden="true"></i>`);
                                var oTable = $('#dataTable').dataTable();
                                oTable.fnDraw(false);
                            },
                            error: function(err) {
                                Swal.fire('Error!', 'Error disabling user.', 'error');
                                deleteButton.html(`<i class="fa fa-trash" aria-hidden="true"></i>`);
                            }
                        });
                    } else {
                        // If "No", reset the button state
                        deleteButton.html(`<i class="fa fa-trash" aria-hidden="true"></i>`);
                    }
                });
            }
        },
        error: function(err) {
            // Handle any errors from the check request
            Swal.fire('Error!', 'Could not check dependencies.', 'error');
            deleteButton.html(`<i class="fa fa-trash" aria-hidden="true"></i>`);
        }
    });
};


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
                url: "{{ url('clients/enable') }}",
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

        if (document.URL.indexOf("#addnew") >= 0) {
        const urlParams = new URLSearchParams(window.location.hash.split('?')[1]);
        const mobileNumber = urlParams.get('mobile');

        if (mobileNumber) {
            // Call the add() function with mobileNumber
            add(mobileNumber);
        }


    }


    function getch(userId) {
        // Construct the URL with the userId parameter
        var url = '/getdtl?clid=' + userId;

        // Redirect to the constructed URL
        window.location.href = url;
    }

    function listLedger(sid) {
    // Redirect to the desired URL with the sid as clid
    window.location.href = '/fetch-by-clid?clid=' + sid;
    }
</script>
