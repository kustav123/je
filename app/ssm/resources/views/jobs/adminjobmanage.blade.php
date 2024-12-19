@extends('layouts.master')

@section('content')

   @include('links.datatables')


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Active Jobs</h6>
        </div>
        <input type="hidden" name="type" value="{{ $type }}" id="typeField">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap"  id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Job ID</th>
                            <th>Created Date</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Estimation</th>
                            <th>Assigned to</th> <!-- Add class for easy targeting -->
                            <th>Item</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Serial</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="jobDetailshisModal" tabindex="-1" role="dialog" aria-labelledby="jobDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobDetailsModalhisLabel">Job Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="jobDetailsBody" style="max-height: 500px;overflow: auto;">
                </div>
                <div class="modal-footer">
                    <div class="row w-100">
                        <div class="col-9">
                            <input type="text" class="form-control" id="comment" name="comment" placeholder="Add Comment">
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-primary btn-block" id="submitComment"><i class="fa fa-reply-all" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    {{-- <button type="button" class="btn btn-secondary mt-2 float-right" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></button> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="chaDetailshisModal" tabindex="-1" role="dialog" aria-labelledby="jobDetailsModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="jobDetailsModalLabel">Job Details</h5>
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="jobDetailsBody" style="max-height: 500px;overflow: auto;">
                    </div>
                    <div class="modal-footer">
                        <div class="row w-100">
                            <div class="col-9">
                                <input type="text" class="form-control" id="comment" name="comment" placeholder="Add Comment">
                            </div>
                            <div class="col-3">
                                <button type="button" class="btn btn-primary btn-block" id="submitComment"><i class="fa fa-reply-all" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="updateJobModal" tabindex="-1" role="dialog" aria-labelledby="updateJobModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateJobModalLabel">Update Job Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="updateJobForm">
                        <div class="modal-body" >
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="Pending approval">Pending approval</option>
                                    <option value="Assign">Assign Job</option>
                                    <option value="Ready for delivery">Ready for delivery</option>
                                    <option value="Hold">Hold</option>
                                    <option value="Pending item">Pending item</option>
                                    <option value="Delivered">Delivered</option>
                                </select>
                            </div>

                            <div class="form-group" id="assignStaffGroup" style="display: none;">
                                <label for="assigned_to">Assigned To</label>
                                <select class="form-control" id="assigned_to" name="assigned_to">
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                            <div class="form-group" id="jobcomment">
                                <label for="comment">Comment</label>
                                <textarea class="form-control" id="comment" name="comment" placeholder="Enter your comment" maxlength="300" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> </button>
                            <button type="submit" class="btn btn-primary" id="submitUpdate"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                            </button>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    @include('layouts.jobcard')
    @include('logics.listjobadmin')

@endsection


