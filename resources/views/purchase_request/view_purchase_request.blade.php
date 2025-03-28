{{-- @extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    <!-- Main Content Section -->
    <div class="card p-4 mt-3" style="border: 1px solid #ddd; border-radius: 20px; margin-top: -25px;">
        <div class="d-flex justify-content-between align-items-center">
            <h4>{{str_pad($purchase_request->id, 6, '0', STR_PAD_LEFT)}} - {{$purchase_request->status}}</h4>

            <div>
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

--}}

@extends('layouts.header')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{str_pad($purchase_request->id, 6, '0', STR_PAD_LEFT)}} - {{$purchase_request->status}}</h4>
        
                    <div>
                        @if(auth()->user()->role == 1 && $purchase_request->status == 'Pending')
                        <button type="button" class="btn btn-outline-warning" title="Edit" data-toggle="modal" data-target="#editPr{{$purchase_request->id}}">
                            <i class="ti-check"></i>
                            Assign
                        </button>
                        @endif
                        @if($purchase_request->status == 'For RFQ' && auth()->user()->id == $purchase_request->user_id)
                        <button type="button" class="btn btn-outline-info" title="Request for quotation" data-toggle="modal" data-target="#rfq{{$purchase_request->id}}">
                            <i class="ti-receipt"></i>
                            Request For Quotation (RFQ)
                        </button>
                        @endif
        
                        {{-- @if($purchase_request->status == 'Pending'  && request('origin') == 'for_approval') --}}
                        @if($purchase_request->assigned_to)
                            @foreach ($purchase_request->purchaseRequestApprovers->where('status', 'Pending')->where('user_id', auth()->user()->id) as $pr_approver)
                            <button type="button" class="btn btn-outline-success" title="Request for quotation" data-toggle="modal" data-target="#view{{$purchase_request->id}}">
                                <i class="ti-control-play"></i>
                                Action
                            </button>
                            @endforeach
                        @endif
                        {{-- @endif --}}
        
                        @if(request('origin') == 'for_approval')
                        <a href="{{url('procurement/for-approval-pr')}}" type="button" class="btn btn-outline-secondary">
                            <i class="ti-arrow-left"></i>
                            Back   
                        </a>
                        @else
                        <a href="{{url('procurement/purchase-request')}}" type="button" class="btn btn-outline-secondary">
                            <i class="ti-arrow-left"></i>
                            Back   
                        </a>
                        @endif
                    </div>
                </div>

                <h4 class="card-title">Primary Information</h4>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right">
                                Purchase No. :
                            </dt>
                            <dd class="col-sm-9">
                                {{str_pad($purchase_request->id, 6, '0', STR_PAD_LEFT)}}
                            </dd>
                            <dt class="col-sm-3 text-right">
                                Request Date Time :
                            </dt>
                            <dd class="col-sm-9">
                                {{date('m/d/Y', strtotime($purchase_request->created_at))}}
                            </dd>
                            <dt class="col-sm-3 text-right">
                                Request Due Date :
                            </dt>
                            <dd class="col-sm-9">
                                {{date('m/d/Y', strtotime($purchase_request->due_date))}}
                            </dd>
                        </dl>
                    </div>
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right">Requestor Name :</dt>
                            <dd class="col-sm-9">{{$purchase_request->user->name}}</dd>
                            <dt class="col-sm-3 text-right">Remarks :</dt>
                            <dd class="col-sm-9">{!! nl2br(e($purchase_request->remarks)) !!}</dd>
                            <dt class="col-sm-3 text-right">Assigned To :</dt>
                            <dd class="col-sm-9">{{optional($purchase_request->assignedTo)->name}}</dd>
                        </dl>
                    </div>
                </div>

                <h4 class="card-title">Classification</h4>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right">Subsidiary :</dt>
                            <dd class="col-sm-9">{{$purchase_request->subsidiary}}</dd>
                            <dt class="col-sm-3 text-right">Department :</dt>
                            <dd class="col-sm-9">{{$purchase_request->department->name}}</dd>
                        </dl>
                    </div>
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right">Class :</dt>
                            <dd class="col-sm-9">&nbsp;</dd>
                            <dt class="col-sm-3 text-right">Remarks</dt>
                            <dd class="col-sm-9">{!! nl2br(e($purchase_request->return_remarks)) !!}</dd>
                        </dl>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Item Code</th>
                                        <th>Item Category</th>
                                        <th>Item Description</th>
                                        <th>Quantity</th>
                                        <th>Unit of Measurement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($purchase_request->purchaseItems->isNotEmpty())
                                        @foreach ($purchase_request->purchaseItems as $item)
                                            <tr>
                                                <td>{{$item->inventory->item_code}}</td>
                                                <td>{{$item->inventory->item_category}}</td>
                                                <td>{{$item->inventory->item_description}}</td>
                                                <td>{{number_format($item->inventory->qty,2)}}</td>
                                                <td>{{$item->unit_of_measurement}}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="5">No data available.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
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
                                                        <i class="ti-files"></i>
                                                    </a>
                                                </td>
                                                <td style="padding: 5px 10px;">{{$file->document_type}}</td>
                                                <td style="padding: 5px 10px;">
                                                    <form method="POST" action="{{url('procurement/delete-files/'.$file->id)}}" class="d-inline-block" id="deleteForm{{$file->id}}">
                                                        @csrf 
        
                                                        <button type="button" class="btn btn-sm btn-danger" title="Remove File" onclick="removeFiles({{$file->id}})">
                                                            <i class="ti-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td style="padding: 5px 10px;">
                                                    <button type="button" class="btn btn-sm btn-warning" title="Edit File" data-bs-toggle="modal" data-bs-target="#editFile{{$file->id}}">
                                                        <i class="ti-pencil-alt"></i>
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
                    <hr>
                    <div class="col-md-12">
                        <div class="card border border-1 border-primary rounded-0">
                            <div class="card-header bg-primary rounded-0">
                                <p class="m-0 text-white font-weight-bold">Approver</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 border border-1 border-top-bottom border-left-right font-weight-bold">Name</div>
                                    <div class="col-lg-3 border border-1 border-top-bottom border-left-right font-weight-bold">Status</div>
                                    <div class="col-lg-3 border border-1 border-top-bottom border-left-right font-weight-bold">Date</div>
                                    <div class="col-lg-3 border border-1 border-top-bottom border-left-right font-weight-bold">Remarks</div>
                                </div>
                                @foreach ($purchase_request->purchaseRequestApprovers as $pr_approver)
                                    <div class="row">
                                        <div class="col-lg-3 border border-1 border-top-bottom border-left-right">{{ $pr_approver->user->name }}</div>
                                        <div class="col-lg-3 border border-1 border-top-bottom border-left-right">{{ $pr_approver->status }}</div>
                                        <div class="col-lg-3 border border-1 border-top-bottom border-left-right">
                                            @if($pr_approver->status == 'Approved')
                                                {{ date('Y-m-d', strtotime($pr_approver->updated_at)) }}
                                            @endif
                                        </div>
                                        <div class="col-lg-3 border border-1 border-top-bottom border-left-right">{!! nl2br(e($pr_approver->remarks)) !!}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('purchase_request.edit2_purchase_request')
