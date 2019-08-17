<div class="modal fade" id="addProgram" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Manage Program</h3>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group">
                        <input id="programId" type="hidden"/>
                        <label class="control-label">Program Name</label>
                        <input id="name" type="text" class="form-control" id="course_code" name="name" required>
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon">Duration</span>
                        <input id="duration" type="number" name="duration" class="form-control" value="60" required min="0">   
                        <span class="input-group-addon">Min.</span>                 
                    </div>
                    <div class="form-group col-md-12">
                        <label>Welcome Message for Students</label>
                        <textarea name="welcome" class="ckeditor" id="welcome" required></textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Exit Message for Students</label>
                        <textarea name="thanks" class="ckeditor" id="thanks" required></textarea>
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