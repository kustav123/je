
<div class="row mt-3">

    <!-- Mobile Number Section - Textbox -->
    <div class="col-md-2">
        <label for="mobile_number">Mobile Number</label>
        <input type="text" class="form-control" id="mobile_number" name="mobile_number"
            placeholder="Enter  Number">
    </div>

    <!-- Name, Address, GST No, Email - Read-only Side by Side -->
    <div class="col-md-4">
        <label for="name">Name</label>
        <input type="text" class="form-control name-textfield" id="name" name="name"
            placeholder="Enter Pertial name for search" autocomplete="off">
        <div id="nameSuggestions"></div> <!-- Container for suggestions -->
    </div>

    <div class="col-md-3">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" maxlength="30">
    </div>
    <div class="col-md-3">
        <label for="gst_no">GST No</label>
        <input type="text" class="form-control" id="gst_no" name="gst_no" maxlength="15">
        <div id="gst-error" style="color: red; display: none;">Invalid GST number</div>
    </div>

</div>

<div class="row mt-3">


    <div class="col-md-2">
        <label for="due_amount">Due Amount</label>
        <input type="text" class="form-control" id="due_amount" name="due_amount" readonly placeholder="">
    </div>
    <div class="col-md-2">
        <label for="remarks">Remarks</label>
        <input type="text" class="form-control" id="remarks" name="remarks" readonly>
    </div>
    <div class="col-md-2">
        <label for="state">State</label>
        <input type="text" class="form-control" id="state" name="state" readonly>
    </div>
    <div class="col-md-6">
        <label for="address">Address</label>
        <textarea class="form-control" id="address" name="address" placeholder="Enter Address" maxlength="690" rows="2"></textarea>
    </div>
</div>


    <script>
        document.getElementById('gst_no').addEventListener('input', function() {
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




