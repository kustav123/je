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
            height: 4rem;
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

            <input type="hidden" id="clid" name="clid">
            <input type="hidden" name="type" value="{{ $type }}" id="typeField">



            <div class="row">
                <!-- Job ID and Queue Number Section - Read-only Centered -->
                <div class="col-md-12  text-center">

                    <div class="row">


                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-4">
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
                                            startDate: '-15d'
                                        });
                                    });
                                </script>
                                {{-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="remarks">Remarks:</label>
                                        <input type="text" id="efInvoiceNo" name="efInvoiceNo" class="form-control" maxlength="100" >
                                    </div>
                                </div> --}}

                                <div class="col-md-3 d-flex justify-content-center">
                                    <div class="form-group">
                                        <button type="button" id="fetchStockButton" class="btn btn-primary">Fetch Assigned Stock </button>
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex justify-content-center">
                                    <div class="form-group">
                                        <button type="button" id="updateStockButton" class="btn btn-primary">Receive Finish Item</button>
                                    </div>
                                </div>


                            </div>

                            <div class="row justify-content-center">

                            </div>

                        </div>


                    </div>
                </div>
            </div>



            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    <h4 style="color: blue;">Assosiate Details</h4>
                </div>
            </div>

            @include('layouts.searchia')
            <br>


            <div id="stockInfoContainer" class="col-md-12 text-center d-none">
                <h4 style="color: blue;">Stock Information</h4>
                <form class="form-horizontal" id="stockForm">
                    @csrf
                    <!-- Stock information will be dynamically populated here -->
                    <input type="hidden" id="asid" name="asid">

                    <div id="stockInfoContent"></div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Adjust Stock</button>
                </form>
            </div>

    <div id="stockEntryContainer" class="d-none">

            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    <h4 style="color: blue;">Finish Product List</h4>
                </div>
            </div>
              <div class="container mt-5">
                <form id="productForm">
                    <input type="hidden" id="asidi" name="asidi">

                    <div id="product-entry">
                        <!-- Row template -->
                        <div class="row mb-3 product-entry-line">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label for="product">Product</label>

                                <select class="form-control product-select" name="products[][product_id]">
                                    <option value="" disabled selected>Select a product</option>

                                    @foreach($lp as $item)
                                        <option value="{{ $item['id'] }}" data-unit="{{ $item['unit'] }}">{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="quantity">Quantity</label>
                                <div class="d-flex align-items-center">
                                    <input type="number" class="form-control quantity-input" name="products[][quantity]" style="flex: 1;">
                                    <span class="unit-span fw-bold ms-2" style="padding-left: 5px;"></span>
                                </div>
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

        </div>



        @include('logics/stkin')
        @include('logics/searchia')

    @endsection
