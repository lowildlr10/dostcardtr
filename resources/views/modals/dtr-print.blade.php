<div id="modal-dtr-print" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content border border-dark">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <i class="fas fa-print"></i> Printing Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="biometics-id">Biometrics ID</label>
                        <input type="text" class="form-control" id="biometics-id"
                            aria-describedby="bio-help" placeholder="Loading..." readonly>
                        <small id="bio-help" class="form-text text-muted">
                            This linked to your biometrics central server.
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="dtr-drange">
                            Select Date Range
                            <span id="drange-textual" class="text-primary"></span>
                        </label>
                        <input type="text" id="dtr-drange" class="form-control"
                               placeholder="Click this field.">
                        <small id="bio-help" class="form-text text-danger">
                            The date range should be within the month only.
                        </small>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="$(this).printDTR();">
                    <i class="fas fa-print"></i> Print
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="far fa-times-circle"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
