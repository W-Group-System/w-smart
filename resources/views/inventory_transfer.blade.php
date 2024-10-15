@extends('layouts.dashboard_layout')

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
                <select class="form-select me-3" id="subsidiary"
                    style="width: 150px; height: 35px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); color: #6c757d; border-radius: 25px; font-size: 14px;">
                    <option selected value="1">HO</option>
                    <option value="2">WTCC</option>
                    <option value="3">CITI</option>
                    <option value="4">WCC</option>
                    <option value="5">WFA</option>
                    <option value="6">WOI</option>
                    <option value="7">WGC</option>
                </select>
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#requestTransferModal"
                    style="height: 35px; padding: 0 15px; display: flex; align-items: center; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); font-size: 14px;">
                    Request Transfer
                </a>
            </div>

        </div>

        <!-- Table Section -->
        <div class="table-responsive " style="overflow: visible;">
            <table class="table table-hover table-bordered" style="border-collapse: collapse;">
                <thead class="table-light">
                    <tr>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            ID <i class="bi bi-three-dots-vertical"></i></th>
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
                            Item Description <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Item Category <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            QTY <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            UOM <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Cost <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Usage <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Status <i class="bi "></i></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#approveTransferModal">
                        <td style="text-align: center; padding: 8px 10px;">ID</td>
                        <td style="text-align: center; padding: 8px 10px;">Transfer From</td>
                        <td style="text-align: center; padding: 8px 10px;">Transfer To</td>
                        <td style="text-align: center; padding: 8px 10px;">000000</td>
                        <td style="text-align: center; padding: 8px 10px;">Item Description</td>
                        <td style="text-align: center; padding: 8px 10px;">Item Category</td>
                        <td style="text-align: center; padding: 8px 10px;">00.00</td>
                        <td style="text-align: center; padding: 8px 10px;">PCS</td>
                        <td style="text-align: center; padding: 8px 10px;">00.00</td>
                        <td style="text-align: center; padding: 8px 10px;">Usage</td>
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
                            <input type="date" class="form-control form-control-sm" id="transactionDate" disabled>
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
                                    <th>QTY</th>
                                    <th>Cost</th>
                                    <th>Usage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td contenteditable="true">
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
                                    <td contenteditable="true" id="qty"
                                        style="background-color: #FFFFFF; color: #000; pointer-events: auto;"></td>
                                    <td contenteditable="false" id="cost"
                                        style="background-color: #E9ECEF; color: #999; pointer-events: none;"></td>
                                    <td contenteditable="false" id="usage"
                                        style="background-color: #E9ECEF; color: #999; pointer-events: none;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control form-control-sm" id="remarks"></textarea>
                    </div>

                    <!-- Approver Section -->
                    <div class="mb-3">
                        <label class="form-label">Select Approver</label>
                        <div class="dropdown" style="position: relative;">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="approverDropdown"
                                aria-expanded="false">
                                Select Approvers
                            </button>
                            <div class="dropdown-menu" id="approverDropdownMenu"
                                style="display: none; position: absolute; z-index: 1000; width: 100%; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                                <div class="form-check"
                                    style="margin-left: 30px; display: flex; align-items: center; gap: 5px;">
                                    <input class="form-check-input" type="checkbox" value="manager"
                                        id="approverManager">
                                    <label class="form-check-label" for="approverManager"
                                        style="margin: 0;">Manager</label>
                                </div>
                                <div class="form-check"
                                    style="margin-left: 30px; display: flex; align-items: center; gap: 5px;">
                                    <input class="form-check-input" type="checkbox" value="supervisor"
                                        id="approverSupervisor">
                                    <label class="form-check-label" for="approverSupervisor"
                                        style="margin: 0;">Supervisor</label>
                                </div>
                                <div class="form-check"
                                    style="margin-left: 30px; display: flex; align-items: center; gap: 5px;">
                                    <input class="form-check-input" type="checkbox" value="admin" id="approverAdmin">
                                    <label class="form-check-label" for="approverAdmin" style="margin: 0;">Admin</label>
                                </div>
                                <div class="form-check"
                                    style="margin-left: 30px; display: flex; align-items: center; gap: 5px;">
                                    <input class="form-check-input" type="checkbox" value="director"
                                        id="approverDirector">
                                    <label class="form-check-label" for="approverDirector"
                                        style="margin: 0;">Director</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div id="selectedApprovers" style="margin-top: 10px;">
                            <!-- Selected approvers will be displayed here -->
                        </div>
                    </div>

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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="approveTransferButton">Approve</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="userName" value="{{ auth()->user()->name }}">

@endsection

@push('scripts')
    <script src="{{ asset('js/inventory.js') }}"></script>
    <script src="{{ asset('js/inventory_transfer.js') }}"></script>
@endpush