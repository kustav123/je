
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
        $('#mobile_number').autocomplete({
                source: function(request, response) {
                    const inputValue = request.term.trim();
                    if (inputValue.length >= 10) {
                        var hiddenValue = $('#typeField').val();
                        var url = '';
                        if (hiddenValue == 'int') {
                            url = '/assoint/getia';
                            } else {
                            url = '/assoext/getea';
                            }

                        $.ajax({
                            url: url,
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
                        var hiddenValue = $('#typeField').val();
                        console.log(hiddenValue);
                        var url = '';
                        if (hiddenValue == 'int') {
                            url = '/assoint/getiabyname';
                            } else {
                            url = '/assoext/geteabyname';
                            }
                        $.ajax({
                            url: url,
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

            $('#clid').val(client.clid);
        } else {
            // Clear input fields
            $('#mobile_number').val('');
            $('#name').val('');
            $('#address').val('');

            $('#clid').val('');
        }
    }
});
</script>
