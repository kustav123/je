
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {

        $(function() {
    $("#mobile_number").autocomplete({
        source: function(request, response) {
            if (request.term.length >= 10) {
                $.ajax({
                    url: '/clients/getcl',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ mobile: request.term }),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        response(data.map(client => ({
                            label: client.mobile,
                            value: client.mobile,
                            client: client
                        })));
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 404) {
                            const currentPath = window.location.pathname;
                            if (currentPath === '/addjobpage') {
                                Swal.fire({
                                    title: 'Number not found',
                                    text: 'Do you want to add as new client?',
                                    icon: 'error',
                                    showCancelButton: true,
                                    confirmButtonText: 'Add',
                                    cancelButtonText: 'Retry'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = `/clients/#addnew?mobile=${request.term}`;
                                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                                        location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Number not found',
                                    text: 'No client found on givven number provided. Please try again',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    }
                });
            } else {
                response([]);
            }
        },
        minLength: 10,
        select: function(event, ui) {
            updateClientDetails(ui.item.client);
        }
    });
});



        // Autocomplete by name
        $('#name').autocomplete({
                source: function(request, response) {
                    const inputValue = request.term.trim();
                    if (inputValue.length >= 3) {

                        $.ajax({
                            url: '/clients/getclbyname',
                            type: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify({ name: inputValue }),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                    response(data.map(client => ({
                                        label: client.name,
                                        value: client.name,
                                        client: client
                                    })));

                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching client suggestions:', error);
                                response([]);
                            }
                        });
                    } else {
                        response([]);
                    }
                },
                minLength: 3,
                appendTo: "#nameSuggestions",

                select: function(event, ui) {
                    updateClientDetails(ui.item.client);
                }
            });


        // Function to update client details

});
</script>
