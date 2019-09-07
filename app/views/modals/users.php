<div class="modal fade" id="adduser" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa fa-user"></i> Manage User</h3>
            </div>
            <form>
                <div class="modal-body col-md-12">
                    <input type="hidden" name="id" id="id"/>
                    <div class="form-group col-md-6">
                        <label>First Name*</label>
                        <input type="text" class="form-control" name="fname" id="fname" placeholder="Firstname" required/>
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" name="mname" id="mname" placeholder="Middlename" />
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Last Name*</label>
                        <input type="text" class="form-control" name="lname" id="lname" placeholder="Lastname" required/>
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email Address*</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required/>
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Phone no*</label>
                        <input type="text" class="form-control" name="mobileNo" id="mobileNo" placeholder="Phone Number" required/>
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Username*</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" required/>
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Password*</label>
                        <input type="password" class="form-control" name="passwordHash" id="passwordHash"
                            placeholder="Password" required />
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Confirm Password*</label>
                        <input type="password" class="form-control" name="cpasswordHash" id="cpasswordHash"
                            placeholder="Confirm Password" required />
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Role*</label>
                        <select class="form-control" id="role" name="role">
                            <option value="Admin">Admin</option>
                            <option value="Teacher">Teacher</option>
                        </select>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="saveBtn" class="btn btn-primary"> Save</a>
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button class="btn btn-default" data-dismiss="modal">Close</button>
            </form>
        </div>
    </div>
</div>
</div>