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

        /* toggle select box design start */
        .toggle-next {
            border-radius: 0;
            cursor: pointer !important;
        }

        label {
            cursor: pointer !important;
        }

        .ellipsis {
            text-overflow: ellipsis;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
        }

        .apply-selection {
            display: none;
            width: 100%;
            margin: 0;
            padding: 5px 10px;
            border-bottom: 1px solid #ccc;
        }

        .apply-selection .ajax-link {
            display: none;
        }

        .checkboxes {
            margin: 0;
            display: none;
            border: 1px solid #ccc;
            border-top: 0;
        }

        .checkboxes .inner-wrap {
            padding: 5px 10px;
            max-height: 140px;
            overflow: auto;
        }


        /* Model autocomplet
         */

         .autocomplete-suggestions {
            border: 1px solid #ddd;
            border-radius: 4px;
            max-height: 150px; /* Adjust height as needed */
            overflow-y: auto; /* Adds scrollbar if content exceeds max-height */
            background-color: #fff;
            position: absolute;
            width: calc(100% - 2px); /* Full width minus border */
            z-index: 1000;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Optional shadow for better visibility */
        }

        /* Each suggestion item */
        .autocomplete-suggestion {
            padding: 10px;
            cursor: pointer;
            font-size: 14px; /* Adjust font size as needed */
        }

        /* Highlight suggestion on hover */
        .autocomplete-suggestion:hover {
            background-color: #f0f0f0;
            color: #333;
        }

        /* Optional styling for better visibility */
        .autocomplete-suggestion:active {
            background-color: #e0e0e0;
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
                        {{-- <div class="col-md-3">
                            <label for="job_id">Last Job ID</label>
                            <input type="text" class="form-control text-center" id="job_id" name="job_id" readonly
                                value="{{ $head }}/{{ $newJobId }}">
                        </div> --}}

                        <table style="max-width: 300px; padding: 5px; font-size: 14px; border-collapse: collapse; border: 1px solid #ddd;">
                            <thead>
                                <tr>
                                    <th style="border: 1px solid #ddd; padding: 8px; font-size: 16px;" colspan="2">Expected Job ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid #ddd; padding: 8px;"><strong>Falcon</strong></td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $flseq->sno + 1 }}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd; padding: 8px;"><strong>Falcon Electronic</strong></td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $feseq->sno + 1 }}</td>
                                </tr>
                            </tbody>
                        </table>


                        <!-- Display the FL Sequence -->

                        <div class="col-md-1">
                            <label for="queue_number">Queue</label>
                            <input type="text" class="form-control text-center" id="queue_number" name="queue_number"
                                readonly value="{{ $newqueue }}">
                        </div>
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
                    <h4 style="color: blue;">Item Details</h4>
                </div>
            </div>
            <input type="hidden" id="newmodel" name="newmodel" value="1">

            <div class="row">
                <div class="col-md-4">
                    <label for="item">Item</label>
                    <select class="form-control" id="item" name="item" required></select>
                </div>
                <div class="col-md-4">
                    <label for="make">Make</label>
                    <select class="form-control" id="make" name="make"></select>
                </div>
                <div class="col-md-4">
                    <label for="model">Model</label>
                    <input type="text" class="form-control" id="model" name="model"
                        placeholder="Enter Model Number">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="snno">Serial Number</label>
                    <input type="text" class="form-control" id="snno" name="snno"
                        placeholder="Enter Serial Number">
                </div>
                <div class="col-md-4">
                    <label for="property">Property</label>
                    <input type="text" class="form-control" id="property" name="property"
                        placeholder="Enter Property">
                </div>
                <div class="col-md-4">
                    <label for="rest">Rough Estimation</label>
                    <input type="number" class="form-control" id="rest" name="rest"
                        placeholder="Enter Estimation">
                </div>

            </div>

            <div class="row mt-3 justify-content-center">
                <div class="col-md-4">
                    <label for="complain">Complain </label>
                    {{-- <select class="form-control" id="complain" name="complain[]" multiple> </select> --}}
                    <span class="form-control toggle-next ellipsis">Complain</span>
                    <div class="checkboxes" id="complain">
                        <div class="inner-wrap inner-wrap-complain">

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="accessary">Accessory</label>
                    {{-- <select class="form-control" id="accessary" name="accessary[]" multiple></select> --}}
                    <span class="form-control toggle-next ellipsis">Accessory</span>
                    <div class="checkboxes" id="accessary">
                        <div class="inner-wrap inner-wrap-accessary">

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="job_remarks">Job Remarks</label>
                    <input type="text" class="form-control" id="job_remarks" name="job_remarks" required>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>

            @include('layouts.jobcard')

            @include('logics/addjob')
            @include('logics/searchcl')


@endsection
