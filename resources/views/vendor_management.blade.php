{{-- @extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">

    <div class="card p-4" style="border: 1px solid #ddd; border-radius: 20px; margin-top: 25px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h6 class="fw-bold me-3">Vendors</h6>
                
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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVendor" id="addPR"
                    style="height: 35px; padding: 0 15px; display: flex; align-items: center; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); font-size: 14px;">
                    Add New Vendor
                </button>
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="border-collapse: collapse; min-width: 1000px;">
                <thead class="table-light">
                    <tr>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Action<i class="bi bi-three-dots-vertical"></i></th>
                        </th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Vendor Code <i class="bi bi-three-dots-vertical"></i></th>
                        </th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Vendor Name <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Address <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Email <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Contact No. <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Category <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Date Created <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Date Modified <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Vendor Status <i class="bi bi-three-dots-vertical"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vendors as $vendor)
                            <tr>
                                <td style="text-align: center; padding: 5px 10px;">
                                    <a href="{{url('settings/view_vendor/'.$vendor->id)}}" class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    
                                    <button type="button" class="btn btn-sm btn-warning text-white" title="Edit" data-bs-toggle="modal" data-bs-target="#editVendor{{$vendor->id}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </td>
                                <td>{{ optional($vendor)->vendor_code }}</td>
                                <td>{{ optional($vendor->vendorSupplier)->corporate_name }}</td>
                                <td>
                                    {{ optional($vendor->vendorSupplier)->business_address }} <br>
                                    {{ optional($vendor->vendorSupplier)->billing_address }}
                                </td>
                                <td>
                                    @foreach ($vendor->vendorContact as $contact)
                                        <div>{{ optional($contact)->email }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($vendor->vendorContact as $contact)
                                        <div>{{ optional($contact)->contact }}</div>
                                    @endforeach
                                </td>
                                <td>{{ optional($vendor->vendorCategory)->name }}</td>
                                <td>{{ optional($vendor)->created_at }}</td>
                                <td>{{ optional($vendor)->updated_at }}</td>
                                <td>{{ optional($vendor)->vendor_status }}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

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
            <div class="me-3 dynamic-rows-info">{{$vendors->firstItem()}}-{{$vendors->lastItem()}} of {{$vendors->total()}}</div>
            {!! $vendors->links() !!}
        </div>
    </div>
</div>

@foreach ($vendors as $vendor)
@include('vendor_management.edit_vendor')
@endforeach

@include('vendor_management.new_vendor')
@endsection

@push('scripts')
    <script src="{{ asset('js/vendorManagement1.js') }}"></script>

    <script>
        
        function vendorNameSelect(value)
        {
            $.ajax({
                type: "POST",
                url: "{{route('refreshVendorCode')}}",
                data: {
                    id: value
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    
                    document.getElementById('vendor-Code').value = data.vendor_code;
                    document.getElementById('billing-Tin').value = data.billing_tin;
                }
            })
        }

    </script>
@endpush --}}

@extends('layouts.header')

@section('content')
<div class="row mb-3">
    <div class="col-lg-3">
        <div class="card card-tale">
            <div class="card-body">
                <p class="mb-4">Number of Vendor</p>
                <p class="fs-30 mb-2">0</p>
                <p>as of ({{date('M d Y')}})</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <p class="mb-4">Number of Active Vendor</p>
                <p class="fs-30 mb-2">0</p>
                <p>as of ({{date('M d Y')}})</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card card-light-danger">
            <div class="card-body">
                <p class="mb-4">Number of Inactive Vendor</p>
                <p class="fs-30 mb-2">0</p>
                <p>as of ({{date('M d Y')}})</p>
            </div>
        </div>
    </div>
</div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Vendors</h4>
                <button type="button" class="btn btn-outline-success mb-4" data-toggle="modal" data-target="#addVendor">
                    <i class="ti-plus"></i>
                    Add New Vendor
                </button>

                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered" id="tableWithSearch">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Vendor Code</th>
                                <th>Vendor Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Contact No.</th>
                                <th>Category</th>
                                <th>Date Created</th>
                                <th>Date Modified</th>
                                <th>Vendor Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendors as $vendor)
                                <tr>
                                    <td>
                                        <a href="{{url('settings/view_vendor/'.$vendor->id)}}" class="btn btn-sm btn-info text-white">
                                            <i class="ti-eye"></i>
                                        </a>
                                        
                                        <button type="button" class="btn btn-sm btn-warning text-white" title="Edit" data-toggle="modal" data-target="#editVendor{{$vendor->id}}">
                                            <i class="ti-pencil-alt"></i>
                                        </button>
                                    </td>
                                    <td>{{ optional($vendor)->vendor_code }}</td>
                                    <td>{{ optional($vendor->vendorSupplier)->corporate_name }}</td>
                                    <td>
                                        {!! nl2br(e(optional($vendor->vendorSupplier)->business_address)) !!}
                                        {{-- <br>
                                        <br> --}}
                                        <hr>
                                        {!! nl2br(e(optional($vendor->vendorSupplier)->billing_address)) !!}
                                    </td>
                                    <td>
                                        @foreach ($vendor->vendorContact as $contact)
                                            <div>{{ optional($contact)->email }}</div> <hr>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($vendor->vendorContact as $contact)
                                            <div>{{ optional($contact)->contact }}</div> <hr>
                                        @endforeach
                                    </td>
                                    <td>{{ optional($vendor->vendorCategory)->name }}</td>
                                    <td>{{ date('M d Y', strtotime($vendor->created_at)) }}</td>
                                    <td>{{ date('M d Y', strtotime($vendor->updated_at)) }}</td>
                                    <td>{{ optional($vendor)->vendor_status }}</td>
                                </tr>

                                @include('vendor_management.edit_vendor')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('vendor_management.new_vendor')
@endsection

@section('js')
<script src="{{ asset('js/vendorManagement1.js') }}"></script>

<script>
    
    function vendorNameSelect(value)
    {
        $.ajax({
            type: "POST",
            url: "{{route('refreshVendorCode')}}",
            data: {
                id: value
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                
                document.getElementById('vendor-Code').value = data.vendor_code;
                document.getElementById('billing-Tin').value = data.billing_tin;
            }
        })
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