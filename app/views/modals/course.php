
<div class="modal fade" id="addCourse" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Manage Course</h3>
            </div>
            <div class="modal-body">
            <form role="form">
                    <div class="form-group" style="font-size:16px;">
                        <input id="CourseId" type="hidden"/>
                        <label class="control-label text-primary">Course Name</label>
                        <input id="coursename" type="text" class="form-control" id="course_code" name="coursename" placeholder="Course Name" required>
                        <!-- <span class="help-inline"></span> -->
                    </div>
                    <div class="form-group" style="margin-top:20px; font-size:16px;">
                        <label class="text-primary">Course Type</label>
                        <select name="coursetype" id="coursetype" class="form-control">
                            <option value="semester">Semester</option>
                            <option value="year">Year</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-top:20px; font-size:16px;">
                        <label class="text-primary">Course Details</label>
                        <textarea name="welcome" class="ckeditor" id="welcome" required></textarea>
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