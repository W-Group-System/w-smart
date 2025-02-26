<div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInventoryModalLabel">New Inventory</h5>
            </div>
            <div class="modal-body">
                <form action="{{url('store_inventory')}}" method="POST" onsubmit="show()">
                    @csrf
                    <div class="row g-3">
                        {{-- <div class="col-md-6">
                            <label for="dateCreated" class="form-label">Date Created</label>
                            <input type="text" class="form-control" id="dateCreated" value="Auto Generate" readonly style="height: 50%;">
                        </div> --}}
                        <div class="col-md-6">
                            <label for="newItemCode" class="form-label">Item Code</label>
                            <input type="text" name="item_code" class="form-control" id="newItemCode" value="Auto-Generated" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="newItemDescription" class="form-label" >Item Description</label>
                            <input type="text" name="item_description" class="form-control" id="newItemDescription" required>
                        </div>
                        <div class="col-md-6">
                            <label for="newSubsidiary" class="form-label">Subsidiary</label>
                            <select class="form-control js-example-basic-single" style="width: 100%;" name="subsidiary" required>
                                <option selected value="1">HO</option>
                                <option value="2">WTCC</option>
                                <option value="3">CITI</option>
                                <option value="4">WCC</option>
                                <option value="5">WFA</option>
                                <option value="6">WOI</option>
                                <option value="7">WGC</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="newCategory" class="form-label">Category</label>
                            <div class="input-group">
                                <select class="form-control js-example-basic-single" style="width: 100%;" name="category">
                                    <option value="" disabled selected>Select a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="subCategory" class="form-label">Sub-Category</label>
                            <div class="input-group">
                                <select class="form-control js-example-basic-single" style="width: 100%;" name="sub_category">
                                    <option value="" disabled selected>Select a sub-category</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="newPrimaryUOM" class="form-label">Primary UOM</label>
                            <!-- <input type="text" id="primaryUOMSearch" placeholder="Search Primary UOM" class="form-control"> -->
                            <select data-placeholder="Select Primary UOM" class="form-control js-example-basic-single" style="width: 100%;" name="primary_uom">
                                <option value=""></option>
                                @foreach ($uoms as $uom)
                                    <option value="{{$uom->id}}">{{$uom->uomp}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="newSecondaryUOM" class="form-label">Secondary UOM</label>
                            <!-- <input type="text" id="secondaryUOMSearch" placeholder="Search Secondary UOM" class="form-control"> -->
                            <select data-placeholder="Select Secondary UOM" class="form-control js-example-basic-single" style="width: 100%;" name="secondary_uom">
                                <option value=""></option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="newTertiaryUOM" class="form-label">Tertiary UOM</label>
                            <!-- <input type="text" id="tertiaryUOMSearch" placeholder="Search Tertiary UOM" class="form-control"> -->
                            <select data-placeholder="Select Tertiary UOM" class="form-control js-example-basic-single" style="width: 100%;" name="tertiary_uom">
                                <option value=""></option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="newCost" class="form-label" >Cost</label>
                            <input type="number" class="form-control" id="newCost" name="cost" required>
                        </div>

                        <div class="col-md-6">
                            <label for="newQuantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="newQuantity" name="quantity" required>
                        </div>
                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" rows="10" cols="30" name="remarks"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="newUsage" class="form-label">Usage</label>
                            <input type="number" class="form-control" id="newUsage" value=0 name="usage" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>