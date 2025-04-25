<div class="modal fade" id="edit{{$transfer_asset->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Transfer Asset</h5>
            </div>
            <form method="POST" action="{{url('update_transfer_asset/'.$transfer_asset->id)}}" onsubmit="show()" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="row g-3">
                        {{-- <div class="col-md-6">
                            <label for="requestedBy" class="form-label">Requested By</label>
                            <input type="text" class="form-control" required>
                        </div> --}}
                        <div class="col-md-6">
                            <label for="transferFromLocation" class="form-label">Transfer From Location <span class="text-danger">*</span></label>
                            <input type="text" name="transfer_from" class="form-control" value="{{$transfer_asset->transfer_from}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="transferToLocation" class="form-label">Transfer To Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="transfer_to" value="{{$transfer_asset->transfer_to}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="transferFromName" class="form-label">Transfer From Name <span class="text-danger">*</span></label>
                            <input type="text" name="transfer_from_name" class="form-control" value="{{$transfer_asset->transfer_from_name}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="transferToName" class="form-label">Transfer To Name <span class="text-danger">*</span></label>
                            <input type="text" name="transfer_to_name" class="form-control" value="{{$transfer_asset->transfer_to_name}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="purpose" class="form-label">Purpose <span class="text-danger">*</span></label>
                            <input type="text" name="purpose" class="form-control" value="{{$transfer_asset->purpose}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="dateOfTransfer" class="form-label">Date of Transfer <span class="text-danger">*</span></label>
                            <input type="date" name="date_of_transfer" class="form-control" value="{{$transfer_asset->date_of_transfer}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="assetName" class="form-label">Asset Name <span class="text-danger">*</span></label>
                            <input type="text" name="asset_name" class="form-control" value="{{$transfer_asset->asset_name}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="assetCode" class="form-label">Asset Code <span class="text-danger">*</span></label>
                            <input type="text" name="asset_code" class="form-control" value="{{$transfer_asset->asset_code}}" required>
                        </div>
                        {{-- <div class="col-md-6 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-primary" id="viewSpecsButton"
                                style="width: 100%;">View Specs</button>
                        </div> --}}
                        <div class="col-md-6">
                            <label for="approver" class="form-label">Approver <span class="text-danger">*</span></label>
                            <select class="form-control js-example-basic-single" style="width: 100%; position: relative;" >
                                <option value="" disabled selected>Select Approver</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks <span class="text-danger">*</span></label>
                            <input type="text" name="remarks" class="form-control" value="{{$transfer_asset->remarks}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="photo" class="form-label">Photo <span class="text-danger">*</span></label>
                            <input type="file" name="files[]" class="form-control" multiple >
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