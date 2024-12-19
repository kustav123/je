@extends('layouts.master')

@section('content')
@include('links.datatables');


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
        height: 6rem;
    }

    .w-250 {
        width: 250px;
    }

    .form-control {
        width: 100%;
    }

    .fixed-generate-invoice-btn-bottom {
        position: fixed;
        right: 30px;
        bottom: 0;
        z-index: 1030;
    }

    .w-10-rem{
        width: 10rem !important;
    }

    .w-6-rem{
        width: 6rem !important;
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
                                value="mobile" checked>
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
                                <input class="form-check-input" type="radio" name="select_company" id="select_company_{{ $item['id'] }}" value="{{ $item['id'] }}" @if ($loop->first) checked @endif>
                                <label class="form-check-label" for="select_company_{{ $item['id'] }}">{{ $item['name'] }}</label>
                            </div>
                        @endforeach

                    </fieldset>
                </div>
                <div class="col-md-3">
                    <fieldset class="border p-2">
                        <legend class="w-auto">Select Type</legend>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="S" value="S" checked>
                            <label class="form-check-label" for="S">Service</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="P" value="P">
                            <label class="form-check-label" for="P">Product</label>
                        </div>

                    </fieldset>
                </div>
                <button id="DeliveryChallanButton" class="btn btn-success mb-3">Fetch Delivery Challan</button>

            </div>
        </div>
    </div>



    <div class="row mt-3">
        <div class="col-md-12 text-center">
            <h4 style="color: blue;">Client Details</h4>
        </div>
    </div>

    @include('layouts.searchcl')

   <br><br>

    <div id="challan" class="card shadow mb-4 d-none" >
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Delivery Chalan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Chalan Id</th>
                            <th>Created </th>
                            <th>Action </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
<div class="container mt-3">
  <div class="row d-none" id="orderDetailsRow">
    <!-- Order No -->
    <div class="col-md-3 mb-3">
      <label for="orderNo">Order No.</label>
      <input type="text" class="form-control" id="orderNo" maxlength="30" placeholder="Enter Order No." required>
    </div>

    <!-- Order Date -->
    <div class="col-md-3 mb-3">
      <label for="orderDate">Order Date</label>
      <input type="date" class="form-control" id="orderDate" required>
    </div>

    <!-- Dispatched Through -->
    <div class="col-md-3 mb-3">
      <label for="dispatchedThrough">Dispatched Through</label>
      <input type="text" class="form-control" id="dispatchedThrough" maxlength="50" placeholder="Enter Dispatch Method" required>
    </div>

    <!-- Place of Supply -->
    <div class="col-md-3 mb-3">
      <label for="placeOfSupply">Place of Supply</label>
      <input type="text" class="form-control" id="placeOfSupply" maxlength="50" placeholder="Enter Place of Supply" required>
    </div>
  </div>
</div>
    <div id= "JobList" class="col-md-12 d-none" >
        <table class="table table-responsive" style="white-space:nowrap;">
            <thead>
                <tr>
                    <th></th>
                    <th>JobId</th>
                    <th>Type</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Serial Number</th>
                    <th>Rate</th>
                    <th>Narretion</th>
                </tr>
            </thead>
            <tbody class="challan-data"></tbody>
        </table>
    </div>

    <button class="btn btn-success mb-3 btn-lg fixed-generate-invoice-btn-bottom d-none" id="btn-generate-invoice">Generate Invoice</button>


    <div class="modal fade bd-example-modal-lg" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invoiceModalLabel">Invoice Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="invoiceModalContent">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="CloseInv()">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printInvoice()">Print</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="chaDetailsModal" tabindex="-1" role="dialog"
        aria-labelledby="chDetailsModalLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
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
                    </div>
                </div>
            </div>
        </div>
    </div>



@include('logics/searchcl')
@include('logics/srvnongst')
@endsection
