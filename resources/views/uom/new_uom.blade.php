<div class="modal fade" id="addUOMModal" aria-labelledby="addUOMModalLabel" aria-hidden="true"
        style="z-index: 1600;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUOMModalLabel">Add New UOM</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{url('store_uom')}}" onsubmit="show()">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="primaryUOM">Primary UOM</label>
                            <input type="text" class="form-control" name="primary_uom" id="primaryUOM" placeholder="Enter primary UOM name"
                                required>
                            <input type="number" name="primary_uom_value" class="form-control mt-2" id="primaryUOMValue"
                                placeholder="Enter primary UOM value" required step="any">
                        </div>

                        <div class="form-group mb-3">
                            <label for="secondaryUOM">Secondary UOM</label>
                            <input type="text" class="form-control" id="secondaryUOM"
                                placeholder="Enter secondary UOM name" required>
                            <input type="number" class="form-control mt-2" id="secondaryUOMValue"
                                placeholder="Enter secondary UOM value" required step="any">
                        </div>

                        <div class="form-group mb-3">
                            <label for="tertiaryUOM">Tertiary UOM (Optional)</label>
                            <input type="text" class="form-control" id="tertiaryUOM"
                                placeholder="Enter tertiary UOM name">
                            <input type="number" class="form-control mt-2" id="tertiaryUOMValue"
                                placeholder="Enter tertiary UOM value" step="any">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save UOM</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>