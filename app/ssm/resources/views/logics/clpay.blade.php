<script type="text/javascript">

document.addEventListener('DOMContentLoaded', function() {
        const searchByMobile = document.getElementById('search_by_mobile');
        const searchByName = document.getElementById('search_by_name');
        const mobileNumberInput = document.getElementById('mobile_number');
        const nameInput = document.getElementById('name');

        // Initially set mobile number input to enabled and name input to readonly

        nameInput.removeAttribute('readonly');
        mobileNumberInput.setAttribute('readonly', 'readonly');

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
            $('#state').val(client.state);
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
            $('#state').val('');
            $('#clid').val('');
        }
    }

    document.getElementById('amount').addEventListener('input', function (e) {
            var value = parseFloat(e.target.value);

            // Prevent negative values
            if (value < 0) {
                e.target.value = 0;
            }
        });

$('#adjustButton').on('click', function() {
    $(this).prop('disabled', true);

    $(this).text('Processing...');
    let clid = $('#clid').val();
    let payam = parseFloat($('#amount').val()) || 0;
    let initialPayam = payam;
    let paymentMode = $('#payment_mode').val();
    let date = $('#date').val();
    let tid = $('#tid').val();

    // Validation checks
    if (!clid) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'First select the client',
            confirmButtonText: 'OK'
        }).then(() => {
            $('#adjustButton').prop('disabled', false);
        });
        return; // Exit the function early if clid is blank
    }

    if (payam <= 0) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please enter a valid amount',
            confirmButtonText: 'OK'
        }).then(() => {
            $('#adjustButton').prop('disabled', false);
        });
        return; // Exit the function early if payam is not valid
    }

    if (!date) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please select a date',
            confirmButtonText: 'OK'
        }).then(() => {
            $('#adjustButton').prop('disabled', false);
        });
        return; // Exit the function early if date is not selected
    }

    if (!paymentMode) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please select a payment mode',
            confirmButtonText: 'OK'
        }).then(() => {
            $('#adjustButton').prop('disabled', false);
        });
        return; // Exit the function early if payment mode is not selected
    }
