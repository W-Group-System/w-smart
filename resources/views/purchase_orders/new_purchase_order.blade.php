<div class="modal fade" id="new">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new purchase order</h5>
            </div>
            <form method="POST" action="{{url('procurement/store_purchase_order')}}" onsubmit="show()">
                @csrf 
                {{-- <input type="hidden" name="purchase_order_no" value="{{$po_number}}"> --}}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Purchase Request</label>
                        <select data-placeholder="Select purchase request" name="purchase_request" class="form-control js-example-basic-single" style="width: 100%;" required>
                            <option value=""></option>
                            @foreach ($purchase_request as $pr)
                                <option value="{{$pr->id}}">{{str_pad($pr->id,6,'0',STR_PAD_LEFT)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Vendor Email</label>
                        <select data-placeholder="Select vendor" name="vendor" class="form-control js-example-basic-single" style="width:100%;" required>
                            <option value=""></option>
                            {{-- @foreach ($vendors as $vendor)
                                <option value="{{$vendor->id}}">{{$vendor->vendor->vendor_name}}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Expected Delivery Date</label>
                        <input type="date" name="expected_delivery_date" class="form-control form-control-sm" min="{{date('Y-m-d')}}" required>
                    </div>
                    <div id="rfqParent">
                        
                    </div>
                    <div class="form-group mt-3">
                        <div class="card border border-1 border-primary rounded-0">
                            <div class="card-header bg-primary rounded-0">
                                <p class="m-0 text-white font-weight-bold">Approver</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 border border-1 border-top-bottom border-left-right font-weight-bold">Level</div>
                                    <div class="col-lg-6 border border-1 border-top-bottom border-left-right font-weight-bold">Name</div>
                                </div>
                                @foreach ($purchase_approvers as $purchase_approver)
                                    <div class="row">
                                        <div class="col-lg-6 border border-1 border-top-bottom border-left-right">{{ $purchase_approver->level }}</div>
                                        <div class="col-lg-6 border border-1 border-top-bottom border-left-right">{{ $purchase_approver->user->name }}</div>
                                    </div>
                                @endforeach
                            </div>
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