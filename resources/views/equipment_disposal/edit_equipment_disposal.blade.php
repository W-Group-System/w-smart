<div class="modal fade" id="editDisposalAsset{{ $disposal_asset->id }}" tabindex="-1" aria-labelledby="addDisposalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDisposalModalLabel">Edit Disposal of Asset</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <form action="{{ url('update_disposal_asset/'.$disposal_asset->id) }}" method="POST" onsubmit="show()" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        {{-- <div class="col-md-6">
                            <label for="requestedBy" class="form-label">Requested By</label>
                            <input type="text" class="form-control" name="requestedBy" required>
                        </div> --}}
                        <div class="col-md-6">
                            <label for="transferFrom" class="form-label">Transfer From</label>
                            <input type="text" class="form-control" name="transfer_from" value="{{ $disposal_asset->transfer_from }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="transferTo" class="form-label">Transfer To</label>
                            <input type="text" class="form-control" name="transfer_to" value="{{ $disposal_asset->transfer_to }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="purpose" class="form-label">Purpose</label>
                            <input type="text" class="form-control" name="purpose" value="{{ $disposal_asset->purpose }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="dateOfTransfer" class="form-label">Date of Transfer</label>
                            <input type="date" class="form-control" name="date_of_transfer" value="{{ $disposal_asset->date_of_transfer }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="assetName" class="form-label">Asset Name</label>
                            <input type="text" class="form-control" name="asset_name" value="{{ $disposal_asset->asset_name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="assetCode" class="form-label">Asset Code</label>
                            <input type="text" class="form-control" name="asset_code" value="{{ $disposal_asset->asset_code }}" required>
                        </div>
                        {{-- <div class="col-md-6 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-primary" name="viewSpecsButton"
                                style="width: 100%;">View Specs</button>
                        </div> --}}
                        <div class="col-md-6">
                            <label for="approver" class="form-label">Approver</label>
                            <select class="form-control js-example-basic-single" style="width: 100%;" name="approver">
                                <option value="" disabled selected>Select Approver</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks</label>
                            <input type="text" class="form-control" name="remarks" value="{{ $disposal_asset->remarks }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" name="files[]" multiple >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>