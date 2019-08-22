<div class="modal fade" id="addSection" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Manage Section</h3>
            </div>
            <div class="modal-body col-md-12">
                <form role="form">
                    <div class="form-group col-md-6">
                        <label class="control-label" for="name">Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="programId">Program *</label>
                        <select class="form-control" id="programId" name="programId">
                            <option value="1">BCA</option>
                            <option value="2">BBA</option>
                            <option value="3">BPH</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="semesterOrYear">Semester/Year *</label>
                        <select class="form-control" id="semesterOrYear" name="semesterOrYear">
                            <option value="1">1st</option>
                            <option value="2">2nd</option>
                            <option value="3">3rd</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="subjectId">Subject *</label>
                        <select class="form-control" id="subjectId" name="subjectId">
                            <option value="1">Data science</option>
                            <option value="2">Machine Learning</option>
                            <option value="3">Neural Network</option>
                        </select>
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