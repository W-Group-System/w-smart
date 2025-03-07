{{-- @extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    @include('layouts.procurement_header')

    <!-- Main Content Section -->
    <div class="card p-4" style="border: 1px solid #ddd; border-radius: 20px; margin-top: -25px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h6 class="fw-bold me-3"></h6>
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
                <select class="form-select me-3" id="subsidiary"
                    style="width: 150px; height: 35px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); color: #6c757d; border-radius: 25px; font-size: 14px;">
                    <option selected value="1">HO</option>
                    <option value="2">WTCC</option>
                    <option value="3">CITI</option>
                    <option value="4">WCC</option>
                    <option value="5">WFA</option>
                    <option value="6">WOI</option>
                    <option value="7">WGC</option>
                </select>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new" id="addPR"
                    style="height: 35px; padding: 0 15px; display: flex; align-items: center; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); font-size: 14px;">
                    Add PO
                </button>
            </div>

        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="border-collapse: collapse; min-width: 1000px;">
                <thead class="table-light">
                    <tr>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Action<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            PR Number <i class="bi bi-three-dots-vertical"></i>
                        </th>                        
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            GRN Number <i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Status <i class="bi bi-three-dots-vertical"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchase_order as $po)
                        <tr>
                            <td style="text-align: center; padding: 5px 10px;">
                                <a href="{{url('procurement/show_purchase_order/'.$po->id)}}" class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-eye"></i>
                                </a>
                                
                                <button type="button" class="btn btn-sm btn-warning text-white" title="Edit" data-bs-toggle="modal" data-bs-target="#editPurchaseRequest{{$po->id}}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                            <td style="text-align: center; padding: 5px 10px;">{{str_pad($po->purchaseRequest->id,6,'0',STR_PAD_LEFT)}}</td>
                            <td style="text-align: center; padding: 5px 10px;"></td>
                            <td style="text-align: center; padding: 5px 10px;">{{$po->status}}</td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
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
        </div>
    </div>
</div>

@include('purchase_orders.new_purchase_order')

@push('scripts')
<script>
    async function showVendorEmail(value)
    {
        try {
            const response = await axios.post('{{url("refresh_rfq_vendor")}}', 
                {
                    data: value
                },
            )
            const supplier = response.data;
            const categorySelect = document.getElementById('vendorEmail');
            
            categorySelect.innerHTML = '';

            supplier.forEach((email) => {
                const option = document.createElement('option');
                
                option.value = email.id;
                option.text = email.corporate_name+' - '+email.billing_email;
                categorySelect.appendChild(option);
            })
            
        } catch (error) {
            console.error(error);
        }
        
    }
</script>
@endpush
@endsection --}}

@extends('layouts.header')

@section('content')
<div class="row">
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-4">
                                From
                                <input type="date" name="" class="form-control" required>
                            </div>
                            <div class="col-lg-4">
                                To
                                <input type="date" name="" class="form-control" required>
                            </div>
                            <div class="col-lg-4">
                                <button type="button" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-tale">
                    <div class="card-body">
                        <h4 class="mb-4">Pending</h4>
                        0
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card text-success">
                    <div class="card-body">
                        <h4 class="mb-4">RFQ</h4>
                        0
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-4" >
                <div class="card card-light-danger" >
                    <div class="card-body">
                        <h4 class="mb-4">Closed</h4>
                        0
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Purchase Order</h4>

                <button type="button" class="btn btn-outline-success mb-3" data-toggle="modal" data-target="#new" id="addPR">
                    <i class="ti-plus"></i>
                    Add PO
                </button>

                <!-- Table Section -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tablewithSearch">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>PO Number</th>                        
                                <th>GRN Number</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase_order as $po)
                                <tr>
                                    <td>
                                        <a href="{{url('procurement/show_purchase_order/'.$po->id)}}" class="btn btn-sm btn-info">
                                            <i class="ti-eye"></i>
                                        </a>
                                        
                                        {{-- <button type="button" class="btn btn-sm btn-warning" title="Edit" data-toggle="modal" data-target="#editPurchaseRequest{{$po->id}}">
                                            <i class="ti-pencil-alt"></i>
                                        </button> --}}
                                    </td>
                                    <td>{{$po->purchase_order_no}}</td>
                                    <td>{{$po->grn_no}}</td>
                                    <td>{{$po->status}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('purchase_orders.new_purchase_order')

@endsection

@section('js')
<script>
    function showVendorEmail(value)
    {
        // try {
        //     const response = await axios.post('{{url("refresh_rfq_vendor")}}', 
        //         {
        //             data: value
        //         },
        //     )
        //     const supplier = response.data;
        //     const categorySelect = document.getElementById('vendorEmail');
            
        //     categorySelect.innerHTML = '';

        //     supplier.forEach((email) => {
        //         const option = document.createElement('option');
                
        //         option.value = email.id;
        //         option.text = email.corporate_name+' - '+email.billing_email;
        //         categorySelect.appendChild(option);
        //     })
            
        // } catch (error) {
        //     console.error(error);
        // }
        
        $.ajax({
            type: "POST",
            url: "{{url('refresh_rfq_vendor')}}",
            data: {
                data: value
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                $("[name='vendor']").html(response)
            }
        })
    }

    $("#tablewithSearch").DataTable({
        dom: 'Bfrtip',
        ordering: true,
        pageLength: 25,
        paging: true,
    });
</script>
@endsection