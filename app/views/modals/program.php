<div class="modal fade" id="addProgram" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Manage Program</h3>
            </div>
            <div class="modal-body col-md-12">
                <form role="form">
                    <div class="form-group col-md-6">
                        <label class="control-label" for="programId">Program ID *</label>
                        <input type="text" class="form-control" id="programId" name="programId" required>
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="name">Program Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-6">
                            <input type="radio" name="yearOrSemester"> Year
                        </div>
                        <div class="col-sm-6">
                            <input type="radio" name="yearOrSemester"> Semester
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="control-label" for="noOfYearOrSemester"> No of Year/Semester *</label>
                        <input type="text" class="form-control" id="noOfYearOrSemester" name="noOfYearOrSemester" required>
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label" for="details">Details</label>
                        <textarea name="details" class="form-control" id="details" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="saveBtn">Add</button>
                <!--<button type="reset" class="btn btn-warning">Reset</button>-->
                <button class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>