@extends('layouts.dashboard_layout')

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
@endsection