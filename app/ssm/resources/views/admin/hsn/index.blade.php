@extends('layouts.master')

@section('content')
   @include('links.datatables');

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>
        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="add()">
            <i class="fa fa-list" aria-hidden="true"></i> Add New HSN</button>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">HSN Database</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>CGST</th>
                            <th>SGST</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- boostrap blog model -->
    <div class="modal fade" id="addStaffModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staffModal"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="staffForm" class="form-horizontal">
                        <input type="hidden" name="purpose" id="purpose">
                            <div class="form-group">
                                <label for="id" class="col-sm-2 control-label">HSN No.</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="id" name="id"
                                        placeholder="Enter HSN Number"  maxlength="6">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="make" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter item name " required="" maxlength="50">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cgst" class="col-sm-2 control-label">CGST</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="cgst" name="cgst"
                                        placeholder="Enter CGST (only number) " required="" maxlength="2">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sgst" class="col-sm-2 control-label">SGST</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="sgst" name="sgst"
                                        placeholder="Enter SGST (only number) " required="" maxlength="2">
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary" id="btn-save">Add Item</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end bootstrap model -->

    @include('logics/hsn')
@endsection

