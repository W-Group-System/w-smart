{{-- @extends('layouts.dashboard_layout')


@section('dashboard_content')
<div class="container-fluid">
    @include('layouts.procurement_header')

    <div class="card p-4" style="border: 1px solid #ddd; border-radius: 20px; margin-top: -25px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h6 class="fw-bold me-3">Supplier Evaluation List</h6>
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

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEvaluation" id="addSE" style="height: 35px; padding: 0 15px; display: flex; align-items: center; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); font-size: 14px;">Add New Supplier Evaluation</button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered" width="100%" style="border-collapse: collapse">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Action<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Vendor ID<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Vendor Name<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Type<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Product/ Services<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Result<i class="bi bi-three-dots-vertical"></i>
                        </th>
                        <th class="text-center" style="padding: 8px 10px; border: none; font-weight: 400; color: #637281;">Status<i class="bi bi-three-dots-vertical"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($supplier_evaluation as $evaluation)
                    <tr>
                        <td style="text-align: center; padding: 5px 10px;">
                            <a href="{{url('procurement/view_supplier_evalutaion/'.$evaluation->id)}}" class="btn btn-sm btn-info text-white">
                                <i class="bi bi-eye"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-warning text-white" title="Edit" data-bs-toggle="modal" data-bs-target="#editEvaluation{{$evaluation->id}}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        </td>
                        <td>{{ optional($evaluation->code->first())->vendor_code }}</td>
                        <td>{{ $evaluation->name ?? 'N/A' }}</td>
                        <td>{{ $evaluation->type ?? 'N/A' }}</td>
                        <td>{{ $evaluation->product_services ?? 'N/A' }}</td>
                        <td>{{ $evaluation->results->first()->result ?? 'N/A' }}</td>
                        <td>{{ $evaluation->status ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>  
</div>

@include('supplier_evaluation.create')

@foreach ($supplier_evaluation as $evaluation)
@include('supplier_evaluation.edit')
@endforeach

@endsection

@push('scripts')
    <script src="{{ asset('js/supplierEvaluation.js') }}"></script>
@endpush --}}

@extends('layouts.header')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Supplier Evaluation</h4>

                <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addEvaluation">
                    <i class="ti-plus"></i>
                    Add supplier evaluation
                </button>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" width="100%" style="border-collapse: collapse" id="tablewithSearch">
                        <thead>
                            <tr>
                                <th>Action
                                </th>
                                <th>Vendor ID
                                </th>
                                <th>Vendor Name
                                </th>
                                <th>Type
                                </th>
                                <th>Product/ Services
                                </th>
                                <th>Result
                                </th>
                                <th>Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($supplier_evaluation as $evaluation)
                            <tr>
                                <td style="text-align: center; padding: 5px 10px;">
                                    <a href="{{url('procurement/view_supplier_evalutaion/'.$evaluation->id)}}" class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-warning text-white" title="Edit" data-bs-toggle="modal" data-bs-target="#editEvaluation{{$evaluation->id}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </td>
                                <td>{{ optional($evaluation->code->first())->vendor_code }}</td>
                                <td>{{ $evaluation->name ?? 'N/A' }}</td>
                                <td>{{ $evaluation->type ?? 'N/A' }}</td>
                                <td>{{ $evaluation->product_services ?? 'N/A' }}</td>
                                <td>{{ $evaluation->results->first()->result ?? 'N/A' }}</td>
                                <td>{{ $evaluation->status ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('supplier_evaluation.create')
@endsection

@section('js')
    <script src="{{ asset('js/supplierEvaluation.js') }}"></script>
    <script>
        async function getVendorName(value) {
            // Get the input field for the corporate name
            let nameInput = document.getElementById("name");

            // Clear the field if no value is selected
            if (!value) {
                nameInput.value = "";
                return;
            }

            try {
                // Make an AJAX request to fetch the vendor's corporate name
                const response = await axios.post(
                    "{{ url('refresh_vendor_name') }}",
                    { vendor_id: value },
                    {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                    }
                );

                // Update the name field with the corporate name
                if (response.data.corporate_name) {
                    nameInput.value = response.data.corporate_name;
                } else {
                    nameInput.value = "Corporate name not found";
                }
            } catch (error) {
                console.error("Error fetching corporate name:", error);
                nameInput.value = "Error fetching corporate name";
            }
        }
        
        $("#tablewithSearch").DataTable({
            dom: 'Bfrtip',
            ordering: true,
            pageLength: 25,
            paging: true,
        });
    </script>
@endsection