function getSelectedCompanyId() {
    return $('input[name="select_company"]:checked').val();
}
    $('#adjustButton').prop('disabled', true);
    let coid = getSelectedCompanyId();


        $.ajax({
            url: '/getdueinv',
            type: 'POST',
            data: { clid: clid, coid: coid }, 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#invoice-container').empty();

                const container = $('#invoice-container');

                container.append(`
        <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; width: 20%;">Invoice ID</th>
                    <th style="border: 1px solid #ddd; padding: 8px; width: 20%;">Created On</th>
                    <th style="border: 1px solid #ddd; padding: 8px; width: 20%;">Total Amount</th>
                    <th style="border: 1px solid #ddd; padding: 8px; width: 20%;">Due Amount</th>
                    <th style="border: 1px solid #ddd; padding: 8px; width: 20%;">Paid Amount</th>
                </tr>
            </thead>
            <tbody>
    `);

    response.forEach(invoice => {
        let paidAmount = 0;
        let remainingAmount = parseFloat(invoice.dueamount);

    if (payam > 0) {
        if (remainingAmount <= payam) {
            paidAmount = remainingAmount;
            payam -= remainingAmount;
        } else {
            paidAmount = payam;
            payam = 0;
        }
    }

    container.append(`
    <tr class="invoice-item">
            <td style="border: 1px solid #ddd; padding: 8px; width: 20%;">${invoice.uid}</td>
            <td style="border: 1px solid #ddd; padding: 8px; width: 20%;">${invoice.formatted_created_at}</td>
            <td style="border: 1px solid #ddd; padding: 8px; width: 20%;">${invoice.total_amount_including_gst}</td>
            <td style="border: 1px solid #ddd; padding: 8px; width: 20%;">${invoice.dueamount}</td>
            <td style="border: 1px solid #ddd; padding: 8px; width: 20%;">
                <input type="number" class="additional-info" data-id="${invoice.uid}" data-remaining-amount="${invoice.dueamount}" value="${paidAmount}" placeholder="Paid amount" style="width: 100%;">
            </td>
        </tr>
    `);
}); 
            container.append(`
                <div class="submit-container">
                    <button type="button" class="btn btn-submit">Generate Voucher</button>
                </div>
            `);

            $('.btn-submit').on('click', function() {
                $(this).prop('disabled', true);

                $(this).text('Processing...');
                const selectedItems = [];
                let paymentMode = $('#payment_mode').val();
                let paymentDate = $('#date').val();
                let name = $('#name').val();
                let remarks = $('#payremarks').val();
                let tid = $('#tid').val();
                let clid = $('#clid').val();
                let payam = parseFloat($('#amount').val()) || 0;

                $('.invoice-item').each(function() {
                    const additionalInfo = $(this).find('.additional-info').val();
                    const invoiceId = $(this).find('.additional-info').data('id');
                    const remainingAmount = $(this).find('.additional-info').data('remaining-amount');
                    const paidAmount = parseFloat(additionalInfo); // Ensure paidAmount is a number

                    if (!isNaN(paidAmount) && paidAmount > 0) {
                        selectedItems.push({ invoiceId, paidAmount, remainingAmount });
                    }
                });

                // Calculate total paid amount
                let totalPaidAmount = selectedItems.reduce((acc, item) => acc + item.paidAmount, 0);
                let difference = payam - totalPaidAmount;

                if (totalPaidAmount !== payam) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Adjustment Error',
                        text: `Sum in Invoice Rs ${totalPaidAmount.toFixed(2)} does not match the  payment amount of Rs ${payam.toFixed(2)}. The difference is Rs ${difference.toFixed(2)} Press cencel to readjust or Ok to continue .`,
                        showCancelButton: true,
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'clpay/payslip',
                                type: 'POST',
                                data: JSON.stringify({
                                    ammount: initialPayam, // Corrected typo here
                                    payment_mode: paymentMode,
                                    payment_date: paymentDate,
                                    remarks: remarks,
                                    clid: clid,
                                    tid: tid,
                                    name: name,
                                    company: $('input[name="select_company"]:checked').val(),
                                    items: selectedItems
                                }),
                                contentType: 'application/json',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: (data) => {
                                    showJobDetailsModal(data)
                                },
                                error: function(xhr, status, error) {
                                    console.error('Submit error:', error);
                                }
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // User clicked "Cancel"
                            // Re-enable the button
                            $('#adjustButton').prop('disabled', false);
                        }
                    });
                } else {
                    // Proceed with submission if amounts match
                    $.ajax({
                        url: 'clpay/payslip',
                        type: 'POST',
                        data: JSON.stringify({
                            ammount: initialPayam,
                            payment_mode: paymentMode,
                            payment_date: paymentDate,
                            remarks: remarks,
                            clid: clid,
                            tid: tid,
                            name: name,
                            company: $('input[name="select_company"]:checked').val(),
                            items: selectedItems
                        }),
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: (data) => {
                                    showJobDetailsModal(data)
                        },
                        error: function(xhr, status, error) {
                            console.error('Submit error:', error);
                        }
                    });
                }
            });
        },
        error: function(xhr, status, error) {
            let response = JSON.parse(xhr.responseText);

// Show the error message using Swal
        Swal.fire({
            icon: 'error',  // Type of alert (error)
            title: 'Oops...',
            text: response.error,  // Display the error message from the response
        });        }
    });
});
    function showJobDetailsModal(jobDetails) {
            $('#companyName').text(jobDetails.CompName);
                $('#companyAddress').html(`
                    ${jobDetails.CompAddress}<br>
                `);
                $('#companyContact').html(`
                    Email: ${jobDetails.Compemail}<br>
                    Phone: ${jobDetails.Compcont1}
                `);
            $('#date span').text(jobDetails.date);

            $('#invoiceDate').text(jobDetails.Jobid);
            $('#gst').text(`GST No: ${jobDetails.CompGST}`);
            $('#logoImg').attr('src', jobDetails.CompLogo); // Update src attribute


            $('#cname').text(` ${jobDetails.Name}`);
            $('#cn').text(` ${jobDetails.CompName}`);
            $('#mode').text(` ${jobDetails.mode}`);


            let amount = jobDetails.ammount ? parseFloat(jobDetails.ammount).toFixed(2) : '0.00'; // Convert to float and format to 2 decimals, or default to 0.00
            $('#Ammount').text(`₹ ${amount}`);            $('#sid').text(` ${jobDetails.scid}`);
            $('#stmnt').text(` ${jobDetails.remarks}`);
            $('#Pmode').text(` ${jobDetails.mode}`);
            $('#tridid').text(` ${jobDetails.tid}`);
            $('#jobDetailsModal').modal('show');
        }

        function printJobDetails() {
            var divContents = $(".modal-body").html();
            var printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title>Property Report</title>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }

        function closeModal() {
            $('#jobDetailsModal').modal('hide');
            window.location.href = '/clpay';
        }
    </script>


