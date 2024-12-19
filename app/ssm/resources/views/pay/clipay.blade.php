@extends('layouts.master')

@section('content')


<style>
    .p-2 {
        padding: .1rem !important;
    }

    .name-textfield {
        position: relative;
    }

    #nameSuggestions {
        position: absolute;
        width: 93%;
        z-index: 9;
        overflow: auto;
        height: 10rem;
    }

    .w-250 {
        width: 250px;
    }

    .form-control {
        width: 100%;
    }
    .border-container {
            border: 1px solid #ddd; /* Border around the container */
            border-radius: 5px; /* Rounded corners */
            padding: 15px; /* Padding inside the border */
            margin-top: 20px; /* Space above the container */
        }
        .invoice-item {
            display: flex; /* Use flexbox to align items horizontally */
            align-items: center; /* Center items vertically */
            margin-bottom: 10px; /* Add some space between items */
            padding: 10px; /* Add padding around each item */
            border-bottom: 1px solid #ddd; /* Border between items */
        }
        .invoice-item:last-child {
            border-bottom: none; /* Remove border for the last item */
        }
        .invoice-item span {
            flex: 1; /* Allow the message to take up remaining space */
            margin-right: 10px; /* Add space between the message and the checkbox/input */
        }
        .invoice-item input.additional-info {
            margin-right: 10px; /* Add space between the text box and the submit button */
        }
        .submit-container {
            margin-top: 20px; /* Add space above the submit button */
            text-align: center; /* Center align the submit button */
        }
        .submit-container .btn-submit {
            padding: 10px 20px; /* Add padding to the button */
            background-color: #007bff; /* Button background color */
            color: white; /* Button text color */
            border: none; /* Remove border */
            border-radius: 5px; /* Rounded corners for the button */
            cursor: pointer; /* Pointer cursor on hover */
        }
        .submit-container .btn-submit:hover {
            background-color: #0056b3; /* Darker button background color on hover */
        }
        .invoice-item input[type="checkbox"] {
    margin-right: 15px; /* Add space between the checkbox and the message */
}
</style>
<div class="container">
    @csrf
    <input type="hidden" id="clid" name="clid">
    <input type="hidden" name="purpose" id="purpose" value="insert">
    <input type="hidden" name="itid" id="itid">

    <div class="row">
        <!-- Job ID and Queue Number Section - Read-only Centered -->
        <div class="col-md-12  text-center ">

            <div class="row">
                {{-- <div class="col-md-3">
                    <label for="job_id">Temporary Job ID</label>
                    <input type="text" class="form-control text-center" id="job_id" name="job_id" readonly
                        value="">
                </div> --}}

                <div class="col-md-3">
                    <fieldset class="border p-2">
                        <legend class="w-auto">Search by</legend>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="search_by" id="search_by_mobile"
                                value="mobile" >
                            <label class="form-check-label" for="search_by_mobile">Mobile</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="search_by" id="search_by_name"
                                value="name" checked>
                            <label class="form-check-label" for="search_by_name">Name</label>
                        </div>

                    </fieldset>
                </div>

                <div class="col-md-3">
                    <fieldset class="border p-2">
                        <legend class="w-auto">Select Company</legend>

                        @foreach ($listcomp as $item)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="select_company"
                                    id="select_company_{{ $item['id'] }}" value="{{ $item['id'] }}"
                                    @if ($loop->first) checked @endif>
                                <label class="form-check-label"
                                    for="select_company_{{ $item['id'] }}">{{ $item['name'] }}</label>
                            </div>
                        @endforeach

                    </fieldset>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-3">
        <div class="col-md-12 text-center">
            <h4 style="color: blue;">Client Details</h4>
        </div>
    </div>

    @include('layouts.searchcl')
    <div class="row mt-3">
        <div class="col-md-12 text-center">
            <h4 style="color: blue;">Payment Details</h4>
        </div>
    </div>

    <div class="row mt-3">
        <!-- Amount and Date in one row with adjusted sizes -->
        <div class="col-md-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">₹</span>
                </div>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Amount">
            </div>
        </div>

        <div class="col-md-3">
            <input type="date" class="form-control" id="date" name="date" placeholder="Select Date" max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
        </div>
            <!-- Mode of Payment and Transaction ID in one row with adjusted sizes -->
            <div class="col-md-3">
                <select class="form-control" id="payment_mode" name="payment_mode">
                    <option value="">Mode of Payment</option>
                    <option value="UPI">UPI</option>
                    <option value="Check">Cheque</option>
                    <option value="Cash">Cash</option>
                    <option value="Card">Card</option>
                    <option value="NEFT">NEFT</option>
                </select>
            </div>
        <div class="col-md-3">
            <input type="text" class="form-control" id="tid" name="tid" maxlength="70" placeholder="Enter Transaction ID">
        </div>
    </div>



    <div class="row mt-3">
        <!-- Remarks beside Amount and Date -->
        <div class="col-md-9">
            <textarea class="form-control" id="payremarks" name="payremarks" rows="1" maxlength="200" placeholder="Enter Remarks"></textarea>
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-primary w-100" id="adjustButton">Amount Adjustment</button>
        </div>
    </div>


</div>
    <div id="invoice-container"></div>

    <div class="modal fade bd-example-modal-lg" id="jobDetailsModal" tabindex="-1" role="dialog"
         aria-labelledby="jobDetailsModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobDetailsModalLabel">Payment Slip</h5>

                </div>
                <div class="modal-body">
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
                        @media print {
                            .modal-footer {
                                display: none;
                            }
                        }
                    </style>
                    <div class="invoice-container">
                        <div class="bill_head">
                            <div>
                                <img src="/img" alt="logo" id="logoImg" />
                            </div>
                            <div class="company-details">
                                <h6>Payment Slip</h6>

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
                                <p id="date">Date : <span>12-12-2000</span></p>
                                </div>
                                <div>
                                 <p>Entry ID : <span id="invoiceDate">111111111111</span></p>
                                </div>
                            </div>
                            <br>
                         <div class="invoice-details">


                                <p>Sum of amount
                                    <span id="Ammount">____ </span>
                                    recived From  <span id="cname">____</span>
                                    to
                                    <span id="cn">____</span>
                                    via
                                    <span id="Pmode">____ </span>
                                Payment of transaction ID
                                <span id="tridid"> ____ </span>
                                on account of
                                    <span id="stmnt"> ____________ </span>
                                </p>


                                <br><br><br>

                        </div>

                        <br>
                        <div class="bordered-container">
                            <div class="terms">
                                <div>
                                    <br><br><br>

                                    <p> Receivers signature </p>
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
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printJobDetails()">Print</button>
                </div>
            </div>
        </div>

    </div>

            @include('logics/searchcl')
            @include('logics/clpay')
@endsection
