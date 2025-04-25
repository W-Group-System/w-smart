<div class="modal fade" id="requestTransferModal" tabindex="-1" aria-labelledby="requestTransferModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestTransferModalLabel">Inventory Transfer</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <form action="{{url('store_inventory_transfer')}}" method="POST" onsubmit="show()">
                @csrf 

                <div class="modal-body">
                    <!-- Transaction Information -->
                    <div class="row g-2 mb-3">
                        {{-- <div class="col-md-6">
                            <label for="transactionDate" class="form-label">Transaction Date</label>
                            <input type="text" class="form-control form-control-sm" id="transactionDate" readonly>
                        </div> --}}
                        {{-- <div class="col-md-6">
                            <label for="transactionNumber" class="form-label">Transaction Number</label>
                            <input type="text" class="form-control form-control-sm" id="transactionNumber" readonly>
                        </div> --}}
                        <div class="col-md-6">
                            <label for="transferFrom" class="form-label">Transfer From</label>
                            <select data-placeholder="Select subsidiary" class="form-control js-example-basic-single" name="transfer_from" style="width: 100%;">
                                <option value=""></option>
                                @foreach ($subsidiaries->where('subsidiary_id', "!=", auth()->user()->subsidiaryid) as $subsidiary)
                                    <option value="{{ $subsidiary->subsidiary_id }}">{{ $subsidiary->subsidiary_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="transferTo" class="form-label">Transfer To</label>
                            <select class="form-control js-example-basic-single" style="width: 100%;" name="transfer_to">
                                @foreach ($subsidiaries->where('subsidiary_id', auth()->user()->subsidiaryid) as $subsidiary)
                                    <option value="{{$subsidiary->subsidiary_id}}">{{$subsidiary->subsidiary_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Item Information Table -->
                    <div class="table-responsive mb-3">
                        <button type="button" class="btn btn-success btn-sm mb-2" id="addMoreItems">
                            <i class="ti-plus"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm mb-2" id="removeItems">
                            <i class="ti-minus"></i>
                        </button>

                        <table class="table table-bordered table-sm" id="inventoryTable">
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Item Description</th>
                                    <th>Category</th>
                                    <th>UOM</th>
                                    <th>Quantity</th>
                                    {{-- <th>Requested QTY</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select data-placeholder="Select item code" name="item_code[]" class="form-control js-example-basic-single" style="width: 100%;" required>
                                            {{-- <option value=""></option>
                                            @foreach ($inventories->where('status', null) as $inventory)
                                                <option value="{{$inventory->inventory_id}}">{{$inventory->item_code}}</option>
                                            @endforeach --}}
                                        </select>
                                    </td>
                                    <td class="itemDescriptionTd">
                                        <input type="hidden" name="item_description[]">
                                    </td>
                                    <td class="categoryTd">
                                        <input type="hidden" name="category[]">
                                    </td>
                                    <td>
                                        <select data-placeholder="Select item uoms" name="uom[]" class="form-control js-example-basic-single" style="width: 100%;" required>
                                            <option value=""></option>
                                            @foreach ($uoms as $uom)
                                                <option value="{{$uom->id}}">{{$uom->uomp}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="qty">
                                        
                                    </td>
                                    {{-- <td>
                                        <input type="number" name="request_qty" class="form-control" required>
                                    </td> --}}
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control form-control-sm" id="remarks" name="remarks"></textarea>
                    </div>

                    <!-- Approver Section -->
                    <div class="table-responsive mb-3">
                        {{-- <table class="table table-bordered table-sm" id="approversTable">
                            <thead>
                                <tr>
                                    <th>Approver Name</th>
                                    <th>Role</th>
                                    <th>Hierarchy</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <input type="hidden" id="userIdInput1">
                                    <td contenteditable="false" id="approver1" style="background-color: #E9ECEF; color: #999; pointer-events: none;">
                                        <div style="position: relative; display: none;">
                                            <input type="text" id="userSearchInput1" list="userSuggestions" class="form-control form-control-sm" placeholder="Enter User Name" style="width: 100%; max-width: 200px; padding: 6px; border-radius: 5px; border: 1px solid #ced4da;">
                                            <datalist id="userSuggestions"></datalist>
                                            
                                        </div>
                                    </td>
                                    <td contenteditable="false" id="userRoleInput1" style="background-color: #E9ECEF; color: #999; pointer-events: none;">Auto Generate</td>
                                    <td contenteditable="false" class="hierarchy-input" style="background-color: #E9ECEF; color: #999; pointer-events: none;">1</td>
                                    <td contenteditable="true"></td>
                                </tr>
                                <tr>
                                    <input type="hidden" id="userIdInput2">
                                    <td contenteditable="false" id="approver2" style="background-color: #E9ECEF; color: #999; pointer-events: none;">
                                        <div style="position: relative;">
                                            <input type="text" id="userSearchInput2" list="userSuggestions" class="form-control form-control-sm" placeholder="Enter User Name" style="width: 100%; max-width: 200px; padding: 6px; border-radius: 5px; border: 1px solid #ced4da;">
                                            <datalist id="userSuggestions"></datalist>
                                            
                                        </div>
                                    </td>
                                    <td contenteditable="false" id="userRoleInput2" style="background-color: #E9ECEF; color: #999; pointer-events: none;">Auto Generate</td>
                                    <td contenteditable="false" class="hierarchy-input" style="background-color: #E9ECEF; color: #999; pointer-events: none;">2</td>
                                    <td contenteditable="true"></td>
                                </tr>
                            </tbody>
                        </table> --}}
                        <div class="card border border-1 border-primary rounded-0">
                            <div class="card-header bg-primary rounded-0 text-white">
                                Approvers
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 border border-1 border-top-bottom border-left-right">
                                        <b>Hierarchy</b>
                                    </div>
                                    <div class="col-lg-4 border border-1 border-top-bottom border-left-right">
                                        <b>Name</b>
                                    </div>
                                    <div class="col-lg-4 border border-1 border-top-bottom border-left-right">
                                        <b>Role</b>
                                    </div>
                                </div>
                                @foreach ($subsidiaries->where('subsidiary_id', auth()->user()->subsidiaryid) as $subsidiary)
                                    @foreach ($subsidiary->approvers as $approver)
                                        <div class="row">
                                            <div class="col-lg-4 border border-1 border-top-bottom border-left-right">
                                                {{$approver->hierarchy}}
                                            </div>
                                            <div class="col-lg-4 border border-1 border-top-bottom border-left-right">
                                                {{$approver->name}}
                                            </div>
                                            <div class="col-lg-4 border border-1 border-top-bottom border-left-right">
                                                {{$approver->role}}
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- <input type="hidden" id="userIdInput">
                    <input type="hidden" id="userEmailInput">

                    <!-- Action Section -->
                    <div class="row g-2 align-items-end mb-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-success btn-lg" id="submitRequestTransfer"
                                style="background-color: #28a745; color: white; border: 1px solid #28a745; padding: 10px 20px;">
                                Submit
                            </button>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-success">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>