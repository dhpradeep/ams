<div class="modal fade" id="addSection" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Manage Section</h3>
            </div>
            <div class="modal-body col-md-12">
                <form role="form">
                    <input id="sid" type="hidden"/>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="name">Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="programId">Program *</label>
                        <select class="form-control" id="programId" name="programId">
                            <option data-no="-1" value="-1"> Please Select </option>
                            <?php
                                foreach ($this->program as $value) {
                            ?>
                                    <option data-no="<?= $value['noOfYearOrSemester'] ?>" value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                            <?php
                                 } 
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="yearOrSemester">Semester/Year *</label>
                        <select class="form-control" id="yearOrSemester" name="yearOrSemester">
                            <option value="-1">None</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label" for="details">Details</label>
                        <textarea name="details" class="form-control" id="details"></textarea>
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