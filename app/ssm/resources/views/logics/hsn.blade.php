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

             ajax: "{{ url('hsns') }}",

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
                     data: 'cgst',
                     name: 'cgst'
                 },
                 {
                     data: 'sgst',
                     name: 'sgst'
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
        $('#staffModal').html("Add Item");
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
            url: "{{ url('hsns/edit') }}",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(res) {
                $('.edit-' + id).html(`Edit`);

                $('#staffModal').html("Edit Item");
                $('#addStaffModal').modal('show');
                $('#id').val(res.id);
                $('#purpose').val('update');
                $('#name').val(res.name);
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
                url: "{{ url('hsns/disable') }}",
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
                url: "{{ url('hsns/enable') }}",
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
            url: "{{ url('hsns/store') }}",
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
                window.location.href = '/hsns';
            },
            error: function(data) {
                $.notify(data, "error");
            }
        });
    });
</script>
