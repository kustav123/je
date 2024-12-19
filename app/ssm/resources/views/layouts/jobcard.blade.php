<div class="modal fade bd-example-modal-lg" id="jobDetailsModal" tabindex="-1" role="dialog"
    aria-labelledby="jobDetailsModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobDetailsModalLabel">Job Details</h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <div class="card-modal-body">
                <style>
                    @page {
                        size: auto;
                        margin: 0;
                    }

                    * {
                        margin: 0;
                        padding: 0;
                        box-sizing: border-box;
                    }

                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f7f7f7;
                    }

                    .invoice-container {
                        max-width: 800px;
                        margin: 20px auto;
                        background-color: #ffffff;
                        border: 1px solid #e0e0e0;
                        padding: 20px;
                    }

                    .invoice-container p {
                        margin: 0 !important;
                    }

                    .invoice-table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 20px;
                        /* Border */
                    }

                    .invoice-table th,
                    .invoice-table td {
                        border: 1px solid #dddddd;
                        padding: 8px;
                        text-align: left;
                    }

                    .invoice-table th {
                        background-color: #f2f2f2;
                    }

                    .bill_head {
                        display: flex;
                        justify-content: space-between;
                        align-items: start;

                    }

                    .bill_head img {
                        width: 50px;
                        height: 50px;
                        object-fit: cover;
                    }

                    .company-details {
                        text-align: center;
                        width: 50%;
                    }

                    .pd {
                        padding-block: 10px;
                    }

                    .esti {
                        width: 100%;
                        text-align: start;
                    }

                    .esti span {
                        font-weight: 100;
                    }

                    .bordered-container {
                        border: 1px solid rgb(215 204 204);
                        /* Adjust the border width and color as needed */
                        padding: 10px;
                        /* Optional: add padding inside the border */
                        border-radius: 10px;
                        /* Optional: add rounded corners */
                    }

                    .terms {
                        display: flex;
                        justify-content: space-between;
                        align-items: start;
                        font-size: 12px;
                    }

                    .authorized-signatory {

                        bottom: 0;
                        /* Align to the bottom of the container */
                        left: 0;
                        width: 19%;
                        text-align: center;
                        /* Center align the text */
                    }
                </style>
                <div class="invoice-container">
                    <div class="bill_head">
                        <div>
                            <img src="/img" alt="logo" id="logoImg" />
                        </div>
                        <div class="company-details">
                            <p>Receipt</p>
                            <h2 id="companyName">Company Name</h2>
                            <p id="companyAddress">Address Line 1</p>
                            <p id="companyContact">Email: company@example.com<br>Phone: (123) 456-7890</p>
                            <p id="gst">GST No.: </p>

                        </div>
                        <div>
                            <!-- <p id="date">Date : <span>12-12-2024</span></p> -->
                        </div>

                    </div>
                    <br>
                    <div class="bordered-container">

                        <div class="bill_head pd">
                            <div>
                                <p id="cname">Name</p>
                                <p id="caddress">Address</p>
                                <p id="cont">Email: company@example.com<br>Phone: (123) 456-7890</p>
                                <p id="cgst">GST NO: N/A</p>
                            </div>
                            <div class="invoice-details">
                                <p>Jobid : <span id="invoiceDate">FLCN/23-24/JB/00019</span></p>
                                <p id="date">Date : <span>12-12-2024</span></p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="bordered-container" id="tablesContainer" style="display: none;">
                        <!-- Tables will be dynamically added here -->
                    </div>
                    <div id = "invoice" class="bordered-container">

                        <table class="invoice-table">
                            <thead>
                                <th>Item</th>
                                <th>Make</th>
                                <th>Model</th>
                                <th>Serial No.</th>
                                <th>Property</th>

                            </thead>
                            <tbody id="jobDetailsTableBody">
                                <tr>
                                <tr id="row1">
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="esti">
                            <p id="accessary_list"></p>
                            <p id="complain_list"></p>
                            <p id="remarks_list"></p>
                            <p id="estimation_list"></p>
                        </div>
                    </div>
                    <br>
                    <div class="bordered-container">
                        <div class="terms">
                            <div>
                                <p> 1. Customers may need to pay a fixed inspection charge. </p>
                                <p> 2. Collect your laptop within 15 days after it is ready.</p>
                                <p> 3. Please check the accessories list and reported problems.</p>
                            </div>
                            <div class="authorized-signatory">
                                <br><br><br>
                                Authorized signatory
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal() ">Close</button>
                <button type="button" class="btn btn-primary" onclick="printJobDetails()">Print</button>
            </div>
        </div>
    </div>

</div>

