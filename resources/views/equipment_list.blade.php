{{-- @extends('layouts.dashboard_layout')

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
                        <th class="text-center">ID</th>
                        <th class="text-center">Date Purchased</th>
                        <th class="text-center">Asset Name</th>
                        <th class="text-center">Asset Code</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Subsidiary</th>
                        <th class="text-center">Remarks</th>
                        <th class="text-center">Value</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="asset-list">
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <hr>
        <div class="d-flex justify-content-end align-items-center mt-3">
            <div class="d-flex align-items-center me-3">
                <span>Rows per page:</span>
                <select class="form-select form-select-sm d-inline-block w-auto ms-2">
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

<!-- Add Asset Modal -->
<div class="modal fade" id="addAssetModal" tabindex="-1" aria-labelledby="addAssetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAssetModalLabel">Add New Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAssetForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <!-- Date Fields -->
                        <div class="col-md-6">
                            <label for="datePurchased" class="form-label">Date Purchased</label>
                            <input type="date" class="form-control" id="datePurchased" name="date_purchased">
                        </div>
                        <div class="col-md-6">
                            <label for="dateInstallation" class="form-label">Date Installation</label>
                            <input type="date" class="form-control" id="dateInstallation" name="date_installation">
                        </div>
                        <div class="col-md-6">
                            <label for="dateAcquired" class="form-label">Date Acquired</label>
                            <input type="date" class="form-control" id="dateAcquired" name="date_acquired">
                        </div>
                        <div class="col-md-6">
                            <label for="dateTransferred" class="form-label">Date Transferred</label>
                            <input type="date" class="form-control" id="dateTransferred" name="date_transferred">
                        </div>
                        <div class="col-md-6">
                            <label for="dateRepaired" class="form-label">Date Repaired</label>
                            <input type="date" class="form-control" id="dateRepaired" name="date_repaired">
                        </div>

                        <!-- General Asset Information -->
                        <div class="col-md-6">
                            <label for="assetCode" class="form-label">Asset Code</label>
                            <input type="text" class="form-control" id="assetCode" name="asset_code" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="assetName" class="form-label">Asset Name</label>
                            <input type="text" class="form-control" id="assetName" name="asset_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category">
                                <option value="" disabled selected>Select a category</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="subsidiary" class="form-label">Subsidiary</label>
                            <select class="form-select" id="subsidiaryModal">
                                <option value="" disabled selected>Select a subsidiary</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location">
                        </div>
                        <div class="col-md-6">
                            <label for="estimatedUsefulLife" class="form-label">Estimated Useful Life</label>
                            <input type="text" class="form-control" id="estimatedUsefulLife"
                                name="estimated_useful_life">
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="" disabled selected>Select a type</option>
                                <option value="Capitalized">Capitalized</option>
                                <option value="Non-Capitalized">Non-Capitalized</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="" disabled selected>Select status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive (Repair)">Inactive (Repair)</option>
                                <option value="Disposed">Disposed</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks</label>
                            <input type="text" class="form-control" id="remarks" name="remarks">
                        </div>
                        <div class="col-md-6">
                            <label for="assignedTo" class="form-label">Assigned To</label>
                            <input type="text" class="form-control" id="assignedTo" name="assigned_to">
                        </div>

                        <!-- Additional Details -->
                        <div class="col-md-6">
                            <label for="serialNumber" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="serialNumber" name="serial_number">
                        </div>
                        <div class="col-md-6">
                            <label for="equipmentModel" class="form-label">Equipment Model</label>
                            <input type="text" class="form-control" id="equipmentModel" name="equipment_model">
                        </div>
                        <div class="col-md-6">
                            <label for="warranty" class="form-label">Warranty (Months)</label>
                            <input type="text" class="form-control" id="warranty" name="warranty">
                        </div>
                        <div class="col-md-6">
                            <label for="poNumber" class="form-label">PO Number</label>
                            <input type="text" class="form-control" id="poNumber" name="po_number">
                        </div>
                        <div class="col-md-6">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control" id="brand" name="brand">
                        </div>
                        <div class="col-md-6">
                            <label for="specifications" class="form-label">Specifications</label>
                            <input type="text" class="form-control" id="specifications" name="specifications">
                        </div>
                        <div class="col-md-6">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo">
                        </div>
                        <div class="col-md-6">
                            <label for="assetValue" class="form-label">Asset Value</label>
                            <input type="number" class="form-control" id="assetValue" name="asset_value" value="0">
                        </div>
                        <div class="col-md-6">
                            <label for="itemCode" class="form-label">Item Code</label>
                            <input type="text" class="form-control" id="itemCode" name="item_code">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="saveAssetButton">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- View Asset Modal -->
<div class="modal fade" id="viewAssetModal" tabindex="-1" aria-labelledby="viewAssetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewAssetModalLabel">Asset Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="viewAssetForm">
                    <div class="row g-3">
                        <!-- Date Fields -->
                        <div class="col-md-6">
                            <label for="datePurchased" class="form-label">Date Purchased</label>
                            <input type="date" class="form-control" id="viewDatePurchased" name="date_purchased"
                                disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="dateInstallation" class="form-label">Date Installation</label>
                            <input type="date" class="form-control" id="viewDateInstallation" name="date_installation"
                                disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="dateAcquired" class="form-label">Date Acquired</label>
                            <input type="date" class="form-control" id="viewDateAcquired" name="date_acquired" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="dateTransferred" class="form-label">Date Transferred</label>
                            <input type="date" class="form-control" id="viewDateTransferred" name="date_transferred"
                                disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="dateRepaired" class="form-label">Date Repaired</label>
                            <input type="date" class="form-control" id="viewDateRepaired" name="date_repaired" disabled>
                        </div>

                        <!-- General Asset Information -->
                        <div class="col-md-6">
                            <label for="assetCode" class="form-label">Asset Code</label>
                            <input type="text" class="form-control" id="viewAssetCode" name="asset_code" readonly
                                disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="assetName" class="form-label">Asset Name</label>
                            <input type="text" class="form-control" id="viewAssetName" name="asset_name" required
                                disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="viewCategory" name="category" required
                                disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="subsidiary" class="form-label">Subsidiary</label>
                            <input type="text" class="form-control" id="viewSubsidiary" name="subsidiary" required
                                disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="viewLocation" name="location" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="estimatedUsefulLife" class="form-label">Estimated Useful Life</label>
                            <input type="text" class="form-control" id="viewEstimatedUsefulLife"
                                name="estimated_useful_life" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="viewType" name="type" disabled>
                                <option value="Capitalized">Capitalized</option>
                                <option value="Non-Capitalized">Non-Capitalized</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="viewStatus" name="status" disabled>
                                <option value="Active">Active</option>
                                <option value="Inactive (Repair)">Inactive (Repair)</option>
                                <option value="Disposed">Disposed</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks</label>
                            <input type="text" class="form-control" id="viewRemarks" name="remarks" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="assignedTo" class="form-label">Assigned To</label>
                            <input type="text" class="form-control" id="viewAssignedTo" name="assigned_to" disabled>
                        </div>

                        <!-- Additional Details -->
                        <div class="col-md-6">
                            <label for="serialNumber" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="viewSerialNumber" name="serial_number" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="equipmentModel" class="form-label">Equipment Model</label>
                            <input type="text" class="form-control" id="viewEquipmentModel" name="equipment_model"
                                disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="warranty" class="form-label">Warranty (Months)</label>
                            <input type="text" class="form-control" id="viewWarranty" name="warranty" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="poNumber" class="form-label">PO Number</label>
                            <input type="text" class="form-control" id="viewPONumber" name="po_number" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control" id="viewBrand" name="brand" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="specifications" class="form-label">Specifications</label>
                            <input type="text" class="form-control" id="viewSpecifications" name="specifications"
                                disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="viewPhoto" name="photo" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="assetValue" class="form-label">Asset Value</label>
                            <input type="number" class="form-control" id="viewAssetValue" name="asset_value" value="0"
                                disabled>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/equipment_list.js') }}"></script>
@endsection --}}

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

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Asset List</h4>
                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addAssetModal">
                        <i class="ti-plus"></i>
                        Add new asset
                    </button>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tablewithSearch">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Date Purchased</th>
                                    <th>Asset Name</th>
                                    <th>Asset Code</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Subsidiary</th>
                                    <th>Remarks</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($equipments as $equipment)
                                <tr>
                                    <td>
                                        <a href="{{url('view_asset_list/'.$equipment->id)}}" class="btn btn-sm btn-info">
                                            <i class="ti-eye"></i>
                                        </a>

                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editAssetModal{{$equipment->id}}">
                                            <i class="ti-pencil-alt"></i>
                                        </button>
                                    </td>
                                    <td>{{date('M d Y', strtotime($equipment->date_purchased))}}</td>
                                    <td>{{$equipment->asset_name}}</td>
                                    <td>{{$equipment->asset_code}}</td>
                                    <td>{{$equipment->type}}</td>
                                    <td>{{$equipment->category->name}}</td>
                                    <td>{{$equipment->status}}</td>
                                    <td>{{$equipment->subsidiary->subsidiary_name}}</td>
                                    <td>{!! nl2br(e($equipment->remarks)) !!}</td>
                                    <td>{{$equipment->asset_value}}</td>
                                </tr>

                                @include('asset_list.edit_asset_list')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('asset_list.new_asset_list')
@endsection

@section('js')
    <script>
        $("#tablewithSearch").DataTable({
            dom: 'Bfrtip',
            ordering: true,
            pageLength: 25,
            paging: true,
        });
    </script>
@endsection