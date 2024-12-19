
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
        $('#mobile_number').autocomplete({
                source: function(request, response) {
                    const inputValue = request.term.trim();
                    if (inputValue.length >= 10) {

                        $.ajax({
                            url: '/suppliers/getsl',
                            type: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify({ mobile: inputValue }),
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
                                console.error('Error fetching client suggestions:', error);
                                response([]);
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


        // Autocomplete by name
        $('#name').autocomplete({
                source: function(request, response) {
                    const inputValue = request.term.trim();
                    if (inputValue.length >= 3) {

                        $.ajax({
                            url: '/suppliers/getslbyname',
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

        function updateClientDetails(client) {
        // console.log(client);
        if (client) {
            $('#mobile_number').val(client.mobile);
            $('#name').val(client.name);
            $('#address').val(client.address);
            $('#gst_no').val(client.gst);
            $('#email').val(client.email);
            $('#due_amount').val(client.due_ammount);
            $('#remarks').val(client.remarks);
            $('#clid').val(client.clid);
        } else {
            // Clear input fields
            $('#mobile_number').val('');
            $('#name').val('');
            $('#address').val('');
            $('#gst_no').val('');
            $('#email').val('');
            $('#due_amount').val('');
            $('#remarks').val('');
            $('#clid').val('');
        }
    }
});
</script>
