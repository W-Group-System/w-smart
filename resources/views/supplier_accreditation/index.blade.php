{{-- @extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    @include('layouts.procurement_header')

    <!-- Main Content Section -->
    <div class="card p-4" style="border: 1px solid #ddd; border-radius: 20px; margin-top: -25px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h6 class="fw-bold me-3">Supplier Accreditation List</h6>
                <input type="hidden" id="userId" value="{{ auth()->user()->id }}">
                <input type="hidden" id="userName" value="{{ auth()->user()->name }}">
                <input type="hidden" id="usersubsidiary" value="{{ auth()->user()->subsidiary }}">
                <input type="hidden" id="usersubsidiaryid" value="{{ auth()->user()->subsidiaryid }}">
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
                <!-- <select class="form-select me-3" id="subsidiary"
                    style="width: 150px; height: 35px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); color: #6c757d; border-radius: 25px; font-size: 14px;">
                    <option selected value="1">HO</option>
                    <option value="2">WTCC</option>
                    <option value="3">CITI</option>
                    <option value="4">WCC</option>
                    <option value="5">WFA</option>
                    <option value="6">WOI</option>
                    <option value="7">WGC</option>
                </select> -->

                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPurchaseRequest" id="addPR"
                    style="height: 35px; padding: 0 15px; display: flex; align-items: center; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); font-size: 14px;">
                    Add New Supplier Accreditation
                </button> -->
                <a href="{{ url('supplier_accreditation/create') }}" class="text-decoration-none" id="newAccreditation"><button class="btn btn-primary" style="height: 35px; padding: 0 15px; display: flex; align-items: center; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); font-size: 14px;">Add New Supplier Accreditation</button></a>
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered" width="100%" style="border-collapse: collapse">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Action<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Vendor ID<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Relationship<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Name<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Telephone No.<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Trade Name<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Years in Business<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Nature of Business<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">SEC/DTI Registration No.<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Date Registered<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Status<i class="bi bi-three-dots-vertical"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($supplier_accreditation as $accreditation)
                    <tr>
                        <td style="text-align: center; padding: 5px 10px;">
                            <a href="{{url('procurement/view_supplier_accreditation/'.$accreditation->id)}}" class="btn btn-sm btn-info text-white">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ url('procurement/edit_supplier_accreditation/' . $accreditation->id) }}" class="btn btn-sm btn-warning text-white">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                        <td>{{ $accreditation->vendor_code }}</td>
                        <td>
                            @if($accreditation->relationship == 1)
                                Tenant/ Lease
                            @elseif($accreditation->relationship == 2)
                                Supplier
                            @elseif($accreditation->relationship == 3)
                                Service Provider   
                            @elseif($accreditation->relationship == 4)
                                Others 
                            @else 
                                N/A
                            @endif
                        </td>
                        <td>{{ $accreditation->corporate_name }}</td>
                        <td>{{ $accreditation->telephone_no ?? 'N/A' }}</td>
                        <td>{{ $accreditation->trade_name ?? 'N/A' }}</td>
                        <td>{{ $accreditation->trade_name ?? 'N/A' }}</td>
                        <td>{{ $accreditation->nature_business ?? 'N/A' }}</td>
                        <td>{{ $accreditation->registration_no ?? 'N/A' }}</td>
                        <td>{{ $accreditation->date_registered ? date('m/d/Y', strtotime($accreditation->date_registered)) : 'N/A' }}</td>
                        <td>{{ $accreditation->status }}</td>
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
            <div class="me-3 dynamic-rows-info">{{$supplier_accreditation->firstItem()}}-{{$supplier_accreditation->lastItem()}} of {{$supplier_accreditation->total()}}</div>
            {!! $supplier_accreditation->links() !!}
        </div> 
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/supplierAccreditation.js') }}"></script>
@endpush --}}

@extends('layouts.header')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Supplier Accreditation</h4>
                
                <a href="{{ url('supplier_accreditation/create') }}" class="text-decoration-none btn btn-outline-success" id="newAccreditation">
                    <i class="ti-plus"></i>
                    Add New Supplier Accreditation
                </a>

                <div class="table-responsive mt-3">
                    <table class="table table-hover table-bordered" id="tablewithSearch">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Vendor ID</th>
                                <th>Relationship</th>
                                <th>Name</th>
                                <th>Telephone No.</th>
                                <th>Trade Name</th>
                                <th>Years in Business</th>
                                <th>Nature of Business</th>
                                <th>SEC/DTI Registration No.</th>
                                <th>Date Registered</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($supplier_accreditation as $accreditation)
                            <tr>
                                <td style="text-align: center; padding: 5px 10px;">
                                    <a href="{{url('procurement/view_supplier_accreditation/'.$accreditation->id)}}" class="btn btn-sm btn-info">
                                        <i class="ti-eye"></i>
                                    </a>
                                    <a href="{{ url('procurement/edit_supplier_accreditation/' . $accreditation->id) }}" class="btn btn-sm btn-warning">
                                        <i class="ti-pencil-alt"></i>
                                    </a>
                                </td>
                                <td>{{ $accreditation->vendor_code }}</td>
                                <td>
                                    @if($accreditation->relationship == 1)
                                        Tenant/ Lease
                                    @elseif($accreditation->relationship == 2)
                                        Supplier
                                    @elseif($accreditation->relationship == 3)
                                        Service Provider   
                                    @elseif($accreditation->relationship == 4)
                                        Others 
                                    @else 
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $accreditation->corporate_name }}</td>
                                <td>{{ $accreditation->telephone_no ?? 'N/A' }}</td>
                                <td>{{ $accreditation->trade_name ?? 'N/A' }}</td>
                                <td>{{ $accreditation->trade_name ?? 'N/A' }}</td>
                                <td>{{ $accreditation->nature_business ?? 'N/A' }}</td>
                                <td>{{ $accreditation->registration_no ?? 'N/A' }}</td>
                                <td>{{ $accreditation->date_registered ? date('m/d/Y', strtotime($accreditation->date_registered)) : 'N/A' }}</td>
                                <td>{{ $accreditation->status }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{asset('js/supplierAccreditation.js')}}"></script>
<script>
    $("#tablewithSearch").DataTable({
        dom: 'Bfrtip',
        ordering: true,
        pageLength: 25,
        paging: true,
    });
</script>
@endsection