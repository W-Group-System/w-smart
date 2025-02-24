<div class="modal fade" id="requestTransferModal" tabindex="-1" aria-labelledby="requestTransferModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestTransferModalLabel">Inventory Transfer</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <form id="requestTransferForm">
                <div class="modal-body">
                    <!-- Transaction Information -->
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label for="transactionDate" class="form-label">Transaction Date</label>
                            <input type="text" class="form-control form-control-sm" id="transactionDate" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="transactionNumber" class="form-label">Transaction Number</label>
                            <input type="text" class="form-control form-control-sm" id="transactionNumber" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="transferFrom" class="form-label">Transfer From</label>
                            <select class="form-control js-example-basic-single" style="width: 100%;" id="transferFrom">
                                @if(auth()->user()->subsidiary != 'HO')
                                    <option value="1">HO</option>
                                @endif
                                @if(auth()->user()->subsidiary != 'WTCC')
                                    <option value="2">WTCC</option>
                                @endif
                                @if(auth()->user()->subsidiary != 'CITI')
                                    <option value="3">CITI</option>
                                @endif
                                @if(auth()->user()->subsidiary != 'WCC')
                                    <option value="4">WCC</option>
                                @endif
                                @if(auth()->user()->subsidiary != 'WFA')
                                    <option value="5">WFA</option>
                                @endif
                                @if(auth()->user()->subsidiary != 'WOI')
                                    <option value="6">WOI</option>
                                @endif
                                @if(auth()->user()->subsidiary != 'WGC')
                                    <option value="7">WGC</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="transferTo" class="form-label">Transfer To</label>
                            <select class="form-control js-example-basic-single" style="width: 100%;" id="transferTo" disabled>
                                <option value="1" {{ auth()->user()->subsidiary == 'HO' ? 'selected' : '' }}>HO</option>
                                <option value="2" {{ auth()->user()->subsidiary == 'WTCC' ? 'selected' : '' }}>WTCC
                                </option>
                                <option value="3" {{ auth()->user()->subsidiary == 'CITI' ? 'selected' : '' }}>CITI
                                </option>
                                <option value="4" {{ auth()->user()->subsidiary == 'WCC' ? 'selected' : '' }}>WCC</option>
                                <option value="5" {{ auth()->user()->subsidiary == 'WFA' ? 'selected' : '' }}>WFA</option>
                                <option value="6" {{ auth()->user()->subsidiary == 'WOI' ? 'selected' : '' }}>WOI</option>
                                <option value="7" {{ auth()->user()->subsidiary == 'WGC' ? 'selected' : '' }}>WGC</option>
                            </select>
                        </div>
                    </div>

                    <!-- Item Information Table -->
                    <div class="table-responsive mb-3">
                        <button type="button" class="btn btn-success btn-sm" id="addMoreItems">
                            <i class="ti-plus"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" id="addMoreItems">
                            <i class="ti-minus"></i>
                        </button>

                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Item Description</th>
                                    <th>Category</th>
                                    <th>UOM</th>
                                    <th>Requested QTY</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td contenteditable="false">
                                        <div style="position: relative;">
                                            <input type="text" id="itemCodeInput" list="itemSuggestions"
                                                class="form-control form-control-sm" placeholder="Enter Item Code"
                                                style="width: 100%; max-width: 200px; padding: 6px; border-radius: 5px; border: 1px solid #ced4da;">
                                            <datalist id="itemSuggestions"></datalist>
                                        </div>
                                    </td>
                                    <td contenteditable="false" id="itemDescription"
                                        style="background-color: #E9ECEF; color: #999; pointer-events: none;"></td>
                                    <td contenteditable="false" id="itemCategory"
                                        style="background-color: #E9ECEF; color: #999; pointer-events: none;"></td>
                                    <td>
                                        <select data-placeholder="Select uom" class="form-control js-example-basic-single" style="width: 100%;">
                                            <option value=""></option>
                                        </select>
                                    </td>
                                    <td contenteditable="true" class="qty"
                                        style="background-color: #FFFFFF; color: #000; pointer-events: auto;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control form-control-sm" id="remarks"></textarea>
                    </div>

                    <!-- Approver Section -->
                    <div class="table-responsive mb-3">
                        <button type="button" class="btn btn-sm btn-success" id="addMoreApprover">
                            <i class="ti-plus"></i>
                        </button>

                        <table class="table table-bordered table-sm" id="approversTable">
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
                        </table>
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