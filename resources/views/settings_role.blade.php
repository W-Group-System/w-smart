{{-- @extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    <h4 class="mb-4 mt-4">Role and Feature Management</h4>

    <div class="mb-4">
        <button class="btn btn-primary" id="createRoleBtn">Create Role</button>
        <button class="btn btn-primary" id="assignRoleBtn">Assign Roles</button>
    </div>

    <div class="mb-4">
        <h5>Roles</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Features</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="roleList">
            </tbody>
        </table>
    </div>

    <div class="mb-4">
        <h5>List of Users</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody id="userList">
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoleModalLabel">Add Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createRoleForm">
                        <div class="form-group">
                            <label for="role">Role Name</label>
                            <input type="text" class="form-control" id="role" name="role" required>
                        </div>
                        <div class="form-group">
                            <label for="features">Assign Features</label>
                            <div id="features"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="createRoleForm">Create Role</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="assignRoleModal" tabindex="-1" aria-labelledby="assignRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignRoleModalLabel">Assign Role to Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="assignRoleForm">
                        <div class="form-group">
                            <label for="employee">Employee</label>
                            <select id="employee" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label for="assignRole">Role</label>
                            <select id="assignRole" class="form-control"></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="assignRoleForm">Assign Role</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="transferRoleModal" tabindex="-1" aria-labelledby="transferRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transferRoleModalLabel">Transfer Users to Another Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>There are users in the role you are trying to delete. Please transfer them to another role.</p>

                    <ul id="affectedUsers" class="list-group mb-3">
                    </ul>

                    <form id="transferRoleForm">
                        <div class="form-group">
                            <label for="transferRole">Select New Role</label>
                            <select id="transferRole" class="form-control"></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" form="transferRoleForm">Confirm Transfer</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script src="{{ asset('js/roles.js') }}"></script>
@endpush
@endsection --}}

@extends('layouts.header')

@section('content')
    <div class="col-lg-12 grid-margin strech-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Role and Feature Management</h4>
                <div class="mb-4">
                    <button class="btn btn-outline-primary" data-toggle="modal" data-target="#createRoleModal">
                        <i class="ti-plus"></i>
                        Create Role
                    </button>
                    <button class="btn btn-outline-primary" data-toggle="modal" data-target="#assignRoleModal">
                        <i class="ti-plus"></i>
                        Assign Roles
                    </button>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered tableWithSearch">
                                <thead>
                                    <tr>
                                        <th>Actions</th>
                                        <th>Role</th>
                                        <th>Features</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editRole{{$role->id}}">
                                                    <i class="ti-pencil-alt"></i>
                                                </button>

                                                @if($role->status == 'Inactive')
                                                    <form method="POST" action="{{url('activate_role/'.$role->id)}}" class="d-inline-block" id="activateForm{{$role->id}}" onsubmit="show()">
                                                        @csrf 

                                                        <button type="button" class="btn btn-sm btn-success" onclick="activate({{$role->id}})">
                                                            <i class="ti-check"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{url('deactivate_role/'.$role->id)}}" class="d-inline-block" id="deactivateForm{{$role->id}}" onsubmit="show()">
                                                        @csrf 

                                                        <button type="button" class="btn btn-sm btn-danger" onclick="deactivate({{$role->id}})">
                                                            <i class="ti-na"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                            </td>
                                            <td>{{$role->role}}</td>
                                            <td>
                                                @foreach($role->permission as $key=>$permission)
                                                    {{$key+1}}. {{$permission->feature->feature}} <br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if($role->status == 'Inactive')
                                                <div class="badge badge-danger">Inactive</div>
                                                @else
                                                <div class="badge badge-success">Active</div>
                                                @endif  
                                            </td>
                                        </tr>

                                        @include('roles_and_permissions.edit_role')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered tableWithSearch">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody id="userList">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('roles_and_permissions.new_role')
    @include('roles_and_permissions.assign_role')
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
        const tables = document.querySelectorAll(".tableWithSearch")

        tables.forEach((table) => {
            $(table).DataTable({
                dom: 'Bfrtip',
                ordering: true,
                pageLength: 25,
                paging: true,
            });
        })
        
    })
</script>
@endsection