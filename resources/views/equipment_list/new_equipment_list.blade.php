<div class="modal fade" id="new">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transfer Asset</h5>
            </div>
            <form method="POST" action="{{url('')}}">
                @csrf

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="requestedBy" class="form-label">Requested By</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="transferFromLocation" class="form-label">Transfer From Location</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="transferToLocation" class="form-label">Transfer To Location</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="transferFromName" class="form-label">Transfer From Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="transferToName" class="form-label">Transfer To Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="purpose" class="form-label">Purpose</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="dateOfTransfer" class="form-label">Date of Transfer</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="assetName" class="form-label">Asset Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="assetCode" class="form-label">Asset Code</label>
                            <input type="text" class="form-control" required>
                        </div>
                        {{-- <div class="col-md-6 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-primary" id="viewSpecsButton"
                                style="width: 100%;">View Specs</button>
                        </div> --}}
                        <div class="col-md-6">
                            <label for="approver" class="form-label">Approver</label>
                            <select class="form-control js-example-basic-single" style="width: 100%; position: relative;" required>
                                <option value="" disabled selected>Select Approver</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>