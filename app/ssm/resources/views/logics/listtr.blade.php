<script type="text/javascript">
   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function loadStockHistory() {
        var clid = $('#clid').val();
        $('#assigntable').removeClass('d-none');
        $('#supptable').addClass('d-none');



        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            destroy: true, // Destroy any existing table instance before reinitializing
            ajax: {
                url: "{{ url('getstkhis') }}",
                type: 'GET',
                data: function(d) {
                    d.clid = clid;
                }
            },
            columns: [
                { data: 'eid', name: 'eid' },
                { data: 'asso_name', name: 'asso_name', orderable: false },
                { data: 'qty', name: 'qty' },
                { data: 'entry_time', name: 'time' }
            ],
            order: [[0, 'desc']]
        });
    }

    $('#AssignmentStockButton').on('click', function() {
        loadStockHistory();
    });

    // Automatically load the stock history when the page loads


    function loadSuppStockHistory() {
        var clid = $('#clid').val();
        $('#supptable').removeClass('d-none');
        $('#assigntable').addClass('d-none');



        $('#suppdataTable').DataTable({
            processing: true,
            serverSide: true,
            destroy: true, // Destroy any existing table instance before reinitializing
            ajax: {
                url: "{{ url('getstkhis/supp') }}",
                type: 'GET',
                data: function(d) {
                    d.clid = clid;
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false },
                { data: 'merchant_name', name: 'merchant_name' },
                { data: 'qty', name: 'qty' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }

            ],
            order: [[3, 'desc']]
        });
    }

    $('#updateStockButton').on('click', function() {
        loadSuppStockHistory();
    });
    function searchProHis(id) {
    $.ajax({
        url: '/stkent/gethis', // Replace with the correct URL if needed
        type: 'GET',
        data: { id: id }, // Send the id as a parameter
        dataType: 'json', // Expect a JSON response
        success: function(response) {
            console.log('Response:', response); // Log the response to the console

            // Verify if the response is an array
            if (Array.isArray(response)) {
                populateProductHistoryModal(response); // Call the function to populate the modal
            } else {
                console.error('Expected an array but got:', typeof response);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error); // Handle errors if any
        }
    });
}

function populateProductHistoryModal(data) {
    // Clear previous data
    $('#productHistoryTableBody').empty();
  console.log(data);
    // Populate the table with the new data
    data.forEach(item => {
        $('#productHistoryTableBody').append(`
            <tr>
                <td>${item.name}</td>
                <td>${item.qty}</td>
            </tr>
        `);
    });

    // Show the modal
    $('#productHistoryModal').modal('show');
}
function closeModal() {
    // Use jQuery to select the modal by its ID and hide it
    $('#productHistoryModal').modal('hide');
}
</script>
