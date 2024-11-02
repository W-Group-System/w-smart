@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    @include('layouts.equipment_header')

    <!-- Main Content Section -->
    <div class="card p-4" style="border: 1px solid #ddd; border-radius: 20px; margin-top: -25px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h6 class="fw-bold me-3">Asset Masterlist</h6>
                <div class="input-group" style="max-width: 350px; position: relative;">
                    <input type="text" class="form-control" placeholder="Search assets" aria-label="Search"
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
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAssetModal"
                    style="height: 35px; padding: 0 15px; display: flex; align-items: center;">
                    Add New Asset
                </a>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="border-collapse: collapse; min-width: 1000px;">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="padding: 8px 10px; font-weight: 400; color: #637281;">Asset Name
                        </th>
                        <th class="text-center" style="padding: 8px 10px; font-weight: 400; color: #637281;">Asset Code
                        </th>
                        <th class="text-center" style="padding: 8px 10px; font-weight: 400; color: #637281;">Date
                            Acquired</th>
                        <th class="text-center" style="padding: 8px 10px; font-weight: 400; color: #637281;">Type</th>
                        <th class="text-center" style="padding: 8px 10px; font-weight: 400; color: #637281;">Category
                        </th>
                        <th class="text-center" style="padding: 8px 10px; font-weight: 400; color: #637281;">Status</th>
                        <th class="text-center" style="padding: 8px 10px; font-weight: 400; color: #637281;">Subsidiary
                        </th>
                        <th class="text-center" style="padding: 8px 10px; font-weight: 400; color: #637281;">Remarks
                        </th>
                        <th class="text-center" style="padding: 8px 10px; font-weight: 400; color: #637281;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Asset rows will go here -->
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
            <div class="me-3 dynamic-rows-info">1-5 of X</div>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">
                    <!-- Pagination links -->
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Asset Modal (for adding new assets) -->
<div class="modal fade" id="addAssetModal" tabindex="-1" aria-labelledby="addAssetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAssetModalLabel">New Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAssetForm">
                    @csrf
                    <div class="row g-3">
                        <!-- Date Fields -->
                        <div class="col-md-6">
                            <label for="datePurchased" class="form-label">Date Purchased</label>
                            <input type="date" class="form-control" id="datePurchased">
                        </div>
                        <div class="col-md-6">
                            <label for="dateInstallation" class="form-label">Date Installation</label>
                            <input type="date" class="form-control" id="dateInstallation">
                        </div>
                        <div class="col-md-6">
                            <label for="dateAcquired" class="form-label">Date Acquired</label>
                            <input type="date" class="form-control" id="dateAcquired">
                        </div>
                        <div class="col-md-6">
                            <label for="dateTransferred" class="form-label">Date Transferred</label>
                            <input type="date" class="form-control" id="dateTransferred">
                        </div>
                        <div class="col-md-6">
                            <label for="dateRepaired" class="form-label">Date Repaired</label>
                            <input type="date" class="form-control" id="dateRepaired">
                        </div>
                        <div class="col-md-6">
                            <label for="eulDate" class="form-label">EUL Date</label>
                            <input type="date" class="form-control" id="eulDate">
                        </div>

                        <!-- General Asset Information -->
                        <div class="col-md-6">
                            <label for="assetName" class="form-label">Asset Name</label>
                            <input type="text" class="form-control" id="assetName">
                        </div>
                        <div class="col-md-6">
                            <label for="assetCode" class="form-label">Asset Code</label>
                            <input type="text" class="form-control" id="assetCode">
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category">
                                <option value="" disabled selected>Select a category</option>
                                <!-- Add options dynamically as needed -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="subsidiary" class="form-label">Subsidiary</label>
                            <select class="form-select" id="subsidiary">
                                <option value="" disabled selected>Select a subsidiary</option>
                                <!-- Add options dynamically as needed -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location">
                        </div>
                        <div class="col-md-6">
                            <label for="estimatedUsefulLife" class="form-label">Estimated Useful Life</label>
                            <input type="text" class="form-control" id="estimatedUsefulLife">
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type">
                                <option value="" disabled selected>Select a type</option>
                                <!-- Add options dynamically as needed -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status">
                                <option value="" disabled selected>Select status</option>
                                <!-- Add options dynamically as needed -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks</label>
                            <input type="text" class="form-control" id="remarks">
                        </div>
                        <div class="col-md-6">
                            <label for="assignedTo" class="form-label">Assigned To</label>
                            <input type="text" class="form-control" id="assignedTo">
                        </div>

                        <!-- Additional Details -->
                        <div class="col-md-6">
                            <label for="serialNumber" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="serialNumber">
                        </div>
                        <div class="col-md-6">
                            <label for="equipmentModel" class="form-label">Equipment Model</label>
                            <input type="text" class="form-control" id="equipmentModel">
                        </div>
                        <div class="col-md-6">
                            <label for="warranty" class="form-label">Warranty</label>
                            <input type="text" class="form-control" id="warranty">
                        </div>
                        <div class="col-md-6">
                            <label for="poNumber" class="form-label">PO Number</label>
                            <input type="text" class="form-control" id="poNumber">
                        </div>
                        <div class="col-md-6">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control" id="brand">
                        </div>
                        <div class="col-md-6">
                            <label for="specifications" class="form-label">Specifications</label>
                            <input type="text" class="form-control" id="specifications">
                        </div>
                        <div class="col-md-6">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="photo">
                        </div>
                        <div class="col-md-6">
                            <label for="assetValue" class="form-label">Asset Value</label>
                            <input type="number" class="form-control" id="assetValue">
                        </div>
                        <div class="col-md-6">
                            <label for="itemCode" class="form-label">Item Code</label>
                            <input type="text" class="form-control" id="itemCode">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>

@endsection