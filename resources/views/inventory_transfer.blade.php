@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    @include('layouts.inventory_header')

    <!-- Main Content Section -->
    <div class="card p-4" style="border: 1px solid #ddd; border-radius: 20px; margin-top: -25px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h6 class="fw-bold me-3">Masterlist</h6>
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
                        </th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Transfer From <i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Transfer To <i class="bi bi-three-dots-vertical"></i>
                        </th>
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
                            Status <i class="bi bi-three-dots-vertical"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center; padding: 2px 10px;"></td>
                        <td style="text-align: center; padding: 2px 10px;">Transfer From</td>
                        <td style="text-align: center; padding: 2px 10px;">Transfer To</td>
                        <td style="text-align: center; padding: 2px 10px;">000000</td>
                        <td style="text-align: center; padding: 2px 10px;">Item Description</td>
                        <td style="text-align: center; padding: 2px 10px;">Item Category</td>
                        <td style="text-align: center; padding: 2px 10px;">00.00</td>
                        <td style="text-align: center; padding: 2px 10px;">PCS</td>
                        <td style="text-align: center; padding: 2px 10px;">00.00</td>
                        <td style="text-align: center; padding: 2px 10px;">Usage</td>
                        <td style="text-align: center; padding: 2px 10px;">
                            <span class="badge bg-danger">Pending</span>
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
                            <input type="date" class="form-control form-control-sm" id="transactionDate">
                        </div>
                        <div class="col-md-6">
                            <label for="transactionNumber" class="form-label">Transaction Number</label>
                            <input type="text" class="form-control form-control-sm" id="transactionNumber">
                        </div>
                        <div class="col-md-6">
                            <label for="transferFrom" class="form-label">Transfer From</label>
                            <select class="form-select form-select-sm" id="transferFrom">
                                <option>Select</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="transferTo" class="form-label">Transfer To</label>
                            <select class="form-select form-select-sm" id="transferTo">
                                <option>Select</option>
                            </select>
                        </div>
                    </div>

                    <!-- Item Information Table -->
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Item Code</th>
                                    <th>Item Description</th>
                                    <th>Category</th>
                                    <th>Primary UOM</th>
                                    <th>Secondary UOM</th>
                                    <th>Tertiary UOM</th>
                                    <th>QTY</th>
                                    <th>Cost</th>
                                    <th>Usage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td contenteditable="false">Auto Generate</td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="false">Auto Generate</td>
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
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                    <th>Action Date</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td contenteditable="false">Auto Generate</td>
                                    <td contenteditable="false">Auto Generate</td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Action Section -->
                    <div class="row g-2 align-items-end mb-3">
                        <div class="col-md-3">
                            <label for="action" class="form-label">Action</label>
                            <select class="form-select form-select-sm" id="action">
                                <option>Select</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="actionRemarks" class="form-label">Remarks</label>
                            <input type="text" class="form-control form-control-sm" id="actionRemarks"
                                style="height: 50px;">
                        </div>
                        <div class="col-md-3 d-flex justify-content-end">
                            <button type="button" class="btn btn-success btn-sm" id="submitRequestTransfer"
                                style="background-color: #28a745; color: white; border: 1px solid #28a745; padding: 6px 12px;">
                                Submit
                            </button>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    @endsection

    @push('scripts')
        <script src="{{ asset('js/inventory.js') }}"></script>
    @endpush