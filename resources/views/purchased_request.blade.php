@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    @include('layouts.procurement_header')

    <!-- Main Content Section -->
    <div class="card p-4" style="border: 1px solid #ddd; border-radius: 20px; margin-top: -25px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h6 class="fw-bold me-3">Procurement List</h6>
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
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPurchaseRequest" id="addPR"
                    style="height: 35px; padding: 0 15px; display: flex; align-items: center; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); font-size: 14px;">
                    Add New PR
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
                            Request Date <i class="bi bi-three-dots-vertical"></i></th>
                        </th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            PR Number <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Item Description <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Due Date <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Requestor Name <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Department <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Subsidiary <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Amount <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Expedited <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Status </th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Assigned to (Buyer) </th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Assigned Date/Time </th>
                    </tr>
                </thead>
                <tbody>
<!--                     <tr>
                        <td style="text-align: center; padding: 2px 10px;"></td>
                        <td style="text-align: center; padding: 2px 10px;">00/00/0000</td>
                        <td style="text-align: center; padding: 2px 10px;">000000</td>
                        <td style="text-align: center; padding: 2px 10px;">Item Description</td>
                        <td style="text-align: center; padding: 2px 10px;">Item Category</td>
                        <td style="text-align: center; padding: 2px 10px;">00.00</td>
                        <td style="text-align: center; padding: 2px 10px;">PCS</td>
                        <td style="text-align: center; padding: 2px 10px;">00.00</td>
                        <td style="text-align: center; padding: 2px 10px;">Usage</td>
                        
                    </tr> -->
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

<!-- Modify Modal -->
{{-- <div class="modal fade" id="modifyModal" tabindex="-1" aria-labelledby="modifyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifyModalLabel">Modify</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modifyForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="itemCode" class="form-label">Item Code</label>
                            <input type="text" class="form-control" id="itemCode" value="Auto Generate" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="itemDescription" class="form-label" required>Item Description</label>
                            <input type="text" class="form-control" id="itemDescription">
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category">
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="primaryUOM" class="form-label">Primary UOM</label>
                            <select class="form-select" id="primaryUOM">
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="secondaryUOM" class="form-label">Secondary UOM</label>
                            <select class="form-select" id="secondaryUOM">
                            </select>
                        </div>
                        <div class="col-md-6" id="tertiaryUOMContainer">
                            <label for="tertiaryUOM" class="form-label">Tertiary UOM</label>
                            <select class="form-select" id="tertiaryUOM">
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity">
                        </div>
                        <div class="col-md-6">
                            <label for="cost" class="form-label">Cost</label>
                            <input type="number" class="form-control" id="cost">
                        </div>
                        <div class="col-md-12">
                            <label for="usage" class="form-label">Qty</label>
                            <input type="text" class="form-control" id="usage" value="Auto Generate" readonly>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="saveChanges">Save</button>
            </div>
        </div>
    </div>
</div> --}}

<!-- PR Modal -->
<div class="modal fade" id="addPurchaseRequest" tabindex="-1" aria-labelledby="addInventoryModalLabel"
    aria-hidden="true" style="z-index: 1400;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInventoryModalLabel">Purchase Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addInventoryForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="puchaseNo" class="form-label">Purchase No.:</label>
                            <input type="text" class="form-control" id="puchaseNo" value="Auto Generated" readonly style="height: 50%;">
                        </div>
                        <div class="col-md-6">
                            {{-- <label for="newItemCode" class="form-label">Item Code</label>
                            <input type="text" class="form-control" id="newItemCode" readonly style="height: 50%;"> --}}
                        </div>
                        <div class="col-md-6">
                            <label for="requestorName" class="form-label" >Requestor Name:</label>
                            <input type="text" class="form-control" id="requestorName" required style="height: 50%;" value="{{auth()->user()->name}}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="requestedDateTime" class="form-label">Requested Date/Time:</label>
                            <input type="datetime-local" class="form-control" style="height: 50%;" id="requestedDateTime" value="{{date('Y-m-d H:i:s')}}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea name="" class="form-control" cols="30" rows="10" style="height: 50%;"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="requestDueDate" class="form-label">Request Due-Date:</label>
                            <input type="date" name="requestDueDate" id="requestDueDate" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <label for="assignedTo" class="form-label">Assigned To:</label>
                            <!-- <input type="text" id="primaryUOMSearch" placeholder="Search Primary UOM" class="form-control"> -->
                            <select class="form-select" id="assignedTo" required></select>
                        </div>

                        <div class="col-md-6">
                        </div>

                        <div class="col-md-6">
                            <label for="subsidiary" class="form-label">Subsidiary:</label>
                            <!-- <input type="text" id="tertiaryUOMSearch" placeholder="Search Tertiary UOM" class="form-control"> -->
                            <select class="form-select" id="subsidiary"></select>
                        </div>

                        <div class="col-md-6">
                            <label for="class" class="form-label" >Class:</label>
                            <select class="form-select" id="class"></select>
                        </div>

                        <div class="col-md-6">
                            <label for="department" class="form-label">Department</label>
                            <select data-placeholder="Select department" class="form-select" id="department">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            {{-- <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" style="height: 50%" rows="3"></textarea> --}}
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Item Code</th>
                                            <th>Item Category</th>
                                            <th>Item Description</th>
                                            <th>Item Quantity</th>
                                            <th>Unit of Measurement</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyAddRow">
                                        <tr>
                                            <td>
                                                <input type="text" name="" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="" class="form-control form-control-sm">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-success" id="addRow">
                                    Add Row
                                </button>
                                <button type="button" class="btn btn-danger" id="deleteRowBtn">
                                    Delete Row
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- <label for="newUsage" class="form-label">Usage</label>
                            <input type="number" class="form-control" id="newUsage" value=0 required style="height: 50%"> --}}
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="saveNewInventory">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- <div class="modal fade" id="tableModal" tabindex="-1" role="dialog" aria-labelledby="tableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tableModalLabel">Transfer Item List</h5>
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
                            <th>Released QTY</th>
                            <th>Requestor</th>
                            <th>status</th>
                        </tr>
                    </thead>
                    <tbody id="transferItemList">
                
                    </tbody>
                </table>
            </div>
            <!-- <hr style="border-top: 1px solid #ddd; margin-top: 10px; margin-bottom: 10px; margin-left: 10px; margin-right: 10px;">

            <div class="d-flex justify-content-between align-items-center mt-3 border-top pt-3">
                <div class="d-flex align-items-center">
                    <span>Rows per page:</span>
                    <select class="form-select form-select-sm ms-2" style="width: auto; border-radius: 5px;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                    </select>
                </div>
                <div class="d-flex align-items-center">
                    <span class="dynamic-rows-info me-3">1-5 of 13</span>
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous" tabindex="-1">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div> -->
            <div class="modal-footer">
                <button type="button" onclick="CloseModal()" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> --}}

@endsection

@push('scripts')
    <script src="{{ asset('js/purchaseRequest.js') }}"></script>
@endpush