@include('purchase_request.request_for_quotation')
@include('purchase_request.return_remarks')
@include('purchase_request.view_for_approval')

@section('js')
<script src="{{ asset('js/purchaseRequest.js') }}"></script>
<script>
    $(document).ready(function() {
        $(document).on('change', "[name='vendor_name[]']", function() {
            var emailDisplay = $(this).closest('tr').find('.vendor_email')
            var hiddenInput = $(this).closest('tr').find("input[name='vendor_email[]']");

            emailDisplay.text("")
            hiddenInput.val("")

            $.ajax({
                type: "POST",
                url: "{{url('refresh_vendor_email')}}",
                data: {
                    vendor_id: $(this).val()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res)
                {
                    $.each(res, function(key, data) {
                        emailDisplay.text(data.billing_email)
                        hiddenInput.val(data.id)
                    })
                }
            })
        })

        $("#addVendorBtn").on('click', function() {
            var newRow = `
                <tr>
                    <td>
                        <select data-placeholder="Select vendor name" name="vendor_name[]" class="form-control js-example-basic-single" style="width: 100%;" required>
                            <option value=""></option>
                            @foreach ($suppliers as $key=>$supplier)
                                <option value="{{$supplier->id}}">{{$supplier->corporate_name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="vendor_email[]">
                        <p class="vendor_email"></p>
                    </td>
                </tr>
            `

            $("#vendorTbodyRow").append(newRow)
            $('.js-example-basic-single').select2()
        })

        $("#deleteVendorBtn").on('click', function() {
            
            if($('#vendorTbodyRow').children().length > 1) {
                $('#vendorTbodyRow').children().last().remove()
            }
        })
    })
</script>
<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        const itemCheckboxAll = document.getElementById("itemCheckboxAll")
        const fileCheckboxAll = document.getElementById('fileCheckboxAll')

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
@endsection