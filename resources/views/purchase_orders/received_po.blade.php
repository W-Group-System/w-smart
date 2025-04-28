<div class="modal fade" id="received{{$po->id}}">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Received PO</h5>
            </div>
            <form method="POST" class="d-inline-block" action="{{url('received_po/'.$po->id)}}" onsubmit="show()">
                @csrf 
                
                {{-- <input type="hidden" name="grn_no" value="{{$latest_grn->tranid}}">
                <input type="hidden" name="po_number" value="{{$po_data->tranid}}">
                <input type="hidden" name="po_id" value="{{$po_data->id}}"> --}}

                <div class="modal-body py-3">
                    Primary Information
                    <hr>

                    <div class="row mb-2">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <p class="m-0">Reference #</p>
                                    To Be Generated
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <p class="m-0">Vendor</p>
                                    {{$po->supplier->corporate_name}}
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <p class="m-0">Created From</p>
                                    Purchase Order {{$po->purchase_order_no}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <p class="m-0">Date</p>
                                    {{date('m/d/Y')}}
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <p class="m-0">Posting Period</p>
                                    {{date('M Y')}}
                                </div>
                            </div>
                        </div>
                    </div>

                    Classification
                    <hr>

                    <div class="row mb-2">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p class="m-0">Subsidiary</p>
                                    {{$po->purchaseRequest->subsidiary}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="receive_all">
                                            </th>
                                            <th>Item Code</th>
                                            <th>Item Description</th>
                                            <th>Remaining</th>
                                            <th>On Hand</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($po->purchaseOrderItem as $key => $item)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="receive_item[]" value="1" checked>
                                                    <input type="hidden" name="line[]" value="{{ $key+1 }}">
                                                    <input type="hidden" name="inventory_id[]" value="{{ $item->inventory_id }}">
                                                </td>
                                                <td>{{$item->inventory->item_code}}</td>
                                                <td>{{$item->inventory->item_description}}</td>
                                                <td>
                                                    <input type="hidden" name="actual_qty[]" value="{{ $item->inventory->qty }}">
                                                    {{ $item->inventory->qty }}
                                                </td>
                                                <td>
                                                    {{ (int)$item->inventory->qty - (int)$item->qty }}
                                                </td>
                                                <td>
                                                    @if($item->qty)
                                                    <input type="number" class="form-control form-control-sm" name="received_qty[]" max="{{ $item->inventory->qty }}" value="{{ $item->qty }}" required>
                                                    @else
                                                    <input type="number" class="form-control form-control-sm" name="received_qty[]" max="{{ $item->inventory->qty }}" value="{{ $item->inventory->qty }}" required>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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