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
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInventoryModal" id="addInventory"
                    style="height: 35px; padding: 0 15px; display: flex; align-items: center; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); font-size: 14px;">
                    Add New Inventory
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
                        </th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Date <i class="bi bi-three-dots-vertical"></i></th>
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
                            Action </th>
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
<div class="modal fade" id="modifyModal" tabindex="-1" aria-labelledby="modifyModalLabel" aria-hidden="true">
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
</div>

<!-- Inventory Modal -->
<div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryModalLabel"
    aria-hidden="true" style="z-index: 1400;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInventoryModalLabel">New Inventory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addInventoryForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="dateCreated" class="form-label">Date Created</label>
                            <input type="text" class="form-control" id="dateCreated" value="Auto Generate" readonly style="height: 50%;">
                        </div>
                        <div class="col-md-6">
                            <label for="newItemCode" class="form-label">Item Code</label>
                            <input type="text" class="form-control" id="newItemCode" readonly style="height: 50%;">
                        </div>
                        <div class="col-md-6">
                            <label for="newItemDescription" class="form-label" >Item Description</label>
                            <input type="text" class="form-control" id="newItemDescription" required style="height: 50%;">
                        </div>
                        <div class="col-md-6">
                            <label for="newSubsidiary" class="form-label">Subsidiary</label>
                            <select class="form-select me-3" id="modalSubsidiary" required style="height: 50%;">
                                <option selected value="1">HO</option>
                                <option value="2">WTCC</option>
                                <option value="3">CITI</option>
                                <option value="4">WCC</option>
                                <option value="5">WFA</option>
                                <option value="6">WOI</option>
                                <option value="7">WGC</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="newCategory" class="form-label">Category</label>
                            <div class="input-group">
                                <select class="form-select" id="newCategory" required>
                                    <option value="" disabled selected>Select a category</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="subCategory" class="form-label">Sub-Category</label>
                            <div class="input-group">
                                <select class="form-select" id="subCategory" required>
                                    <option value="" disabled selected>Select a sub-category</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="newPrimaryUOM" class="form-label">Primary UOM</label>
                            <!-- <input type="text" id="primaryUOMSearch" placeholder="Search Primary UOM" class="form-control"> -->
                            <select class="form-select" id="newPrimaryUOM" required></select>
                        </div>

                        <div class="col-md-4">
                            <label for="newSecondaryUOM" class="form-label">Secondary UOM</label>
                            <!-- <input type="text" id="secondaryUOMSearch" placeholder="Search Secondary UOM" class="form-control"> -->
                            <select class="form-select" id="newSecondaryUOM" required></select>
                        </div>

                        <div class="col-md-4">
                            <label for="newTertiaryUOM" class="form-label">Tertiary UOM</label>
                            <!-- <input type="text" id="tertiaryUOMSearch" placeholder="Search Tertiary UOM" class="form-control"> -->
                            <select class="form-select" id="newTertiaryUOM"></select>
                        </div>

                        <div class="col-md-6">
                            <label for="newCost" class="form-label" >Cost</label>
                            <input type="number" class="form-control" id="newCost" required style="height: 50%;">
                        </div>

                        <div class="col-md-6">
                            <label for="newQuantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="newQuantity" required style="height: 50%;">
                        </div>
                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" style="height: 50%" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="newUsage" class="form-label">Usage</label>
                            <input type="number" class="form-control" id="newUsage" value=0 required style="height: 50%">
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

<div class="modal fade" id="tableModal" tabindex="-1" role="dialog" aria-labelledby="tableModalLabel" aria-hidden="true">
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
</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/inventory.js') }}"></script>
@endpush --}}

@extends('layouts.header')

@section('css')
<style>
    .select2-container.select2-container-disabled .select2-choice {
        background-color: #ddd;
        border-color: #a8a8a8;
    }
</style>
@endsection

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
                            <h4 class="mb-4">Transfer</h4>
                            0
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card text-success">
                        <div class="card-body">
                            <h4 class="mb-4">Withdrawal</h4>
                            0
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Inventory List</h4>

                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addInventoryModal">
                        <i class="ti-plus"></i>
                        Add new inventory
                    </button>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="tablewithSearch">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    {{-- <th>ID</th> --}}
                                    <th>Date</th>
                                    <th>Item Code</th>
                                    <th>Item Description</th>
                                    <th>Item Category</th>
                                    <th>QTY</th>
                                    <th>UOM</th>
                                    <th>Cost</th>
                                    <th>Usage</th>
                                    <th>Subsidiary</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventories as $inventory)
                                    <tr>
                                        <td>
                                            <a href={{ url('view_inventory/'.$inventory->inventory_id) }} class="btn btn-sm btn-info">
                                                <i class="ti-eye"></i>
                                            </a>

                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editInventoryModal{{$inventory->inventory_id}}">
                                                <i class="ti-pencil-alt"></i>
                                            </button>
                                            
                                            @if($inventory->status)
                                            <form method="POST" action="{{url('activate_inventory/'.$inventory->inventory_id)}}" class="d-inline-block" id="activateForm{{$inventory->inventory_id}}" onsubmit="show()">
                                                @csrf 

                                                <button type="button" class="btn btn-success btn-sm" onclick="activate({{$inventory->inventory_id}})">
                                                    <i class="ti-check"></i>
                                                </button>
                                            </form>
                                            @else
                                            <form method="POST" action="{{url('deactivate_inventory/'.$inventory->inventory_id)}}" class="d-inline-block" id="deactivateForm{{$inventory->inventory_id}}" onsubmit="show()">
                                                @csrf

                                                <button type="button" class="btn btn-danger btn-sm" onclick="deactivate({{$inventory->inventory_id}})">
                                                    <i class="ti-na"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                        {{-- <td>ID</td> --}}
                                        <td>{{date('M d Y', strtotime($inventory->created_at))}}</td>
                                        <td>{{$inventory->item_code}}</td>
                                        <td>{{$inventory->item_description}}</td>
                                        <td>{{$inventory->category->name}}</td>
                                        <td>{{$inventory->qty}}</td>
                                        <td>{{$inventory->uom->uoms}}</td>
                                        <td>{{$inventory->cost}}</td>
                                        <td>{{$inventory->usage}}</td>
                                        <td>
                                            @foreach ($inventory->inventory_subsidiary as $subsidiary)
                                                {{ $subsidiary->subsidiary->subsidiary_name }} <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($inventory->status)
                                            <span class="badge badge-danger">Deactivate</span>
                                            @else
                                            <span class="badge badge-success">Active</span>
                                            @endif
                                        </td>
                                    </tr>

                                    @include('inventory_list.edit_inventory')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('inventory_list.new_inventory')
@endsection

@section('js')
<script>
    function deactivate(id)
    {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, deactivate it!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deactivateForm'+id).submit()
            }
        });
    }

    function activate(id)
    {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, activate it!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('activateForm'+id).submit()
            }
        });
    }

    $(document).ready(function() {
        $("#tablewithSearch").DataTable({
            dom: 'Bfrtip',
            ordering: false,
            pageLength: 25,
            paging: true,
        });

        $("[name='category']").on('change', function() {
            var value = $(this).val()
            
            $("[name='sub_category']").html("<option value=''>Select a sub-category</option>");
            
            $.ajax({
                type: "POST",
                url: "{{url('refresh_subcategory')}}",
                data: {
                    category_id: value
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $("[name='sub_category']").html(response)
                }
            })
        })
    })
</script>
@endsection