<div class="modal fade" id="inventoryWithdrawalModal" aria-labelledby="inventoryWithdrawalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inventoryWithdrawalModalLabel">Inventory Withdrawal</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="inventoryWithdrawalModalBtn"></button> --}}
            </div>
            <form id="inventoryWithdrawalForm">
                <div class="modal-body">
                    <!-- Transaction Information -->
                    <div class="row g-2 mb-3">
                        {{-- <div class="col-md-6">
                            <label for="requestedDateTime" class="form-label">Requested Date/Time</label>
                            <input type="text" class="form-control form-control-sm" id="withdrawalDate" value="Auto Generate" readonly>
                        </div> --}}
                        <div class="col-md-6">
                            <label for="requestNumber" class="form-label">Request Number</label>
                            <input type="text" class="form-control" id="requestNumber" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="requestorName" class="form-label">Custodian Name</label>
                            <input type="text" class="form-control" id="requestName" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="requestorName" class="form-label">Subsidiary</label>
                            <input type="text" class="form-control" id="subsidiary" value="HO" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="requestorName" class="form-label">Subsidiary</label>
                            <input type="text" class="form-control" id="subsidiaryid" value="HO" readonly>
                        </div>
                    </div>

                    <!-- Item Information Table -->

                    <div class="table-responsive mb-3">
                        <!-- Button to add a new row -->
                        <button type="button" class="btn btn-sm btn-success" id="addRowBtn">
                            <i class="ti-plus"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" id="addRowBtn">
                            <i class="ti-minus"></i>
                        </button>
                        <table class="table table-bordered table-sm" id="itemsTable">
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Item Description</th>
                                    <th>Category</th>
                                    <th>UOM</th>
                                    <th>Reason of Withdrawal</th>
                                    <th>Requested QTY</th>
                                </tr>
                            </thead>
                            <tbody id="itemTableBody">
                                <tr>
                                    <div style="position: relative;">
                                    <td contenteditable="false">
                                        <div style="position: relative;">
                                            <input type="text" class="form-control form-control-sm itemCodeInput" placeholder="Enter Item Code" style="width: 100%; max-width: 200px; padding: 6px; border-radius: 5px; border: 1px solid #ced4da;" list="itemSuggestions">
                                            <datalist id="itemSuggestions"></datalist>
                                        </div>
                                    </td>
                                    <td contenteditable="false" class="itemDescription" style="background-color: #E9ECEF; color: #999; pointer-events: none;"></td>
                                    <td contenteditable="false" class="itemCategory" style="background-color: #E9ECEF; color: #999; pointer-events: none;"></td>
                                    <td>
                                        <select data-placeholder="Select uom" class="form-control js-example-basic-single" style="width: 100%;" required>
                                            <option value=""></option>
                                        </select>
                                    </td>
                                    <td contenteditable="true" class="reason"></td>
                                    <td contenteditable="true" class="requestedQty"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                  
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control form-control-sm" id="remarks"></textarea>
                    </div>
                    <div class="table-responsive mb-3">
                        <button type="button" class="btn btn-sm btn-success" id="addRowBtn">
                            <i class="ti-plus"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" id="addRowBtn">
                            <i class="ti-minus"></i>
                        </button>
                        <table class="table table-bordered table-sm" id="approversTable">
                            <thead class="table-light">
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
                                        <div style="position: relative; display: none;" disable>
                                            <input type="text" id="userSearchInput1" list="userSuggestions" class="form-control form-control-sm" disabled placeholder="Enter User Name" style="width: 100%; max-width: 200px; padding: 6px; border-radius: 5px; border: 1px solid #ced4da;">
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
                                        <div style="position: relative;  display: none;">
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
                            <button type="button" class="btn btn-success btn-lg" id="submitRequestWithdraw" disabled
                                style="background-color: #28a745; color: white; border: 1px solid #28a745; padding: 10px 20px;">
                                Submit
                            </button>
                        </div>
                    </div> --}}
                </div>
            </form>
        </div>
    </div>
</div>