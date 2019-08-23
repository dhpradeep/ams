<div class="modal fade" id="addSubject" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Manage Subject</h3>
            </div>
            <div class="modal-body col-md-12">
                <form role="form">
                    <div class="form-group col-md-6">
                        <label class="control-label" for="name">Subject Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="programId">Program *</label>
                        <select class="form-control" id="programId" name="programId" required>
                            <option value="1" name="diploma">Diploma in Hotel Management</option>
                            <option value="2" name="pcl">PCL</option>
                            <option value="3" name="tsl">TSL</option>
                        </select>
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="userId">Assign Teacher *</label>
                        <select class="form-control" id="userId" name="userId" multiple required>
                            <?php
                                foreach ($this->teachers as $value) {
                            ?>
                                    <option data-id="<?= $value['userId'] ?>" value="<?= $value['userId'] ?>"><?= $value['name'] ?></option>
                            <?php
                                 } 
                            ?>
                        </select>
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="section">Section</label>
                        <input type="text" class="form-control" id="section" name="section">
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label" for="details">Details</label>
                        <textarea name="details" class="form-control" id="details" rows="3"></textarea>
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