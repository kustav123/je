@extends('layouts.master')

@section('content')
<div class="container">
    @include('links.datatables')

    <div class="row">
        <input type="hidden" id="clid" name="clid">



        <div class="col-md-9">
            <fieldset class="border p-2">
                <legend class="w-auto">Date Range and Export Options</legend>

                <div class="row align-items-center">
                    <!-- From Date Picker -->
                    <div class="form-group col-md-3">
                        <label for="from_date" class="form-label">From:</label>
                        <input type="date" id="from_date" name="from_date" class="form-control">
                    </div>

                    <!-- To Date Picker -->
                    <div class="form-group col-md-3">
                        <label for="to_date" class="form-label">To:</label>
                        <input type="date" id="to_date" name="to_date" class="form-control">
                    </div>

                    <!-- Export Options -->
                    <div class="form-check form-check-inline col-md-1 d-flex align-items-center">
                        <input class="form-check-input" type="checkbox" id="export_pdf" value="pdf">
                        <label class="form-check-label" for="export_pdf" class="ml-2">   <img src="pdf.png" alt="Excel" style="width: 50px; height: auto;"> </label>
                    </div>

                    <div class="form-check form-check-inline col-md-1 d-flex align-items-center">
                        <input class="form-check-input" type="checkbox" id="export_excel" value="excel">
                        <label class="form-check-label" for="export_excel" class="ml-2">  <img src="xls.png" alt="Excel" style="width: 50px; height: auto;"> </label>
                    </div>

                    @foreach ($listcomp as $item)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="select_company" id="select_company_{{ $item['id'] }}" value="{{ $item['id'] }}" @if ($loop->first) checked @endif>
                        <label class="form-check-label" for="select_company_{{ $item['id'] }}">{{ $item['name'] }}</label>
                    </div>
                @endforeach
                </div>

            </fieldset>
        </div>

    </div>

    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <button id="accountStatementBtn" class="btn btn-primary">Account Statement</button>
            <button id="invoiceStatementBtn" class="btn btn-primary">Invoice Status</button>
            <button id="invoiceAccStatementBtn" class="btn btn-primary">GST Invoice Statement</button>


        </div>
    </div>
<br>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary mr-2">
            Report List
            <button class="btn btn-link text-primary p-0" onclick="window.location.reload();" title="Reload Page">
                <i class="fas fa-sync-alt"></i> 
            </button>
        </h6>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered text-nowrap" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created at</th>

                        <th>Link</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $client)
                    <tr>
                        <td>{{ $client->report_name }}</td>
                        <td>{{ $client->created_at->format('Y-m-d H:i:s') }}</td>

                        <td>
                            @if ($client->report_type === 'PDF')
                                <a href="{{ asset('storage/' . $client->link) }}" target="_blank">
                                    <img src="pdf.png" alt="PDF" style="width: 24px; height: auto;">
                                </a>
                            @else
                                <a href="{{ asset('storage/' . $client->link) }}" target="_blank">
                                    <img src="xls.png" alt="Excel" style="width: 24px; height: auto;">
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            pageLength: 3,
            searching: true,
            ordering: false

        });
    });
</script>

@include('logics/coreport')

@endsection
