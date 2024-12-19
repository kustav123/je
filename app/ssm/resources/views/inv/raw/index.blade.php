@extends('layouts.master')

@section('content')
   @include('links.datatables')


    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>
        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="add()">
            <i class="fa fa-cart-plus" aria-hidden="true"></i>  Add New Raw Products </button>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Raw Products</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Current Stock</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- boostrap blog model -->
    <div class="modal fade" id="addRawModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="RawModal"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="rawForm" class="form-horizontal">
                        <input type="hidden" name="purpose" id="purpose">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter name" required="" maxlength="50">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="unit">Unit</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="unit" name="unit" required="" title="Enter a valid unit type">
                                    <option value="" disabled selected>Select valid unit</option>
                                    <option value="KG">KG</option>
                                    <option value="Gram">Gram</option>
                                    <option value="ML">ML</option>
                                    <option value="Ltr">Ltr</option>
                                    <option value="Bag">Bag</option>
                                    <option value="Metric ton">Metric ton</option>
                                </select>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-sm-2 control-label">Remarks</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="remarks" name="remarks"
                                    placeholder="Enter Remarks " maxlength="100">
                            </div>
                        </div>


                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-save">Add Raw product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end bootstrap model -->

    @include('logics/rawproduct')
@endsection
