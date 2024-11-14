@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    <h4 class="mb-4 mt-4">Company Management</h4>

    <div class="mb-4">
        <button class="btn btn-primary" id="newCompany">Create Company</button>
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
            <div class="modal-body">
                <form id="addCompanyForm">
                    @csrf
                    <div class="form-group">
                        <label for="companyName">Company Name</label>
                        <input type="text" class="form-control" id="companyName" placeholder="Enter company name" required>
                    </div>
            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Company</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/company.js') }}"></script>
@endpush
@endsection