{{-- @extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    @include('layouts.inventory_header')

    <!-- Main Content Section -->
    <div class="card p-4" style="border: 1px solid #ddd; border-radius: 20px; margin-top: -25px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h6 class="fw-bold me-3">Masterlist</h6>
                <input type="hidden" id="userId" value="{{ auth()->user()->id }}">
                <input type="hidden" id="userName" value="{{ auth()->user()->name }}">
                <input type="hidden" id="usersubsidiary" value="{{ auth()->user()->subsidiary }}">
                <input type="hidden" id="usersubsidiaryid" value="{{ auth()->user()->subsidiaryid }}">
                <div class="input-group" style="max-width: 350px; position: relative;">
                    <input type="text" class="form-control" placeholder="Search here" aria-label="Search"
                        id="searchInput" style="padding-right: 100px; border-radius: 20px; height: 35px;">
                    <img src="{{ asset('images/search.svg') }}" alt="Search Icon"
                        style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px;">
                </div>
                <div class="btn-group ms-3" style="height: 35px; position: relative;">
                    <button type="button" class="btn btn-outline-secondary" id="downloadButton"
                        style="height: 35px; padding: 0 15px;" data-bs-toggle="popover" data-bs-html="true"
                        data-bs-trigger="focus" data-bs-content='
                        <div style="font-family: "Inter", sans-serif; color: #79747E;">
                            <button class="btn btn-sm btn-light" id="downloadCSV" style="display: flex; justify-content: space-between; width: 100%; align-items: center; border-radius: 8px; color: #79747E;">
                                Download CSV 
                                <img src="{{ asset('images/download.svg') }}" style="width: 16px; height: 16px; margin-left: 8px;" alt="Download CSV">
                            </button>
                            <button class="btn btn-sm btn-light mt-1" id="downloadExcel" style="display: flex; justify-content: space-between; width: 100%; align-items: center; border-radius: 8px; color: #79747E;">
                                Download Excel 
                                <img src="{{ asset('images/download.svg') }}" style="width: 16px; height: 16px; margin-left: 8px;" alt="Download Excel">
                            </button>
                            <button class="btn btn-sm btn-light mt-1" id="downloadPDF" style="display: flex; justify-content: space-between; width: 100%; align-items: center; border-radius: 8px; color: #79747E;">
                                Download PDF 
                                <img src="{{ asset('images/download.svg') }}" style="width: 16px; height: 16px; margin-left: 8px;" alt="Download PDF">
                            </button>
                        </div>'>
                        Download
                    </button>
                    <button type="button" class="btn btn-outline-secondary" style="height: 35px; padding: 0 15px;">
                        Print
                    </button>
                </div>
            </div>

            <div class="d-flex align-items-center">
<!--                 <select class="form-select me-3" id="subsidiary"
                    style="width: 150px; height: 35px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); color: #6c757d; border-radius: 25px; font-size: 14px;">
                    <option selected value="1">HO</option>
                    <option value="2">WTCC</option>
                    <option value="3">CITI</option>
                    <option value="4">WCC</option>
                    <option value="5">WFA</option>
                    <option value="6">WOI</option>
                    <option value="7">WGC</option>
                </select> -->
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inventoryWithdrawalModal" id="addWithdraw"
                   style="display: none; height: 35px; padding: 0 15px; flex; align-items: center; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); font-size: 14px;">
                   Inventory Return
                </a>
            </div>

        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="border-collapse: collapse; min-width: 1000px;">
               <thead class="table-light">
                   <tr>
                       <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                       </th>
                       <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                           Date of Request <i class="bi bi-three-dots-vertical"></i>
                       </th>
                       <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                           Requestor Name <i class="bi bi-three-dots-vertical"></i>
                       </th>
                       <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                           Request Number <i class="bi bi-three-dots-vertical"></i>
                       </th>
                       <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                           Subsidiary <i class="bi bi-three-dots-vertical"></i>
                       </th>
                       <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                           Item Code <i class="bi bi-three-dots-vertical"></i>
                       </th>
                       <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                           Item Description <i class="bi bi-three-dots-vertical"></i>
                       </th>
                       <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                           Withdrew QTY <i class="bi bi-three-dots-vertical"></i>
                       </th>
                       <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                           Returned QTY <i class="bi bi-three-dots-vertical"></i>
                       </th>
                       <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                           UOM <i class="bi bi-three-dots-vertical"></i>
                       </th>
                       <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                           Status <i class="bi bi-three-dots-vertical"></i>
                       </th>
                   </tr>
               </thead>
               <tbody>
                   <!-- Add your table rows here -->
               </tbody>
           </table>
       </div>

        <!-- Pagination Section -->
        <hr style="border-top: 1px solid #ddd; margin-top: 10px; margin-bottom: 10px;">

        <div class="d-flex justify-content-end align-items-center mt-3 border-top pt-3">
            <div class="d-flex align-items-center me-3">
                <span>Rows per page:</span>
                <select class="form-select form-select-sm d-inline-block w-auto ms-2" style="border-radius: 5px;">
                    <option>5</option>
                    <option>10</option>
                    <option>20</option>
                </select>
            </div>
            <div class="me-3 dynamic-rows-info">1-5 of 13</div>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Return Modal -->
<div class="modal fade" id="inventoryWithdrawalModal" tabindex="-1" aria-labelledby="inventoryWithdrawalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="padding: 20px;">
            <div class="modal-header">
                <h5 class="modal-title" id="inventoryWithdrawalModalLabel">Inventory Return</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2">
                <form id="inventoryWithdrawalForm">
                    <!-- Transaction Information -->
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label for="requestedDateTime" class="form-label">Requested Date/Time</label>
                            <input type="text" class="form-control form-control-sm" id="withdrawalDate" value="Auto Generate" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="requestNumber" class="form-label">Request Number</label>
                            <input type="text" class="form-control form-control-sm" id="requestNumber" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="requestorName" class="form-label">Requestor Name</label>
                            <input type="text" class="form-control form-control-sm" id="requestName" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="requestorName" class="form-label">Subsidiary</label>
                            <input type="text" class="form-control form-control-sm" id="subsidiary" value="HO" readonly>
                        </div>

                    </div>

                    <!-- Item Information Table -->

                    <div class="table-responsive mb-3">
                        <!-- Button to add a new row -->
                        <button type="button" class="btn btn-link text-secondary fw-bold" id="returnAddRowBtn"
                            style="font-size: 14px;">
                            + Add More Item
                        </button>
                        <table  class="table table-hover table-bordered" style="border-collapse: collapse; min-width: 1000px;" id="itemsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Request ID</th>
                                    <th>Item Code</th>
                                    <th>Item Description</th>
                                    <th>UOM</th>
                                    <th>Withdrew QTY</th>
                                    <th>Returned QTY</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody id="returnItemTableBody">
                                <tr>
                                    <div style="position: relative;">
                                    <td contenteditable="false">
                                        <div style="position: relative;">
                                            <input type="text" class="form-control form-control-sm itemCodeInput" placeholder="Enter request id" style="width: 100%; max-width: 200px; padding: 6px; border-radius: 5px; border: 1px solid #ced4da;" list="itemSuggestions">
                                            <datalist id="itemSuggestions"></datalist>
                                        </div>
                                    </td>
                                    <td contenteditable="false" class="itemCode" style="background-color: #E9ECEF; color: #999; pointer-events: none;"></td>
                                    <td contenteditable="false" class="itemDescription" style="background-color: #E9ECEF; color: #999; pointer-events: none;"></td>
                                    <td contenteditable="false" class="itemCategory" style="background-color: #E9ECEF; color: #999; pointer-events: none; display: none;"></td>
                                    <td>
                                        <select class="form-select form-select-sm uom-dropdown">
                                        </select>
                                    </td>
                                    <td contenteditable="false" class="withdrewQty"></td>
                                    <td contenteditable="true" class="returnQty"></td>
                                    <td contenteditable="true" class="reason"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                  
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control form-control-sm" id="remarks"></textarea>
                    </div>
                    <div class="table-responsive mb-3">
                        <button type="button" class="btn btn-link text-secondary fw-bold" id="addMoreApprover" style="font-size: 14px;">
                            + Add More Approver
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
                                    <td contenteditable="true">
                                        <div style="position: relative;">
                                            <input type="text" id="userSearchInput1" list="userSuggestions" class="form-control form-control-sm" placeholder="Enter User Name" style="width: 100%; max-width: 200px; padding: 6px; border-radius: 5px; border: 1px solid #ced4da;">
                                            <datalist id="userSuggestions"></datalist>
                                            <input type="hidden" id="userIdInput1">
                                        </div>
                                    </td>
                                    <td contenteditable="false" id="userRoleInput1" style="background-color: #E9ECEF; color: #999; pointer-events: none;">Auto Generate</td>
                                    <td contenteditable="false" class="hierarchy-input" style="background-color: #E9ECEF; color: #999; pointer-events: none;">1</td>
                                    <td contenteditable="true"></td>
                                </tr>
                                <tr>
                                    <td contenteditable="true">
                                        <div style="position: relative;">
                                            <input type="text" id="userSearchInput2" list="userSuggestions" class="form-control form-control-sm" placeholder="Enter User Name" style="width: 100%; max-width: 200px; padding: 6px; border-radius: 5px; border: 1px solid #ced4da;">
                                            <datalist id="userSuggestions"></datalist>
                                            <input type="hidden" id="userIdInput2">
                                        </div>
                                    </td>
                                    <td contenteditable="false" id="userRoleInput2" style="background-color: #E9ECEF; color: #999; pointer-events: none;">Auto Generate</td>
                                    <td contenteditable="false" class="hierarchy-input" style="background-color: #E9ECEF; color: #999; pointer-events: none;">2</td>
                                    <td contenteditable="true"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <input type="hidden" id="userIdInput">
                    <input type="hidden" id="userEmailInput">
                    <!-- Action Section -->
                    <div class="row g-2 align-items-end mb-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-success btn-lg" id="submitRequestReturn" disabled
                                style="background-color: #28a745; color: white; border: 1px solid #28a745; padding: 10px 20px;">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="approveWithdrawModal" tabindex="-1" aria-labelledby="approveWithdrawModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveWithdrawModalLabel">Approve Return</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve this return request?</p>
                <p id="approvedByText" class="fw-bold" style="margin-top: 10px;"></p>
                <div class="mb-3">
                    <label for="requestedQty" class="form-label">Requested QTY</label>
                    <input type="text" id="requestedQty" class="form-control" disabled>
                </div>
                <div class="mb-3">
                    <label for="releasedQty" class="form-label">Return QTY</label>
                    <input type="number" id="returnQty" placeholder="Return Qty" class="form-control" min="0" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="approveWithdrawButton">Approve</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="receiveWithdrawModal" tabindex="-1" aria-labelledby="receiveWithdrawModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="receiveWithdrawModalLabel">Finalize Return Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Have you release the correct return qty for this return request?</p>
                <div class="mb-3">
                    <label for="requestedQtyReceive" class="form-label">Requested QTY</label>
                    <input type="text" id="requestedQtyReceive" class="form-control" disabled>
                </div>
                <div class="mb-3">
                    <label for="releasedQtyReceive" class="form-label">Return QTY</label>
                    <input type="number" id="returnQtyReceive" placeholder="Released Qty" class="form-control" min="0" disabled/>
                </div>
                <div class="mb-3">
                    <label for="photoUploadInput" class="form-label">Upload Photo (Optional)</label>
                    <input type="file" id="photoUploadInput" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="receiveWithdrawButton">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tableReturnModal" tabindex="-1" role="dialog" aria-labelledby="tableReturnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tableReturnModalLabel">Pending Withdraw Item List</h5>
                <button type="button" class="close" data-dismiss="modal" onclick="CloseModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-hover table-bordered" style="border-collapse: collapse; min-width: 1000px;">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Date</th>
                            <th>Item Code</th>
                            <th>Item Description</th>
                            <th>Item Category</th>
                            <th>UOM</th>
                            <th>Returned QTY</th>
                            <th>Requestor</th>
                            <th>status</th>
                        </tr>
                    </thead>
                    <tbody id="returnItemList">
                
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="CloseModal()" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/returns.js') }}"></script>
@endpush --}}

