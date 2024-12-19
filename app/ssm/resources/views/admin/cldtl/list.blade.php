@extends('layouts.master')

@section('content')
    @include('links.datatables')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>

    </div>
    <input type="hidden" id="clid" value="{{ $clid }}">
    <input type="hidden" id="dcid">

    <button id="DeliveryChallanButton" class="btn btn-success mb-3">Fetch Delivery Challan</button>
    <button id="FetchJobButton" class="btn btn-success mb-3">Fetch All Jobs</button>
    <button id="FetchInvButton" class="btn btn-success mb-3">Fetch All Inovoice</button>

    <div id="challan" class="card shadow mb-4 d-none">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Delivery Chalan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="chdataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Chalan Id</th>
                            <th>Created </th>
                            <th>Invoice </th>
                            <th>Action </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>


    <div id="job" class="card shadow mb-4 d-none">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Jobs</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="jobdataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th> <!-- Checkbox to select all -->

                            <th>ID</th>
                            <th>Created Date</th>
                            <th>Item</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Serial</th>
                            <th>Status</th>
                            <th>Assigned</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <button id="print-jobs-btn" class="btn btn-primary mt-3" data-toggle="tooltip" data-placement="top" title="Client info will feteched from 1st entry only">Print Selected Jobs</button>


        </div>
    </div>





    <div class="modal fade bd-example-modal-lg" id="chaDetailsModal" tabindex="-1" role="dialog"
        aria-labelledby="chDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chsDetailsModalLabel">Challan Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="ch-modal-body">
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

                        .chinvoice-container {
                            max-width: 800px;
                            margin: 20px auto;
                            background-color: #ffffff;
                            border: 1px solid #e0e0e0;
                            padding: 20px;
                        }

                        .chinvoice-container p {
                            margin: 0 !important;
                        }

                        .chinvoice-table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-bottom: 20px;
                            /* Border */
                        }

                        .chinvoice-table th,
                        .chinvoice-table td {
                            border: 1px solid #dddddd;
                            padding: 8px;
                            text-align: left;
                        }

                        .chinvoice-table th {
                            background-color: #f2f2f2;
                        }

                        .chbill_head {
                            display: flex;
                            justify-content: space-between;
                            align-items: start;

                        }

                        .chbill_head img {
                            width: 50px;
                            height: 50px;
                            object-fit: cover;
                        }

                        .chcompany-details {
                            text-align: center;
                            width: 50%;
                        }

                        .pd {
                            padding-block: 10px;
                        }

                        .chesti {
                            width: 100%;
                            text-align: start;
                        }

                        .chesti span {
                            font-weight: 100;
                        }

                        .chbordered-container {
                            border: 1px solid rgb(215 204 204);
                            /* Adjust the border width and color as needed */
                            padding: 10px;
                            /* Optional: add padding inside the border */
                            border-radius: 10px;
                            /* Optional: add rounded corners */
                        }

                        .chterms {
                            display: flex;
                            justify-content: space-between;
                            align-items: start;
                            font-size: 12px;
                        }

                        .chtermsit {
                            display: flex;
                            justify-content: space-between;
                            align-items: start;
                            font-size: 16px;
                        }

                        .chauthorized-signatory {

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
                    <div class="chinvoice-container">
                        <div class="chbill_head">
                            <div>
                                <img src="/img" alt="logo" id="chlogoImg" />
                            </div>
                            <div class="chcompany-details">
                                <p>Delivery Challan</p>

                                <h2 id="chcompanyName">Company Name</h2>
                                <p id="chcompanyAddress">Address Line 1</p>
                                <p id="chcompanyContact">Email: company@example.com<br>Phone: (123) 456-7890</p>
                                <p id="chgst">GST No.: </p>

                            </div>
                            <div>
                                <!-- <p id="date">Date : <span>12-12-2024</span></p> -->
                            </div>

                        </div>
                        <br>

                        <div class="chbordered-container">

                            <div class="chbill_head pd">
                                <div>


                                    <p id="chcname">Name</p>
                                    <p id="chcaddress">Address</p>
                                    <p id="chcont">Email: company@example.com<br>Phone: (123) 456-7890</p>
                                    {{-- <p id="cgst">GST NO: N/A</p> --}}
                                </div>
                                <div class="invoice-details">
                                    <p>Chalan id : <span id="chinvoiceid"></span></p>
                                    <p id="chdate">Date : <span></span></p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="chbordered-container">


                            <div id="chitm" class="bordered-container">



                            </div>
                            <br>
                            <div class="chbordered-container">
                                <div class="chterms">
                                    <div>
                                        <br><br>
                                        <p>Item received</p>
                                        <p>Authorized signatory</p>
                                    </div>
                                    <div class="authorized-signatory">
                                        <br><br><br>
                                        <p>Authorized signatory</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeChModal() ">Close</button>
                        <button type="button" class="btn btn-primary" onclick="printChDetails()">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="updatedc" tabindex="-1" role="dialog" aria-labelledby="updatedcLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatedcLabel">Update Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="chbox" class="col-md-12">
                    <table class="table table-responsive" style="white-space:nowrap;">
                        <thead>
                            <tr>
                                <th></th>
                                <th>JobId</th>
                                <th>Detail</th>
                                <!-- Commented out columns -->
                                <!-- <th>Make</th>
                                <th>Model</th>
                                <th>Serial Number</th>
                                <th>Property</th> -->
                                <!-- <th>Rough Estimation</th> -->
                                <th>Complain</th>
                                <th>Accessory</th>
                                <th>Job Remarks</th>
                                <th>Set status</th>
                            </tr>
                        </thead>
                        <tbody class="box-challan-data"></tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center">
                    <button id="updateDeliveryChallan" class="btn btn-primary">Submit</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deletedc" tabindex="-1" role="dialog" aria-labelledby="deletedcLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletedccLabel">Update Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="chbox" class="col-md-12">
                    <table class="table table-responsive" style="white-space:nowrap;">
                        <thead>
                            <tr>
                                <th></th>
                                <th>JobId</th>
                                <th>Device Detail</th>
                                <th>Job Detail</th>

                            </tr>
                        </thead>
                        <tbody class="del-box-challan-data"></tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center">
                    <button id="delDeliveryChallan" class="btn btn-primary">Submit</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

 @include('layouts.jobcard')

        <!-- boostrap blog model -->

        <!-- end bootstrap model -->


@include('logics/listclhis')
    @endsection
