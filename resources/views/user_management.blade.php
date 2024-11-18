@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    <h4 class="mb-4 mt-4">User Management</h4>

    <div class="mb-4">
        <button class="btn btn-primary" id="newUser">Create User</button>
    </div>

    <div class="mb-4">
        <h5>Users</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subsidiary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userList">
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="addUserModal" aria-labelledby="addUserModalLabel" aria-hidden="true" style="z-index: 1600;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        @csrf
                        <div class="form-group">
                            <label for="userName">Name</label>
                            <input type="text" class="form-control" id="userName" placeholder="Enter user name" required>
                        </div>
                        <div class="form-group">
                            <label for="userEmail">Email</label>
                            <input type="email" class="form-control" id="userEmail" placeholder="Enter user email" required>
                        </div>
                        <div class="mb-3">
                            <label for="userSubsidiary" class="form-label">Subsidiary</label>
                            <select class="form-select" id="userSubsidiary" required>
                                <!-- Subsidiary options will be populated dynamically -->
                            </select>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal" aria-labelledby="editUserModalLabel" aria-hidden="true" style="z-index: 1600;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editUserForm">
                            @csrf
                            <input type="hidden" id="editUserId">
                            <div class="form-group">
                                <label for="editUserName">Name</label>
                                <input type="text" class="form-control" id="editUserName" placeholder="Enter user name" required>
                            </div>
                            <div class="form-group">
                                <label for="editUserEmail">Email</label>
                                <input type="email" class="form-control" id="editUserEmail" placeholder="Enter user email" required>
                            </div>
                            <div class="form-group">
                                <label for="editUserPassword">Password</label>
                                <input type="password" class="form-control" id="editUserPassword" placeholder="Enter new password (leave blank to keep current password)">
                                <button type="button" id="togglePasswordVisibility" class="btn btn-link">Show Password</button>
                            </div>
                            <div class="mb-3">
                                <label for="editUserSubsidiary" class="form-label">Subsidiary</label>
                                <select class="form-select" id="editUserSubsidiary" required>
                                    <!-- Subsidiary options will be populated dynamically -->
                                </select>
                            </div>
                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@push('scripts')
    <script src="{{ asset('js/user.js') }}"></script>
@endpush
@endsection
