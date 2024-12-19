@extends('layouts.master')

@section('content')
<!-- Bootstrap CSS (if not already included) -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Bootstrap Datepicker CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />


<!-- Bootstrap JS (if not already included) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Bootstrap Datepicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

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

        .select2-container--default .select2-selection--single {
            border: 0 !important;
        }

        .select2-selection__rendered{
            width: 100%;
            height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #6e707e;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #d1d3e2;
            border-radius: .35rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 6px !important;
        }

        /* toggle select box design end */
    </style>
    @include('links.datatables')
    <div class="container">
        <form class="form-horizontal" id="jobForm">
            @csrf
            <input type="hidden" id="clid" name="clid">
            <input type="hidden" name="purpose" id="purpose" value="insert">
            <input type="hidden" name="itid" id="itid">


            <div class="row">
                <!-- Job ID and Queue Number Section - Read-only Centered -->
                <div class="col-md-12  text-center">

                    <div class="row">


                        <div class="container">
                            <div class="row">
                                <div class="col-md-3">
                                    <fieldset class="border p-2">
                                        <legend class="w-auto">Search by</legend>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="search_by" id="search_by_mobile"
                                                   value="mobile" checked>
                                            <label class="form-check-label" for="search_by_mobile">Mobile</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="search_by" id="search_by_name"
                                                   value="name">
                                            <label class="form-check-label" for="search_by_name">Name</label>
                                        </div>


                                    </fieldset>
                                </div>
                                <div class="col-md-4">
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
                            <div class="row">
                                <div class="col-md-2">
                                     <div class="form-group" >
                                        <label for="datePicker">Select Date:</label>
                                        <input type="text" id="datePicker" name="datePicker" class="form-control" data-date-end-date="0d" required>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function(){
                                        $('#datePicker').datepicker({
                                            format: 'yyyy-mm-dd',
                                            autoclose: true,
                                            startDate: '-7d'
                                        });
                                    });
                                    </script>


                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="bank">Bank</label>
                                        <input type="text" id="bank" name="bank" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="refAccontNo"> Account</label>
                                        <input type="text" id="refAccontNo" name="refAccontNo" class="form-control" maxlength="35" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="mode"> Mode:</label>
                                        <select id="mode" name="mode" class="form-control" required>
                                            <option value="" disabled selected>None</option>
                                            <option value="UPI">UPI</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Cheque">Cheque</option>
                                            <option value="Online Transfer">Online Transfer</option>


                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tid">Transaction ID</label>
                                        <input type="text" id="tid" name="tid" class="form-control" maxlength="40">
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>



            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    <h4 style="color: blue;">Supplier Details</h4>
                </div>
            </div>

            @include('layouts.searchsl')


            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    <h4 style="color: blue;">Particulars</h4>
                </div>
            </div>
            <div class="row">
                    <div class="col-md-4">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Amount" required>
                    </div>
                    <div class="col-md-8">
                        <label for="comment">Comment</label>
                        <input type="text" class="form-control" id="comment" name="comment" placeholder="Enter Comment" maxlength="90">
                    </div>
                </div>
            </div>
                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal fade bd-example-modal-lg" id="jobDetailsModal" tabindex="-1" role="dialog"
            aria-labelledby="jobDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="jobDetailsModalLabel">Payment Slip</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
                                      <h6></h2> Payment Slip</h6></h2>

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

                                <p>Sum of Ammount
                                    <span id="Ammount">1234.00 </span>
                                    recived by M/S <span id="cname">Name</span>
                                    haveing registraction no
                                    <span id="sid">STj33  </span>
                                    from
                                    <span id="cn">Compnay name </span>
                                    via
                                    <span id="Pmode">mode  </span>
                                    payment for
                                    <span id="stmnt"> Remarks </span>
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
        @include('logics/suppay')
        @include('logics/searchsl')

    @endsection
