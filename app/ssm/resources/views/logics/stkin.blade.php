<script type="text/javascript">





const searchByMobile = document.getElementById('search_by_mobile');
const searchByName = document.getElementById('search_by_name');
const mobileNumberInput = document.getElementById('mobile_number');
const nameInput = document.getElementById('name');

// Initially set mobile number input to enabled and name input to readonly
mobileNumberInput.removeAttribute('readonly');
nameInput.setAttribute('readonly', 'readonly');

// Event listener for radio buttons
searchByMobile.addEventListener('change', function() {
    mobileNumberInput.removeAttribute('readonly');
    nameInput.setAttribute('readonly', 'readonly');
    nameInput.value = ''; // Clear name input if switched
});

searchByName.addEventListener('change', function() {
    nameInput.removeAttribute('readonly');
    mobileNumberInput.setAttribute('readonly', 'readonly');
    mobileNumberInput.value = ''; // Clear mobile number input if switched
});




$('#fetchStockButton').on('click', function() {
        // Get values from input fields
        const name = $('#name').val();
        const mobileNumber = $('#mobile_number').val();
        const clid = $('#clid').val();
        var hiddenValue = $('#typeField').val();
        var url = '';
                        if (hiddenValue == 'int') {
                            url = 'stkoutint/getintstock';
                            } else {
                            url = '/stkoutext/getextstock';
                            }


        // Ensure all required fields are filled
        if (name && mobileNumber) {
            // Perform AJAX request
            $.ajax({
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },// Your endpoint for fetching stock information
                type: 'POST',
                data: {

                    id: clid
                },
                success: function(response) {
                    // Handle the response
                    let stockInfoHtml = '';
                    $('#asid').val(clid);

                    response.forEach((item, index) => {
                        if (item.qty === 0) {
                        return; // Skip this iteration if qty is 0
                    }
                        stockInfoHtml +=
                            `   <div class="form-group">
                                <div class="row mb-2 align-items-center justify-content-center">
                                    <div class="col-md-6 text-center">
                                        <label>
                                            For <strong>${item.product_name}</strong> Current assigned stock is <strong>${item.qty} ${item.unit}</strong>, Consumed quantity is
                                        </label>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <input type="hidden" name="product[${index}][rid]" value="${item.rid}">
                                        <input type="hidden" name="product[${index}][id]" value="${item.id}">
                                        <div class="input-group mb-2">
                                            <input type="number" class="form-control" name="product[${index}][quantity]" max="${item.qty}" aria-label="Quantity">
                                            <div class="input-group-append">
                                                <span class="input-group-text">${item.unit}</span>
                                            </div>
                                            <div class="form-text">
                                                Remarks if any
                                            </div>
                                        <input type="text" class="form-control" name="product[${index}][remarks]" maxlength="100" placeholder="Remarks">
                                    </div>

                                </div>
                            </div>`

                    });

                    // Populate and show the hidden div
                    $('#stockInfoContent').html(stockInfoHtml);
                    $('#stockInfoContainer').removeClass('d-none');
                    $('#stockEntryContainer').addClass('d-none');

                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                }
            });
        } else {
            Swal.fire({
            icon: 'warning',
            title: 'Missing Information',
            text: 'Please Select the assosiate first.',
            confirmButtonText: 'OK'
        });
        }
    });

    $('#stockForm').submit(function(e) {
    e.preventDefault(); // Prevents default form submission

    var formData = new FormData(this);
    console.log(formData);
    var date = $('#datePicker').val();

    if (!date) {
    // Create a new Date object for today's date
    var today = new Date();

    // Format the date as yyyy-mm-dd
    var day = String(today.getDate()).padStart(2, '0');
    var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
    var year = today.getFullYear();

    date = year + '-' + month + '-' + day;
}
formData.append('date', date);


    var hiddenValue = $('#typeField').val();
        var url = '';
            if (hiddenValue == 'int') {
                    url = '/stkinint/adjustint';
                    } else {
                    url = '/stkinint/adjustext';
                    }

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            Swal.fire({
                title: 'Stock Adjustment Successful',
                text: 'What would you like to do next?',
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Proceed for Next',
                cancelButtonText: 'Exit',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Trigger the click event on the updateStockButton
                    $('#updateStockButton').click();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Reload the page when "Exit" is clicked
                    location.reload();
                }
            });
        },
        error: function(xhr, status) {
            console.log(formData)
            console.error('AJAX error:', status);
        }
    });
});
$('#updateStockButton').on('click', function() {
    const name = $('#name').val();
        const mobileNumber = $('#mobile_number').val();
        const clid = $('#clid').val();

        // Ensure all required fields are filled
        if (name && mobileNumber&&clid) {
            $('#asidi').val(clid);

    $('#stockInfoContainer').addClass('d-none');
    $('#stockEntryContainer').removeClass('d-none');
        }else{
            Swal.fire({
            icon: 'warning',
            title: 'Missing Information',
            text: 'Please Select the assosiate first.',
            confirmButtonText: 'OK'
        });
        }
});



$('#productForm').submit(function(e) {
    e.preventDefault(); // Prevents default form submission

    var formData = new FormData(this);
    console.log(formData);
    var date = $('#datePicker').val();
    if (!date) {
    // Create a new Date object for today's date
    var today = new Date();

    // Format the date as yyyy-mm-dd
    var day = String(today.getDate()).padStart(2, '0');
    var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
    var year = today.getFullYear();

    date = year + '-' + month + '-' + day;
}
formData.append('date', date);

    var hiddenValue = $('#typeField').val();
        var url = '';
            if (hiddenValue == 'int') {
                    url = 'stkinint/finint';
                    } else {
                    url = 'stkinint/finext';
                    }

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
        Swal.fire({
            title: 'Stock Adjustment Successful',
            text: '',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                // Reload the page when "OK" is clicked
                location.reload();
            }
        });
    },
        error: function(xhr, status) {
            console.log(formData)
            console.error('AJAX error:', status);
        }
    });
});

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script>
    $(document).ready(function() {
    // Initialize select2 plugin for initial product dropdown with search
    initializeSelect2($('.product-select'));

    // Event handler for blur event on Quantity input
    $(document).on('blur', '.quantity-input', function() {
        if ($(this).val() !== '') {
            addNewRow($(this)); // Pass the current input element to the addNewRow function
        }
    });

    // Function to add a new row
    function addNewRow($currentInput) {
        var $clone = $currentInput.closest('.product-entry-line').clone(); // Clone the closest row
        $clone.find('select.product-select').removeClass('select2-hidden-accessible').next('.select2-container').remove(); // Clear the selected product and reset Select2
        $clone.find('input.quantity-input').val(''); // Clear the quantity input
        $clone.find('.unit-span').text(''); // Clear the unit span
        $('#product-entry').append($clone); // Append the cloned row to the container

        // Reinitialize Select2 for the new row's product dropdown
        initializeSelect2($clone.find('.product-select'));
    }

    // Function to initialize Select2
    function initializeSelect2($element) {

        $element.select2({
            placeholder: 'Select a product',
            width: '100%'
        });
    }

    // Event listener for product selection change
    $(document).on('change', '.product-select', function() {
        var unit = $(this).find('option:selected').data('unit');
        $(this).closest('.product-entry-line').find('.unit-span').text(unit);
    });

    // Trigger change event on page load to set initial units
    $('.product-select').trigger('change');


});
</script>
