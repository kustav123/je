@extends('layouts.master')

@section('content')
   @include('links.datatables')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>

    </div>
    <input type="hidden" id="clid" value="{{ $clid }}">
    <button id="AssignmentStockButton" class="btn btn-success mb-3">Fetch Stock Assignment History</button>
    <button id="updateStockButton" class="btn btn-success mb-3">Fetch Goods Inward History</button>



    <div id="assigntable" class="card shadow mb-4 d-none">
        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">Stock Assignment History</h6>


        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Entry ID </th>
                            <th>Assosiate Name</th>
                            <th>Qty </th>
                            <th>Time </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>


    {{-- SupplierHistory --}}

    <div id="supptable" class="card shadow mb-4 d-none">
        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">Goods Inward History</h6>


        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="suppdataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Entry ID </th>
                            <th>Supplier Name</th>
                            <th>Qty </th>
                            <th>Time </th>
                            <th>Action </th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>



    <!-- Modal -->
<div class="modal fade" id="productHistoryModal" tabindex="-1" aria-labelledby="productHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="productHistoryModalLabel">Product History</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Quantity</th>
              </tr>
            </thead>
            <tbody id="productHistoryTableBody">
              <!-- Data will be populated here by JavaScript -->
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Close Modal</button>
        </div>
      </div>
    </div>
  </div>

    @include('logics/listtr')
@endsection
