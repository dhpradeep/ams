<div class="modal fade" id="addReview" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa fa-user"></i> Student Review : <span id="nameOfStudent"></span></h3>
            </div>
            <form>
                <div class="modal-body col-md-12">
                    <input type="hidden" name="sid" id="sid" value="-1" />
                    <input type="hidden" name="tid" id="tid" value="-1" />
                    <div class="form-group col-md-12">
                        <label>Review</label>
                        <input type="text" class="form-control" name="review" id="review"
                            placeholder="Review to the Student" required />
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="sendReviewBtn" class="btn btn-primary">Send</a>
                    <button type="reset" class="btn btn-warning">Clear</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
            </form>
        </div>
    </div>
</div>