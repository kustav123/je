
<div class="row mt-3">

    <!-- Mobile Number Section - Textbox -->
    <div class="col-md-4">
        <label for="mobile_number">Mobile Number</label>
        <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="Enter Mobile Number">
    </div>

    <!-- Name, Address, GST No, Email - Read-only Side by Side -->
    <div class="col-md-4">
        <label for="name">Name</label>
        <input type="text" class="form-control name-textfield" id="name" name="name" placeholder="Enter Pertial name for search" autocomplete="off">
        <div id="nameSuggestions"></div> <!-- Container for suggestions -->

    </div>
    <div class="col-md-4">
        <label for="address">Address</label>
        <input type="text" class="form-control" id="address" name="address" readonly>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-4">
        <label for="gst_no">GST No</label>
        <input type="text" class="form-control" id="gst_no" name="gst_no" readonly>
    </div>
    <div class="col-md-4">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" readonly>
    </div>
    <div class="col-md-4">
        <label for="due_amount">Due Amount</label>
        <input type="text" class="form-control" id="due_amount" name="due_amount" readonly placeholder="">
    </div>
</div>

<div class="row mt-3 justify-content-center">
    <div class="col-md-4 text-center">
        <label for="remarks">Remarks</label>
        <input type="text" class="form-control" id="remarks" name="remarks" readonly>
    </div>
</div>
