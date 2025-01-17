<div class="modal fade" id="new">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new purchase order</h5>
            </div>
            <form method="POST" action="{{url('procurement/store_purchase_order')}}">
                @csrf 
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Purchase Request</label>
                        <select data-placeholder="Select purchase request" name="purchase_request" class="form-select chosen-select" required>
                            <option value=""></option>
                            @foreach ($purchase_request as $pr)
                                <option value="{{$pr->id}}">{{str_pad($pr->id,6,'0',STR_PAD_LEFT)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Vendor Email</label>
                        <select data-placeholder="Select vendor" name="vendor" class="form-select chosen-select" required>
                            <option value=""></option>
                            @foreach ($vendors as $vendor)
                                <option value="{{$vendor->id}}">{{$vendor->vendor->vendor_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>