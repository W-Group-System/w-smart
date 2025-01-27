@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
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

    {{-- <div class="mb-4">
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
    </div> --}}
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
</div>

@push('scripts')
    {{-- <script src="{{ asset('js/company.js') }}"></script> --}}
@endpush
@endsection