@extends('layouts.header')
{{-- @section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class='row'>
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Users</h4>
                            <p class="card-description">
                                <form method='get' onsubmit='show();' enctype="multipart/form-data">
                                    <div class=row>
                                        <div class='col-md-12 col-lg-12 col-sm-12'>
                                            <div class="form-group row">
                                                <div class="col-sm-4 col-lg-4 col-md-4 p-0 m-3 ">
                                                    <select data-placeholder="Select Store" class="form-control form-control-sm required js-example-basic-single p-0 " style='width:100%;' name='store' required>
                                                        <option value="">-- Select store --</option>
                                                        @foreach($stores as $store)
                                                        <option value="{{$store->store}}" @if ($store->store == $storeData) selected @endif>{{$store->store}}</option>
                                                        @endforeach
                                                    </select>
                                                    
                                                </div>
                                                <div class="col-sm-4 col-lg-4 col-md-4 p-0" style="margin-left: 3px; margin-top: 18px">
                                                    <button type="button" class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                                                        </svg>
                                                        Search
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </p>
                        </div>
                    </div>
                </div>
                @if(count($personnels) > 0)
                <div class='row'>
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                   
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <td colspan='27'>
                                                    {{$storeData}}
                                                </td>
                                            </tr>
                                            <tr>
                                              <th>Employee Name</th>
                                              <th>View Record</th>
                                            </tr>
                                          </thead>
                                        <tbody>
                                            @foreach($personnels as $key => $employee)
                                                <tr>
                                                    <td>{{$employee->displayName}}</td>
                                                    <td style="width: 20%"> 
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="icon-eye-open icon-white"></i>
                                                            <span><strong>View</strong></span>          
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
  
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('vendors/select2/select2.min.js')}}"></script>
    <script src="{{ asset('js/select2.js')}}"></script>
@endsection --}}

@section('content')
<div class="row mb-3">
    <div class="col-lg-3">
        <div class="card card-tale">
            <div class="card-body">
                <p class="mb-4">Number of Users</p>
                <p class="fs-30 mb-2">0</p>
                <p>as of ({{date('M d Y')}})</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <p class="mb-4">Number of Active Users</p>
                <p class="fs-30 mb-2">0</p>
                <p>as of ({{date('M d Y')}})</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card card-light-danger">
            <div class="card-body">
                <p class="mb-4">Number of Inactive Users</p>
                <p class="fs-30 mb-2">0</p>
                <p>as of ({{date('M d Y')}})</p>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 grid-margin strech-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">User Management</h4>
            <button type="button" class="btn btn-outline-success mb-4" data-toggle="modal" data-target="#newUser">
                <i class="ti-plus"></i>

                Add Users
            </button>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm" id="tableWithSearch">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subsidiary</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#edit{{$user->id}}">
                                        <i class="ti-pencil-alt"></i>
                                    </button>

                                    @if($user->status == 'Inactive')
                                        <form method="POST" action="{{url('activate_user/'.$user->id)}}" class="d-inline" id="activateForm{{$user->id}}" onsubmit="show()">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-success" onclick="activate({{$user->id}})">
                                                <i class="ti-check"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{url('deactivate_user/'.$user->id)}}" class="d-inline" id="deactivateForm{{$user->id}}" onsubmit="show()">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-danger" onclick="deactivate({{$user->id}})">
                                                <i class="ti-na"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                </td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->subsidiary}}</td>
                                <td>{{$user->position}}</td>
                                <td>{{optional($user->department)->name}}</td>
                                <td>
                                    @if($user->status == 'Inactive')
                                    <span class="badge badge-danger"> {{$user->status}} </span>
                                    @else
                                    <span class="badge badge-success"> Active </span>
                                    @endif
                                </td>
                            </tr>

                            @include('users.edit_user')
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('users.new_user')
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
        const table = document.querySelector("#tableWithSearch")
        
        $(table).DataTable({
            dom: 'Bfrtip',
            ordering: true,
            pageLength: 25,
            paging: true,
        });
    })
</script>
@endsection
