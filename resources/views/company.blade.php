@extends('layouts.header')

@section('content')
{{-- <div class="container-fluid">
    <h4 class="mb-4 mt-4">Company Management</h4>

    <div class="mb-4">
        <div class="card">
            <div class="card-body">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
                    <i class="ti-plus"></i>
                    Create Company
                </button>

                <table class="table table-striped table-bordered table-s, mt-3">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="companyList">
                        @if(count($company) > 0)
                            @foreach ($company as $comp)
                                <tr>
                                    <td class="p-1">
                                        <button type="button" class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#edit{{$comp->subsidiary_id}}">
                                            <i class="ti-pencil-alt"></i>
                                        </button>

                                        <button type="button" class="btn btn-sm btn-danger text-white">
                                            <i class="ti-na"></i>
                                        </button>
                                    </td>
                                    <td class="p-1">{{$comp->subsidiary_name}}</td>
                                    <td class="p-1">{!! nl2br(e($comp->address)) !!}</td>
                                    <td>
                                        @if($comp->status == 'Inactive')
                                            <span class="badge bg-danger">Inactive</span>
                                        @else
                                            <span class="badge bg-success">Active</span>
                                        @endif
                                    </td>
                                </tr>

                                @include('company.edit_company')
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center">No data available.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                {!! $company->links() !!}
            </div>
        </div>
    </div>

    <div class="mb-4">
        <h5>Company</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody id="companyList">
            </tbody>
        </table>
    </div>
<div class="modal fade" id="addCompanyModal" aria-labelledby="addCompanyModalLabel" aria-hidden="true" style="z-index: 1600;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCompanyModalLabel">Add New Company</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addCompanyForm" method="POST" action="{{url('create-company')}}">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="companyName">Company Name</label>
                        <input type="text" class="form-control form-control-sm" name="subsidiary" id="companyName" placeholder="Enter company name" required>
                    </div>
                    <div class="form-group">
                        <label for="companyName">Company Address</label>
                        <textarea name="address" class="form-control" cols="30" rows="10" placeholder="Enter company address" required></textarea>
                    </div>
            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Company</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

{{-- @push('scripts') --}}
    {{-- <script src="{{ asset('js/company.js') }}"></script> --}}
{{-- @endpush --}}

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row mb-3">
            <div class="col-lg-3">
                <div class="card card-tale">
                    <div class="card-body">
                        <p class="mb-4">Number of Company</p>
                        <p class="fs-30 mb-2">0</p>
                        <p>as of ({{date('M d Y')}})</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <p class="mb-4">Number of Active Company</p>
                        <p class="fs-30 mb-2">0</p>
                        <p>as of ({{date('M d Y')}})</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card card-light-danger">
                    <div class="card-body">
                        <p class="mb-4">Number of Inactive Company</p>
                        <p class="fs-30 mb-2">0</p>
                        <p>as of ({{date('M d Y')}})</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Companies</h4>
                    <button type="button" class="btn btn-outline-success mb-4" data-toggle="modal" data-target="#addCompanyModal">
                        <i class="ti-plus"></i>

                        Add Companies
                    </button>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm" id="tableWithSearch">
                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companies as $company)
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#edit{{$company->subsidiary_id}}">
                                                <i class="ti-pencil-alt"></i>
                                            </button>

                                            @if($company->status == 'Inactive')
                                                <form method="POST" action="{{url('activate_company/'.$company->subsidiary_id)}}" class="d-inline" id="activateForm{{$company->subsidiary_id}}">
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="activate({{$company->subsidiary_id}})">
                                                        <i class="ti-check"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{url('deactivate_company/'.$company->subsidiary_id)}}" class="d-inline" id="deactivateForm{{$company->subsidiary_id}}">
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="deactivate({{$company->subsidiary_id}})">
                                                        <i class="ti-na"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                        </td>
                                        <td>{{$company->subsidiary_id}}</td>
                                        <td>{{$company->subsidiary_name}}</td>
                                        <td>{!! nl2br(e($company->address)) !!}</td>
                                        <td>
                                            @if($company->status == 'Inactive')
                                            <span class="badge badge-danger"> {{$company->status}} </span>
                                            @else
                                            <span class="badge badge-success"> Active </span>
                                            @endif
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="edit{{$company->subsidiary_id}}" aria-labelledby="addCompanyModalLabel" aria-hidden="true" style="z-index: 1600;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addCompanyModalLabel">Add New Company</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="addCompanyForm" method="POST" action="{{url('update-company/'.$company->subsidiary_id)}}" onsubmit="show()">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="companyName">Company Name</label>
                                                            <input type="text" class="form-control form-control-sm" name="subsidiary" id="companyName" value="{{$company->subsidiary_name}}" placeholder="Enter company name" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="companyName">Company Address</label>
                                                            <textarea name="address" class="form-control" cols="30" rows="10" placeholder="Enter company address" required>{{$company->address}}</textarea>
                                                        </div>
                                                
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Save Company</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addCompanyModal" aria-labelledby="addCompanyModalLabel" aria-hidden="true" style="z-index: 1600;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCompanyModalLabel">Add New Company</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addCompanyForm" method="POST" action="{{url('create-company')}}" onsubmit="show()">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="companyName">Company Name</label>
                        <input type="text" class="form-control form-control-sm" name="subsidiary" id="companyName" placeholder="Enter company name" required>
                    </div>
                    <div class="form-group">
                        <label for="companyName">Company Address</label>
                        <textarea name="address" class="form-control" cols="30" rows="10" placeholder="Enter company address" required></textarea>
                    </div>
            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Company</button>
                </div>
            </form>
        </div>
    </div>
</div>
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