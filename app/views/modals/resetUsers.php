<div class="modal fade" id="resetuser" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa fa-user"></i> Reset Password :<span id="nameToReset"><span></h3>
            </div>
            <form>
                <div class="modal-body col-md-12">
                    <input type="hidden" name="id" id="idReset" value="-1" />
                    <div class="form-group col-md-6">
                        <label>New Password*</label>
                        <input type="password" class="form-control" name="pass" id="pass"
                            placeholder="New Password" required />
                        <span class="help-inline"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Confirm Password*</label>
                        <input type="password" class="form-control" name="confirmPass" id="confirmPass"
                            placeholder="Confirm Password" required />
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="resetUserBtn" class="btn btn-primary"> Reset Password</a>
                    <button type="reset" class="btn btn-warning">Clear</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
            </form>
        </div>
    </div>
</div>
</div>