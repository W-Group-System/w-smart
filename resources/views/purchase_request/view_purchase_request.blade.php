@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    {{-- @include('layouts.procurement_header') --}}

    <!-- Main Content Section -->
    <div class="card p-4 mt-3" style="border: 1px solid #ddd; border-radius: 20px; margin-top: -25px;">
        <div class="d-flex justify-content-between align-items-center">
            <h4>{{str_pad($purchase_request->id, 6, '0', STR_PAD_LEFT)}} - {{$purchase_request->status}}</h4>

            <div>
                {{-- <button>
                    Save    
                </button>
                <button>
                    Save    
                </button> --}}
                <button type="button" class="btn btn-warning text-white" title="Edit" data-bs-toggle="modal" data-bs-target="#editPr{{$purchase_request->id}}">
                    Edit
                </button>
                @if($purchase_request->status == 'For RFQ')
                <button type="button" class="btn btn-info text-white" title="Request for quotation" data-bs-toggle="modal" data-bs-target="#rfq{{$purchase_request->id}}">
                    Request For Quotation (RFQ)
                </button>
                @endif

                @if($purchase_request->status == 'Pending'  && request('origin') == 'for_approval')
                <button type="button" class="btn btn-success text-white" title="Request for quotation" data-bs-toggle="modal" data-bs-target="#view{{$purchase_request->id}}">
                    Approved
                </button>
                @endif

                @if(request('origin') == 'for_approval')
                <a href="{{url('procurement/for-approval-pr')}}" type="button" class="btn btn-danger text-white">
                    Close   
                </a>
                @else
                <a href="{{url('procurement/purchase-request')}}" type="button" class="btn btn-danger text-white">
                    Close   
                </a>
                @endif
            </div>
        </div>

        <p class="h5 mt-4">Primary Information</p>
        <hr class="mt-0">
        <div class="row">
            <div class="col-md-6 mb-2">
                <p class="m-0 fw-bold">Purchase No.:</p>
                {{str_pad($purchase_request->id, 6, '0', STR_PAD_LEFT)}}
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-6 mb-2">
                <p class="m-0 fw-bold">Requestor Name:</p>
                {{$purchase_request->user->name}}
            </div>
            <div class="col-md-6">
                <p class="m-0 fw-bold">Request Date Time:</p>
                {{date('m/d/Y', strtotime($purchase_request->created_at))}}
            </div>
            <div class="col-md-6 mb-2">
                <p class="m-0 fw-bold">Remarks:</p>
                {!! nl2br(e($purchase_request->remarks)) !!}
            </div>
            <div class="col-md-6 mb-2">
                <p class="m-0 fw-bold">Request Due Date:</p>
                {{date('m/d/Y', strtotime($purchase_request->due_date))}}
            </div>
            <div class="col-md-6 mb-2">
                <p class="m-0 fw-bold">Assigned To:</p>
                {{optional($purchase_request->assignedTo)->name}}
            </div>
        </div>

        <p class="h5 mt-4">Classification</p>
        <hr class="mt-0">
        <div class="row">
            <div class="col-md-6 mb-2">
                <p class="m-0 fw-bold">Subsidiary:</p>
                {{$purchase_request->subsidiary}}
            </div>
            <div class="col-md-6 mb-2">
                <p class="m-0 fw-bold">Class:</p>
                
            </div>
            <div class="col-md-6 mb-2">
                <p class="m-0 fw-bold">Department:</p>
                {{$purchase_request->department->name}}
            </div>
            <div class="col-md-6 mb-2">
                <p class="m-0 fw-bold">Return Remarks:</p>
                {!! nl2br(e($purchase_request->return_remarks)) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="padding:5px 10px;">Item Code</th>
                                <th style="padding:5px 10px;">Item Category</th>
                                <th style="padding:5px 10px;">Item Description</th>
                                <th style="padding:5px 10px;">Quantity</th>
                                <th style="padding:5px 10px;">Unit of Measurement</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($purchase_request->purchaseItems->isNotEmpty())
                                @foreach ($purchase_request->purchaseItems as $item)
                                    <tr>
                                        <td style="padding: 5px 10px;">{{$item->inventory->item_code}}</td>
                                        <td style="padding: 5px 10px;">{{$item->inventory->item_category}}</td>
                                        <td style="padding: 5px 10px;">{{$item->inventory->item_description}}</td>
                                        <td style="padding: 5px 10px;">{{number_format($item->inventory->qty,2)}}</td>
                                        <td style="padding: 5px 10px;">{{$item->unit_of_measurement}}</td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="padding:5px 10px;">Attachments</th>
                                <th style="padding:5px 10px;">Document Type</th>
                                <th style="padding:5px 10px;">Remove</th>
                                <th style="padding:5px 10px;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($purchase_request->purchaseRequestFiles->isNotEmpty())
                                @foreach ($purchase_request->purchaseRequestFiles as $file)
                                    <tr>
                                        <td style="padding: 5px 10px;">
                                            <a href="{{url($file->file)}}" target="_blank">
                                                <i class="bi bi-files"></i>
                                            </a>
                                        </td>
                                        <td style="padding: 5px 10px;">{{$file->document_type}}</td>
                                        <td style="padding: 5px 10px;">
                                            <form method="POST" action="{{url('procurement/delete-files/'.$file->id)}}" class="d-inline-block" id="deleteForm{{$file->id}}">
                                                @csrf 

                                                <button type="button" class="btn btn-sm btn-danger text-white" title="Remove File" onclick="removeFiles({{$file->id}})">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td style="padding: 5px 10px;">
                                            <button type="button" class="btn btn-sm btn-warning text-white" title="Edit File" data-bs-toggle="modal" data-bs-target="#editFile{{$file->id}}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    @include('purchase_request.edit_file')
                                @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('purchase_request.edit2_purchase_request')
@include('purchase_request.request_for_quotation')
@include('purchase_request.return_remarks')
@include('purchase_request.view_for_approval')
@endsection

@push('scripts')
<script src="{{ asset('js/purchaseRequest.js') }}"></script>
<script>
    async function getVendorEmail(value)
    {
        let emailDisplay = event.target.closest('tr').querySelector('.vendor_email')
        let hiddenInput = event.target.closest('tr').querySelector("input[name='vendor_email[]']");
        
        if (value != null)
        {
            const response = await axios.post("{{url('refresh_vendor_email')}}", 
                {
                    vendor_id: value
                },
                {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                }
            )
            
            const categorySelect = response.data

            emailDisplay.textContent = ""
            hiddenInput.value = ""
            
            categorySelect.forEach(email => {
                emailDisplay.textContent = email.billing_email
                hiddenInput.value = email.id
            })
            
        }
    }

    function actionFunction(value)
    {
        if (value == 'Returned')
        {
            document.getElementById('returnRemarksCol').removeAttribute('hidden')
            document.getElementById('returnRemarks').setAttribute('required',true)
        }
        else
        {
            document.getElementById('returnRemarksCol').setAttribute('hidden', true)
            document.getElementById('returnRemarks').removeAttribute('required')
        }
    }

    document.addEventListener("DOMContentLoaded", (event) => {
        const addVendorBtn = document.getElementById("addVendorBtn")
        const deleteVendorBtn = document.getElementById("deleteVendorBtn")
        const itemCheckboxAll = document.getElementById("itemCheckboxAll")
        const fileCheckboxAll = document.getElementById('fileCheckboxAll')

        addVendorBtn.addEventListener("click", () => {

            const newRow = document.createElement("tr")
            newRow.innerHTML = `
                <td style="padding: 5px 10px;">
                    <select name="vendor_name[]" class="form-select" onchange="getVendorEmail(this.value)" required>
                        <option value="">Select vendor name</option>
                        @foreach ($suppliers as $key=>$supplier)
                            <option value="{{$supplier->id}}">{{$supplier->corporate_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td style="padding: 5px 10px;">
                    <input type="hidden" name="vendor_email[]">
                    <p class="vendor_email"></p>
                </td>
            `;
            
            document.getElementById("vendorTbodyRow").appendChild(newRow);
        })

        deleteVendorBtn.addEventListener("click", () => {
            const childrenTbodyRow = document.getElementById('vendorTbodyRow').children
            
            if (childrenTbodyRow.length > 1)
            {
                const array = Array.from(childrenTbodyRow)
                array.pop().remove()
            }
        })

        itemCheckboxAll.addEventListener("click", (event) => {
            const isChecked = event.target.checked;
            const getCheckbox = document.querySelectorAll(".itemCheckbox")
            
            getCheckbox.forEach((checkbox) => {
                checkbox.checked = isChecked;
            });
        })

        fileCheckboxAll.addEventListener("click", (event) => {
            const isChecked = event.target.checked
            const getCheckbox = document.querySelectorAll(".fileCheckbox")

            getCheckbox.forEach((checkbox) => {
                checkbox.checked = isChecked
            })
        })
    });
</script>
@endpush