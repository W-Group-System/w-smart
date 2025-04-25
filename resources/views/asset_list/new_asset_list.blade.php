<div class="modal fade" id="addAssetModal" tabindex="-1" aria-labelledby="addAssetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAssetModalLabel">Add New Asset</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <form action="{{url('store_asset_list')}}" method="POST" enctype="multipart/form-data" onsubmit="show()">
                <div class="modal-body">
                    @csrf
                    <div class="row g-3">
                        <!-- Date Fields -->
                        <div class="col-md-6">
                            <label for="datePurchased" class="form-label">Date Purchased <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="datePurchased" name="date_purchased" required>
                        </div>
                        <div class="col-md-6">
                            <label for="dateInstallation" class="form-label">Date Installation <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="dateInstallation" name="date_installation" required>
                        </div>
                        <div class="col-md-6">
                            <label for="dateAcquired" class="form-label">Date Acquired <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="dateAcquired" name="date_acquired" required>
                        </div>
                        <div class="col-md-6">
                            <label for="dateTransferred" class="form-label">Date Transferred <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="dateTransferred" name="date_transferred" required>
                        </div>
                        <div class="col-md-6">
                            <label for="dateRepaired" class="form-label">Date Repaired <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="dateRepaired" name="date_repaired" required>
                        </div>

                        <!-- General Asset Information -->
                        <div class="col-md-6">
                            <label for="assetCode" class="form-label">Asset Code & Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="assetCode" name="asset_code">
                        </div>
                        {{-- <div class="col-md-6">
                            <label for="assetName" class="form-label">Asset Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="assetName" name="asset_name" required>
                        </div> --}}
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-control js-example-basic-single" style="width:100%;" name="category" required>
                                <option value="" disabled selected>Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="subsidiary" class="form-label">Subsidiary <span class="text-danger">*</span></label>
                            <select class="form-control js-example-basic-single" style="width: 100%;" name="subsidiary" required>
                                <option value="" disabled selected>Select a subsidiary</option>
                                @foreach ($subsidiaries as $subsidiary)
                                    <option value="{{$subsidiary->subsidiary_id}}">{{$subsidiary->subsidiary_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="col-md-6">
                            <label for="estimatedUsefulLife" class="form-label">Estimated Useful Life <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="estimatedUsefulLife"
                                name="estimated_useful_life" required>
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-control js-example-basic-single" style="width: 100%;" id="type" name="type" required>
                                <option value="" disabled selected>Select a type</option>
                                <option value="Capitalized">Capitalized</option>
                                <option value="Non-Capitalized">Non-Capitalized</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-control js-example-basic-single" style="width: 100%;" name="status" required>
                                <option value="" disabled selected>Select status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive (Repair)">Inactive (Repair)</option>
                                <option value="Disposed">Disposed</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="remarks" name="remarks" required>
                        </div>
                        <div class="col-md-6">
                            <label for="assignedTo" class="form-label">Assigned To <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="assignedTo" name="assigned_to" required>
                        </div>

                        <!-- Additional Details -->
                        <div class="col-md-6">
                            <label for="serialNumber" class="form-label">Serial Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="serialNumber" name="serial_number" required>
                        </div>
                        <div class="col-md-6">
                            <label for="equipmentModel" class="form-label">Equipment Model <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="equipmentModel" name="equipment_model" required>
                        </div>
                        <div class="col-md-6">
                            <label for="warranty" class="form-label">Warranty (Months) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="warranty" name="warranty" required>
                        </div>
                        <div class="col-md-6">
                            <label for="poNumber" class="form-label">PO Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="poNumber" name="po_number" required>
                        </div>
                        <div class="col-md-6">
                            <label for="brand" class="form-label">Brand <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="brand" name="brand" required>
                        </div>
                        <div class="col-md-6">
                            <label for="specifications" class="form-label">Specifications <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="specifications" name="specifications" required>
                        </div>
                        <div class="col-md-6">
                            <label for="photo" class="form-label">Photo <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="photo" name="photo" required>
                        </div>
                        <div class="col-md-6">
                            <label for="assetValue" class="form-label">Asset Value <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="assetValue" name="asset_value" value="0" required>
                        </div>
                        <div class="col-md-6">
                            <label for="itemCode" class="form-label">Item Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="itemCode" name="item_code" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="saveAssetButton">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>