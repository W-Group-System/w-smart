@extends('layouts.header')

@section('content')
<div class="row mb-3">
    <div class="col-lg-3">
        <div class="card card-tale">
            <div class="card-body">
                <p class="mb-4">Number of Department</p>
                <p class="fs-30 mb-2">0</p>
                <p>as of ({{date('M d Y')}})</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <p class="mb-4">Number of Active Department</p>
                <p class="fs-30 mb-2">0</p>
                <p>as of ({{date('M d Y')}})</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card card-light-danger">
            <div class="card-body">
                <p class="mb-4">Number of Inactive Department</p>
                <p class="fs-30 mb-2">0</p>
                <p>as of ({{date('M d Y')}})</p>
            </div>
        </div>
    </div>
</div>

<div class="col-12 grid-margin stretch-card">
    <!-- Main Content Section -->
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Department</h4>

            <button type="button" class="btn btn-outline-success mb-4" data-toggle="modal" data-target="#newDepartmentModal">
                <i class="ti-plus"></i>
                Add New Department
            </button>
            
            <!-- Table Section -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped table-sm" id="tableWithSearch">
                    <thead class="table-light">
                        <tr>
                            <th>Actions</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Department Head</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm text-white" title="Edit" data-toggle="modal" data-target="#edit{{$department->id}}" >
                                        <i class="ti-pencil-alt"></i>
                                    </button>

                                    @if($department->status == 'Active')
                                        <form method="POST" class="d-inline-block" id="deactivateForm{{$department->id}}" action="{{url('settings/deactive-department/'.$department->id)}}" onsubmit="show()">
                                            @csrf 
                                            <button type="button" class="btn btn-danger btn-sm text-white" title="Deactivate" onclick="deactivate({{$department->id}})">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </form>
                                    @else 
                                        <form method="POST" class="d-inline-block" id="activateForm{{$department->id}}" action="{{url('settings/active-department/'.$department->id)}}" onsubmit="show()">
                                            @csrf
                                            <button type="button" class="btn btn-success btn-sm text-white" title="Activate" onclick="activate({{$department->id}})">
                                                <i class="ti-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                <td>{{$department->code}}</td>
                                <td>{{$department->name}}</td>
                                <td>{{$department->subsidiary->subsidiary_name}}</td>
                                <td>{{optional($department->departmentHead)->name}}</td>
                                <td>
                                    @if($department->status == 'Active')
                                    <span class="badge badge-success">Active</span>
                                    @else
                                    <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
    
                            @include('department.edit_department')
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@include('department.new_department')
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

        document.addEventListener("DOMContentLoaded", () => {
            const companyTable = document.querySelector("#tableWithSearch")
            
            $(companyTable).DataTable({
                dom: 'Bfrtip',
                ordering: true,
                pageLength: 25,
                paging: true,
            });
        })
    </script>
@endsection