@extends('layouts.header')

@section('content')
    <div class="row">
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    From
                                    <input type="date" name="" class="form-control" required>
                                </div>
                                <div class="col-lg-4">
                                    To
                                    <input type="date" name="" class="form-control" required>
                                </div>
                                <div class="col-lg-4">
                                    <button type="button" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-tale">
                        <div class="card-body">
                            <h4 class="mb-4">Pending</h4>
                            0
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card text-success">
                        <div class="card-body">
                            <h4 class="mb-4">Approved</h4>
                            0
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Returned Inventory</h4>
                    
                    <a href="{{ url('new_returned_request') }}" class="btn btn-outline-success" >
                        <i class="ti-plus"></i>
                        Return Inventory
                    </a>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tablewithSearch">
                            <thead>
                                <tr>
                                    <th>
                                        Date of Request
                                    </th>
                                    <th>
                                        Requestor Name
                                    </th>
                                    <th>
                                        Request Number
                                    </th>
                                    {{-- <th>
                                        Subsidiary
                                    </th> --}}
                                    <th>
                                        Item Code
                                    </th>
                                    <th>
                                        Item Description
                                    </th>
                                    <th>
                                        Returned QTY
                                    </th>
                                    <th>
                                        UOM
                                    </th>
                                    <th>
                                        Reason of returned
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($returned_inventories as $return_inventory)
                                    <tr>
                                        <td>{{date('M d Y', strtotime($return_inventory->created_at))}}</td>
                                        <td>{{$return_inventory->requestor->name}}</td>
                                        <td>RETURNED-{{str_pad($return_inventory->id, 3, "0", STR_PAD_LEFT)}}</td>
                                        {{-- <td>{{$return_inventory->subsidiary->subsidiary_name}}</td> --}}
                                        <td>
                                            @foreach ($return_inventory->returnItem as $returnItem)
                                                {{ $returnItem->inventory->item_code }} <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($return_inventory->returnItem as $returnItem)
                                                {{ $returnItem->inventory->item_description }} <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($return_inventory->returnItem as $returnItem)
                                                {{ $returnItem->request_qty }} <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($return_inventory->returnItem as $returnItem)
                                                {{ $returnItem->uom->uomp }} <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($return_inventory->returnItem as $returnItem)
                                            {!! nl2br(e($returnItem->reason)) !!} <br>
                                            <hr>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($return_inventory->status == 'Pending')
                                            <span class="badge badge-warning">
                                            @elseif($return_inventory->status == 'Declined')
                                            <span class="badge badge-danger">
                                            @elseif($return_inventory->status == 'Approved')
                                            <span class="badge badge-success">
                                            @endif
                                                {{$return_inventory->status}}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $("#tablewithSearch").DataTable({
            dom: 'Bfrtip',
            ordering: true,
            pageLength: 25,
            paging: true,
        });
    })
</script>
@endsection