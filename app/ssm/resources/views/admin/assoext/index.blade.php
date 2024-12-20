@extends('layouts.master')

@section('content')
   @include('links.datatables')


    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>
        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="add()" id="addnew">
            <i class="fa fa-user-plus" aria-hidden="true"></i>   Add New Associate </button>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">External Assosiacte</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>UID Type</th>
                            <th>UID</th>
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
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter name" required="" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="mobile" class="control-label">Mobile</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile"
                                        placeholder="Enter valid mobile" required="" maxlength="10"
                                        pattern="[6-9]{1}[0-9]{9}" title="Enter a valid 10-digit Indian mobile number">
                                </div>
                                <div class="col-sm-6">
                                    <label for="email" class="control-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Enter Email address" maxlength="50">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="address" name="address" placeholder="Enter Address" maxlength="255" rows="5"></textarea>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label id="uidgl" class="col-sm-2 control-label"> Type</label>
                                    <select class="form-control" id="uidtype" name="uidtype">
                                        <option value="">N/A</option>
                                        <option value="DL">DL</option>
                                        <option value="EPIC">EPIC</option>
                                        <option value="PAN">PAN</option>
                                        <option value="AADHAR">AADHAR</option>
                                        <option value="EPIC">EPIC</option>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label id="uidl"class="col-sm-2 control-label">UID</label>
                                    <input type="text" class="form-control" id="uid" name="uid"
                                        placeholder="Enter UID" maxlength="20">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-save">Add Assosiate
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end bootstrap model -->

    @include('logics/assoext')
@endsection
