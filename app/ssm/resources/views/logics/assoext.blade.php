<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

            }
        });
         $('#dataTable').DataTable({
             processing: true,
             serverSide: true,

             ajax: "{{ url('assoext') }}",

             columns: [{
                     data: 'id',
                     name: 'id',
                     orderable: false
                 },
                 {
                     data: 'name',
                     name: 'name'
                 },
                 {
                     data: 'mobile',
                     name: 'mobile'
                 },
                 {
                     data: 'email',
                     name: 'email'
                 },
                 {
                     data: 'address',
                     name: 'address'
                 },
                 {
                     data: 'uidtype',
                     name: 'uidtype'
                 },
                 {
                     data: 'uid',
                     name: 'uid'
                 },

                 {
                     data: 'action',
                     name: 'action',
                     orderable: false
                 }
             ],
             order: [
                 [0, 'desc']
             ]
         });

    });
    const add = () => {
        $('#staffForm').trigger("reset");
        $('#staffModal').html("Add Assosiate");
        $('#addStaffModal').modal('show');

        $('#id').val('');
        $('#purpose').val('insert');

        $("#btn-save").html('Add');
    }

    const editStaff = (id) => {
        $('.edit-' + id).html(`
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>`);

        $.ajax({
            type: "POST",
            url: "{{ url('assoext/edit') }}",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(res) {
                $('.edit-' + id).html(`Edit`);

                $('#staffModal').html("Edit Assosiate");
                $('#addStaffModal').modal('show');
                $('#id').val(res.id);
                $('#purpose').val('update');
                $('#name').val(res.name);
                $('#mobile').val(res.mobile);
                $('#email').val(res.email);
                $('#address').val(res.address);
                $('#uidtype').hide();
                $('#uid').hide();
                $('#uidgl').hide();
                $('#uidl').hide();
                $('#id').attr('readonly', true);
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
                url: "{{ url('assoext/disable') }}",
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
                url: "{{ url('assoext/enable') }}",
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

    $('#staffForm').submit(function(e) {
        e.preventDefault();

        let btnSaveText = $('#btn-save').html();
        $('#btn-save').html(`
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>`)

        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: "{{ url('assoext/store') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: (data) => {
                $.notify(data.message, "success");
                $('#btn-save').html(btnSaveText)

                $("#addStaffModal").modal('hide');
                var oTable = $('#dataTable').dataTable();
                oTable.fnDraw(false);
                $("#btn-save").html('Add Item');
                $("#btn-save").attr("disabled", false);
                // window.location.href = '/assoext';
            },
            error: function(xhr, status, errora) {
                $.notify(xhr.responseJSON.message);            }
        });
    });



    function extstk(id) {
        $.ajax({
            url: '/stkoutext/getextstock',
            type: 'POST', // or 'POST' depending on your API endpoint
            data: { id: id },
            success: function(response) {
                // Create the table HTML
                var tableHtml = '<div style="max-height: 300px; overflow-y: auto;">' +
                                '<table class="table table-bordered">' +
                                '<thead>' +
                                '<tr>' +
                                '<th>Product Name</th>' +
                                '<th>Quantity</th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody>';

                response.forEach(function(item) {
                    tableHtml += '<tr>' +
                                 '<td>' + item.product_name + '</td>' +
                                 '<td>' + item.qty + ' '+ item.unit + '</td>' +
                                 '</tr>';
                });

                tableHtml += '</tbody></table></div>';

                // Display the table in SweetAlert
                Swal.fire({
                    title: 'Stock Details',
                    html: tableHtml,
                    width: '600px',
                    showCloseButton: true,
                    focusConfirm: false,
                    confirmButtonText: 'Close'
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
</script>
