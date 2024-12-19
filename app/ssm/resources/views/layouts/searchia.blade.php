<div class="row mt-3">

    <!-- Mobile Number Section - Textbox -->
    <div class="col-md-4">
        <label for="mobile_number">Mobile Number</label>
        <input type="text" class="form-control" id="mobile_number" name="mobile_number"
            placeholder="Enter Mobile Number" required>
    </div>

    <!-- Name, Address, GST No, Email - Read-only Side by Side -->
    <div class="col-md-4">
        <label for="name">Name</label>
        <input type="text" class="form-control name-textfield" id="name" name="name"
            placeholder="Enter Pertial name for search" autocomplete="off">
        <div id="nameSuggestions"></div> <!-- Container for suggestions -->

    </div>
    <div class="col-md-4">
        <label for="address">Address</label>
        <input type="text" class="form-control" id="address" name="address" readonly>
    </div>
</div>



