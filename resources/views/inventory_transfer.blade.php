{{-- @extends('layouts.dashboard_layout')

@section('dashboard_content')
<meta name="requester-id" content="{{ auth()->user()->id }}">
<meta name="requester-name" content="{{ auth()->user()->name }}">

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

            <input type="hidden" id="userSubsidiary" value="{{ auth()->user()->subsidiary }}">
            <div class="d-flex align-items-center">
            <select class="form-select me-3" id="subsidiary"
                style="width: 150px; height: 35px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); color: #6c757d; border-radius: 25px; font-size: 14px;">
                <option value="1" {{ auth()->user()->subsidiary == 'HO' ? 'selected' : '' }}>HO</option>
                <option value="2" {{ auth()->user()->subsidiary == 'WTCC' ? 'selected' : '' }}>WTCC</option>
                <option value="3" {{ auth()->user()->subsidiary == 'CITI' ? 'selected' : '' }}>CITI</option>
                <option value="4" {{ auth()->user()->subsidiary == 'WCC' ? 'selected' : '' }}>WCC</option>
                <option value="5" {{ auth()->user()->subsidiary == 'WFA' ? 'selected' : '' }}>WFA</option>
                <option value="6" {{ auth()->user()->subsidiary == 'WOI' ? 'selected' : '' }}>WOI</option>
                <option value="7" {{ auth()->user()->subsidiary == 'WGC' ? 'selected' : '' }}>WGC</option>
            </select>
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#requestTransferModal" id="requestTransferOpen"
                    style="height: 35px; padding: 0 15px; display: flex; align-items: center; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); font-size: 14px;">
                    Request Transfer
                </a>
            </div>

        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="border-collapse: collapse; min-width: 1000px;">
                <thead class="table-light">
                    <tr>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            ID <i class="bi bi-three-dots-vertical"></i></th>
                        <th style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Transfer ID <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Transfer From <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Transfer To <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Item Code <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Description <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Category <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Requested QTY <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            UOM <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Status <i class="bi "></i></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#approveTransferModal">
                        <td style="text-align: center; padding: 8px 10px;">ID</td>
                        <td style="text-align: center; padding: 8px 10px;">Transfer ID</td>
                        <td style="text-align: center; padding: 8px 10px;">Transfer From</td>
                        <td style="text-align: center; padding: 8px 10px;">Transfer To</td>
                        <td style="text-align: center; padding: 8px 10px;">000000</td>
                        <td style="text-align: center; padding: 8px 10px;">Item Description</td>
                        <td style="text-align: center; padding: 8px 10px;">Item Category</td>
                        <td style="text-align: center; padding: 8px 10px;">00.00</td>
                        <td style="text-align: center; padding: 8px 10px;">PCS</td>
                        <td style="text-align: center; padding: 8px 10px;">00.00</td>
                        <td style="text-align: center; padding: 8px 10px;">
                            <span class="badge bg-danger cursor-pointer" data-bs-toggle="modal"
                                data-bs-target="#approveTransferModal">
                                Pending
                            </span>
                        </td>
                    </tr>
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

<!-- Transfer Modal -->
<div class="modal fade" id="requestTransferModal" tabindex="-1" aria-labelledby="requestTransferModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="padding: 20px;">
            <div class="modal-header d-flex justify-content-start">
                <h5 class="modal-title" id="requestTransferModalLabel">Inventory Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2">
                <form id="requestTransferForm">
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
                            <select class="form-select form-select-sm" id="transferFrom">
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
                            <select class="form-select form-select-sm" id="transferTo" disabled>
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
                        <button type="button" class="btn btn-link text-secondary fw-bold" id="addMoreItems"
                            style="font-size: 14px;">
                            + Add More Item
                        </button>
                        <table class="table table-bordered table-sm" id="itemsTable">
                            <thead class="table-light">
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
                                        <select class="form-select form-select-sm uom-dropdown" id="uom">
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
                         <button type="button" class="btn btn-link text-secondary fw-bold" id="addMoreApprover" style="font-size: 14px; display: none;">
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

                    <input type="hidden" id="userIdInput">
                    <input type="hidden" id="userEmailInput">

                    <!-- Action Section -->
                    <div class="row g-2 align-items-end mb-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-success btn-lg" id="submitRequestTransfer"
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

<!-- Approve Transfer Modal -->
<div class="modal fade" id="approveTransferModal" tabindex="-1" aria-labelledby="approveTransferModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveTransferModalLabel">Approve Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve this transfer request?</p>
                <p id="approvedByText" class="fw-bold" style="margin-top: 10px;"></p>
                <div class="mb-3">
                    <label for="requestedQty" class="form-label">Requested QTY</label>
                    <div id="requestedQty" class="form-control" style="pointer-events: none; background-color: #e9ecef;"></div>
                </div>
                <div class="mb-3">
                    <label for="releasedQty" class="form-label">Released QTY</label>
                    <input type="number" id="releasedQty" placeholder="Released Qty" class="form-control" min="0" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="declineTransferButton">Decline</button>
                <button type="button" class="btn btn-primary" id="approveTransferButton">Approve</button>
            </div>
        </div>
    </div>
</div>

<!-- Receive Transfer Modal -->
<div class="modal fade" id="receiveTransferModal" tabindex="-1" aria-labelledby="receiveTransferModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="receiveTransferModalLabel">Receive Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Have you received the correct released qty for this transfer?</p>
                <div class="mb-3">
                    <label for="requestedQtyReceive" class="form-label">Requested QTY</label>
                    <div id="requestedQtyReceive" class="form-control" style="pointer-events: none; background-color: #e9ecef;"></div>
                </div>
                <div class="mb-3">
                    <label for="releasedQtyReceive" class="form-label">Released QTY</label>
                    <input type="number" id="releasedQtyReceive" placeholder="Released Qty" class="form-control" min="0" disabled/>
                </div>
                <div class="mb-3">
                    <label for="photoUploadInput" class="form-label">Upload Photo (Optional)</label>
                    <input type="file" id="photoUploadInput" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="declineTransferButtonReceive">No Receive</button>
                <button type="button" class="btn btn-primary" id="receiveTransferButton">Receive</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tableTransferModal" tabindex="-1" role="dialog" aria-labelledby="tableTransferModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tableTransferModalLabel">Pending Transfer Item List</h5>
                <button type="button" class="close" data-dismiss="modal" onclick="CloseModalTransfer()" aria-label="Close">
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
                            <th>Released QTY</th>
                            <th>Requestor</th>
                            <th>status</th>
                        </tr>
                    </thead>
                    <tbody id="transferItemList">
                
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="CloseModalTransfer()" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="userName" value="{{ auth()->user()->name }}">

@endsection

@push('scripts')
    <script src="{{ asset('js/inventory_transfer.js') }}"></script>
    <script src="{{ asset('js/inventory.js') }}"></script>
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
                    <h4 class="card-title">Inventory Transfer</h4>

                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#requestTransferModal">
                        <i class="ti-plus"></i>
                        Request Transfer
                    </button>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tablewithSearch">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Transaction Number</th>
                                    <th>Transaction Date</th>
                                    <th>Transfer From</th>
                                    <th>Transfer To</th>
                                    <th>Item Code</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    {{-- <th>Requested QTY</th> --}}
                                    <th>UOM</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transfers as $transfer)
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" title="Approvers" data-toggle="modal" data-target="#viewApprovers{{$transfer->id}}">
                                                <i class="ti-user"></i>
                                            </button>
                                            {{-- <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{$transfer->id}}">
                                                <i class="ti-pencil-alt"></i>
                                            </button> --}}
                                        </td>
                                        <td>TRANSACT-{{ str_pad($transfer->id, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ date('M d Y', strtotime($transfer->created_at)) }}</td>
                                        <td>{{$transfer->transferFrom->subsidiary_name}}</td>
                                        <td>{{$transfer->transferTo->subsidiary_name}}</td>
                                        <td>
                                            @foreach ($transfer->inventoryTransfer as $item)
                                                {{$item->inventory->item_code}} <br>
                                                <hr>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($transfer->inventoryTransfer as $item)
                                                {{$item->inventory->item_description}} <br>
                                                <hr>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($transfer->inventoryTransfer as $item)
                                                {{$item->inventory->category->name}} <br>
                                                <hr>
                                            @endforeach
                                        </td>
                                        {{-- <td>
                                            @foreach ($transfer->inventoryTransfer as $item)
                                                {{$item->request_qty}} <br>
                                                <hr>
                                            @endforeach
                                        </td> --}}
                                        <td>
                                            @foreach ($transfer->inventoryTransfer as $item)
                                                {{$item->uom->uomp}} <br>
                                                <hr>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($transfer->status)
                                            @else
                                            <span class="badge badge-warning">Pending</span>
                                            @endif
                                        </td>
                                    </tr>

                                    @include('inventory_transfer.view_approvers')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('inventory_transfer.new_inventory_transfer')
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

        $(document).on('change', "[name='item_code[]']", function() {
            var inventory_id = $(this).val()

            var itemDescription = $(this).closest('tr').find('.itemDescriptionTd')
            var category = $(this).closest('tr').find('.categoryTd')
            var qty = $(this).closest('tr').find('.qty')
            var itemDescriptionValue = $("[name='item_description[]']")
            var categoryValue = $("[name='category[]']")
            
            itemDescription.text("")
            category.text("")
            itemDescriptionValue.val("")
            categoryValue.val("")

            $.ajax({
                type: "POST",
                url: "{{url('refresh_inventory')}}",
                data: {
                    id: inventory_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    itemDescription.text(response.item_description)
                    category.text(response.category.name)
                    qty.text(response.qty)

                    itemDescriptionValue.val(response.item_description)
                    categoryValue.val(response.category_id)
                }
            })
        })

        var optionData = '';
        $(document).on('change', "[name='transfer_from']", function() {
            var getValue = $(this).val()

            $.ajax({
                type: "POST",
                url: "{{ url('refresh_inventory_per_subsidiary') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: getValue
                },
                success:function(data)
                {
                    optionData = data

                    $("[name='item_code[]']").html(data)

                    $(".itemDescriptionTd").text("")
                    $(".itemDescriptionTd").val("")

                    $(".categoryTd").text("")
                    $(".categoryTd").val("")
                }   
            })
        })
        
        $("#addMoreItems").on('click', function() {
            var newRow = `
                <tr>
                    <td>
                        <select data-placeholder="Select item code" name="item_code[]" class="form-control js-example-basic-single" style="width: 100%;" required>
                            ${optionData}
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
                </tr>
            `

            $("#inventoryTable tbody").append(newRow)
            $(".js-example-basic-single").select2()
        })

        $("#removeItems").on('click', function() {
            
            if ($("#inventoryTable tbody").children().length > 1)
            {
                $("#inventoryTable tbody").children().last().remove()
            }
        })
    })
</script>
@endsection