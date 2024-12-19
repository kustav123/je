@extends('layouts.master')

@section('content')
   @include('links.datatables')


    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>
        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="add()">
            <i class="fa fa-users" aria-hidden="true"></i>   Add New Supplier </button>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Supplier</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>GST No</th>
                            <th>Payable Ammount</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- boostrap blog model -->
    <div class="modal fade" id="addSuppModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="SuppModal"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="suppForm" class="form-horizontal">
                        <input type="hidden" name="purpose" id="purpose">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter name" required="" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mobile</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="mobile" name="mobile"
                                    placeholder="Enter valid mobile" required="" maxlength="10" pattern="[6-9]{1}[0-9]{9}" title="Enter a valid 10-digit Indian mobile number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter Email address" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Enter Address" maxlength="40">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">GST No</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="gst" name="gst" placeholder="Enter GST No." maxlength="15">
                                <div id="gst-error" style="color: red; display: none;">Invalid GST number</div>
                            </div>
                        </div>

                        <script>
                            document.getElementById('gst').addEventListener('input', function() {
                                var gstInput = this.value;
                                var gstPattern = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
                                var gstError = document.getElementById('gst-error');

                                if (gstInput === '' || gstPattern.test(gstInput)) {
                                    gstError.style.display = 'none';
                                } else {
                                    gstError.style.display = 'block';
                                }
                            });
                        </script>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Remarks</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="remarks" name="remarks"
                                    placeholder="Enter Remarks " maxlength="100">
                            </div>
                        </div>


                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-save">Add Client
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end bootstrap model -->

    @include('logics/supplier')
@endsection
