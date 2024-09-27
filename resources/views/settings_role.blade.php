@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    <h4 class="mb-4">Role and Feature Management</h4>

    <!-- Add Role Section -->
    <div class="mb-4">
        <h5>Add Role</h5>
        <form id="createRoleForm">
            <div class="form-group">
                <label for="role">Role Name</label>
                <input type="text" class="form-control" id="role" name="role" required>
            </div>
            <div class="form-group">
                <label for="features">Assign Features</label>
                <div id="features">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Role</button>
        </form>
    </div>

    <!-- List of Roles -->
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

    <!-- Employee Management -->
    <div class="mb-4">
        <h5>Assign Role to Employee</h5>
        <form id="assignRoleForm">
            <div class="form-group">
                <label for="employee">Employee</label>
                <select id="employee" class="form-control">
                </select>
            </div>
            <div class="form-group">
                <label for="assignRole">Role</label>
                <select id="assignRole" class="form-control">
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Assign Role</button>
        </form>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/roles.js') }}"></script>
@endpush
@endsection