{{-- @extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    @include('layouts.equipment_header')

    <!-- Main Content Section -->
    <div class="card p-4" style="border: 1px solid #ddd; border-radius: 20px; margin-top: -25px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h6 class="fw-bold me-3">Disposal Asset List</h6>
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
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDisposalModal"
                    id="addDisposal"
                    style="height: 35px; padding: 0 15px; display: flex; align-items: center; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); font-size: 14px;">
                    Asset Disposal
                </a>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="border-collapse: collapse; min-width: 1000px;">
                <thead class="table-light">
                    <tr>
                        <th class="text-center"
                            style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Asset Name</th>
                        <th class="text-center"
                            style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Asset Code</th>
                        <th class="text-center"
                            style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Date Acquired
                        </th>
                        <th class="text-center"
                            style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Type</th>
                        <th class="text-center"
                            style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Category</th>
                        <th class="text-center"
                            style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Status</th>
                        <th class="text-center"
                            style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Subsidiary</th>
                        <th class="text-center"
                            style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Remarks</th>
                        <th class="text-center"
                            style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Action</th>
                    </tr>
                </thead>
                <tbody>
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
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Disposal Modal -->
<div class="modal fade" id="addDisposalModal" tabindex="-1" aria-labelledby="addDisposalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDisposalModalLabel">Disposal of Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addDisposalForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="requestedBy" class="form-label">Requested By</label>
                            <input type="text" class="form-control" id="requestedBy" required>
                        </div>
                        <div class="col-md-6">
                            <label for="transferFrom" class="form-label">Transfer From</label>
                            <input type="text" class="form-control" id="transferFrom" required>
                        </div>
                        <div class="col-md-6">
                            <label for="transferTo" class="form-label">Transfer To</label>
                            <input type="text" class="form-control" id="transferTo" required>
                        </div>
                        <div class="col-md-6">
                            <label for="purpose" class="form-label">Purpose</label>
                            <input type="text" class="form-control" id="purpose" required>
                        </div>
                        <div class="col-md-6">
                            <label for="dateOfTransfer" class="form-label">Date of Transfer</label>
                            <input type="date" class="form-control" id="dateOfTransfer" required>
                        </div>
                        <div class="col-md-6">
                            <label for="assetName" class="form-label">Asset Name</label>
                            <input type="text" class="form-control" id="assetName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="assetCode" class="form-label">Asset Code</label>
                            <input type="text" class="form-control" id="assetCode" required>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-primary" id="viewSpecsButton"
                                style="width: 100%;">View Specs</button>
                        </div>
                        <div class="col-md-6">
                            <label for="approver" class="form-label">Approver</label>
                            <select class="form-select" id="approver" required>
                                <option value="" disabled selected>Select Approver</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks</label>
                            <input type="text" class="form-control" id="remarks">
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="photo">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </div>
</div>
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
                    <h4 class="card-title">Disposal Asset</h4>
                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addAssetModal">
                        <i class="ti-plus"></i>
                        Add disposal asset
                    </button>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tablewithSearch">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Asset Name</th>
                                    <th>Asset Code</th>
                                    <th>Date Acquired</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Subsidiary</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($equipments as $equipment)
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
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('asset_list.new_asset_list') --}}
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