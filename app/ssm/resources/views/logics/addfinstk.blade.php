<!-- Include SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<!-- Include SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<script type="text/javascript">




        // Autocomplete by name



    $('#jobForm').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: "{{ url('stkfinent/skent') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: (data) => {
            Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Reload the page after confirmation
                    location.reload();
                }
            });
        },
        error: function(data) {
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while processing your request.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Reload the page after confirmation
                    location.reload();
                }
            });
        }
        });
    });
    // Event listener for quantity input


document.addEventListener('DOMContentLoaded', function() {



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

    });

    // Event listener for blur on the last quantity input field

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
