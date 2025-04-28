{{-- @extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">

    <!-- Main Content Section -->
    <div class="card p-4 mt-3" style="border: 1px solid #ddd; border-radius: 20px; margin-top: -25px;">
        <div class="d-flex justify-content-between align-items-center">
            <h4>PO-{{str_pad($po->id, 6, '0', STR_PAD_LEFT)}} - {{$po->status}}</h4>

            <div>
                <a href="{{url('procurement/purchase-order')}}" type="button" class="btn btn-danger text-white">
                    Close   
                </a>
            </div>
        </div>
        <hr>
        <div class="row mb-4">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-4 mb-2"><b>To:</b></div>
                    <div class="col-lg-8 mb-2">
                        {{$po->supplier->corporate_name}}
                    </div>
                    <div class="col-lg-4 mb-2"><b>Supplier Address:</b></div>
                    <div class="col-lg-8 mb-2">
                        {{$po->supplier->business_address}}
                    </div>
                    <div class="col-lg-4 mb-2"><b>Contact Information:</b></div>
                    <div class="col-lg-8 mb-2">
                        {{$po->supplier->telephone_no}}
                    </div>
                    
                    <div class="col-lg-4 mb-2 mt-5"><b>Ship To:</b></div>
                    <div class="col-lg-8 mb-2 mt-5">{{$po->purchaseRequest->subsidiary}}</div>
                    <div class="col-lg-4 mb-2"><b>Contact Person:</b></div>
                    <div class="col-lg-8 mb-2">{{$po->purchaseRequest->user->name}}</div>
                    <div class="col-lg-4 mb-2"><b>Contact Number:</b></div>
                    <div class="col-lg-8 mb-2">Sample</div>
                    <div class="col-lg-4 mb-2"><b>Shipping Address:</b></div>
                    <div class="col-lg-8 mb-2">{!! nl2br(e($po->purchaseRequest->company->address)) !!}</div>
                    <div class="col-lg-4 mb-2"><b>Expected Delivery Date:</b></div>
                    <div class="col-lg-8 mb-2">{{date('M. d Y', strtotime($po->expected_delivery_date))}}</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-4 mb-2"><b>PO Date:</b></div>
                    <div class="col-lg-8 mb-2">{{date('M d Y', strtotime($po->created_at))}}</div>
                    <div class="col-lg-4 mb-2"><b>Payment Terms:</b></div>
                    <div class="col-lg-8 mb-2">{{$po->supplier->suppliers_terms}}</div>
                    <div class="col-lg-4 mb-2"><b>Bill To:</b></div>
                    <div class="col-lg-8 mb-2">{{$po->supplier->corporate_name}}</div>
                    <div class="col-lg-4 mb-2"><b>Bill Address:</b></div>
                    <div class="col-lg-8 mb-2">{!! nl2br(e($po->supplier->billing_address)) !!}</div>
                </div>
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
                            @if($po->purchaseRequest->rfqItem->isNotEmpty())
                                @foreach ($po->purchaseRequest->rfqItem as $item)
                                    <tr>
                                        <td style="padding: 5px 10px;">{{$item->purchaseItem->inventory->item_code}}</td>
                                        <td style="padding: 5px 10px;">{{$item->purchaseItem->inventory->item_category}}</td>
                                        <td style="padding: 5px 10px;">{{$item->purchaseItem->inventory->item_description}}</td>
                                        <td style="padding: 5px 10px;">{{number_format($item->purchaseItem->inventory->qty,2)}}</td>
                                        <td style="padding: 5px 10px;">{{$item->purchaseItem->unit_of_measurement}}</td>
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
                            </tr>
                        </thead>
                        <tbody>
                            @if($po->purchaseRequest->purchaseRequestFiles->isNotEmpty())
                                @foreach ($po->purchaseRequest->purchaseRequestFiles as $file)
                                    <tr>
                                        <td style="padding: 5px 10px;">
                                            <a href="{{url($file->file)}}" target="_blank">
                                                <i class="bi bi-files"></i>
                                            </a>
                                        </td>
                                        <td style="padding: 5px 10px;">{{$file->document_type}}</td>
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
        </div>
    </div>
</div>

@endsection

@push('scripts')

@endpush --}}

@extends('layouts.header')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{$po->purchase_order_no}} - {{$po->status}}</h4>
    
                    <div>
                        @if($po->status == 'Approved' || $po->status == 'Partial Received')
                            @if($po->status != 'Received' && $po->purchaseRequest->user_id == auth()->user()->id)
                                <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#received{{$po->id}}">
                                    <i class="ti-check"></i>
                                    Received
                                </button>

                                @include('purchase_orders.received_po')
                            @endif
                        @elseif($po->status == 'Pending')

                            @foreach ($po->purchaseOrderApprovers->where('status', 'Pending')->where('user_id', auth()->user()->id) as $po_approver)
                                <form method="POST" class="d-inline-block" action="{{url('approved_po')}}" onsubmit="show()">
                                    @csrf 
                                    <input type="hidden" name="id" value="{{$po->id}}">
                                    
                                    <button type="submit" class="btn btn-outline-success">
                                        <i class="ti-check"></i>
                                        Approved
                                    </button>
                                </form>
                            @endforeach

                            {{-- <form method="POST" class="d-inline-block" action="{{url('cancel_po/'.$po->id)}}" onsubmit="show()">
                                @csrf 
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="ti-na"></i>
                                    Cancel
                                </button>
                            </form> --}}
                        @endif

                        <a href="{{url('procurement/purchase-order')}}" type="button" class="btn btn-outline-secondary">
                            <i class="ti-arrow-left"></i>
                            Back   
                        </a>
                    </div>
                </div>
                <hr>
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right">To :</dt>
                            <dd class="col-sm-9">{{$po->supplier->corporate_name}}</dd>
                            <dt class="col-sm-3 text-right">Supplier Address:</dt>
                            <dd class="col-sm-9">{{$po->supplier->business_address}}</dd>
                            <dt class="col-sm-3 text-right">Contact Information:</dt>
                            <dd class="col-sm-9">{{$po->supplier->telephone_no}}</dd>
                            <dt class="col-sm-3 text-right"><b>Ship To:</b></dt>
                            <dd class="col-sm-9">{{$po->purchaseRequest->subsidiary}}</dd>
                            <dt class="col-sm-3 text-right">Contact Person:</dt>
                            <dd class="col-sm-9">{{$po->purchaseRequest->user->name}}</dd>
                            <dt class="col-sm-3 text-right">Contact Number:</dt>
                            <dd class="col-sm-9">&nbsp;</dd>
                            <dt class="col-sm-3 text-right">Shipping Address:</dt>
                            <dd class="col-sm-9">{!! nl2br(e($po->purchaseRequest->company->address)) !!}</dd>
                            <dt class="col-sm-3 text-right"><b>Expected Delivery Date:</b></dt>
                            <dd class="col-sm-9">{{date('M. d Y', strtotime($po->expected_delivery_date))}}</dd>
                        </dl>
                    </div>
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right">PO Date:</dt>
                            <dd class="col-sm-9">{{date('M d Y', strtotime($po->created_at))}}</dd>
                            <dt class="col-sm-3 text-right">Payment Terms:</dt>
                            <dd class="col-sm-9">{{$po->supplier->suppliers_terms}}</dd>
                            <dt class="col-sm-3 text-right">Bill To:</dt>
                            <dd class="col-sm-9">{{$po->supplier->corporate_name}}</dd>
                            <dt class="col-sm-3 text-right">Bill Address:</dt>
                            <dd class="col-sm-9">{!! nl2br(e($po->supplier->billing_address)) !!}</dd>
                        </dl>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right">GRN:</dt>
                            <dd class="col-sm-9">
                                @foreach ($po->grn as $grn)
                                    {{ $grn->grn_no }} <br>
                                @endforeach
                            </dd> <br>
                        </dl>
                    </div>
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right">Received Date:</dt>
                            <dd class="col-sm-9">
                                @if($po->grn_no)
                                    {{ date('M d Y', strtotime($po->updated_at)) }}
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 mt-3">
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
                                @foreach ($po->purchaseOrderApprovers as $po_approver)
                                    <div class="row">
                                        <div class="col-lg-3 border border-1 border-top-bottom border-left-right">{{ $po_approver->user->name }}</div>
                                        <div class="col-lg-3 border border-1 border-top-bottom border-left-right">{{ $po_approver->status }}</div>
                                        <div class="col-lg-3 border border-1 border-top-bottom border-left-right">
                                            @if($po_approver->status == 'Approved')
                                                {{ date('Y-m-d', strtotime($po_approver->updated_at)) }}
                                            @endif
                                        </div>
                                        <div class="col-lg-3 border border-1 border-top-bottom border-left-right">{!! nl2br(e($po_approver->remarks)) !!}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#items">Items</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#attachments">Attachment</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade active show" id="items">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Item Code</th>
                                        {{-- <th>Item Category</th> --}}
                                        <th>Item Description</th>
                                        <th>Quantity</th>
                                        <th>Unit of Measurement</th>
                                        <th>Rate</th>
                                        <th>Tax Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($po->purchaseOrderItem->isNotEmpty())
                                        @foreach ($po->purchaseOrderItem as $item)
                                            <tr>
                                                <td>{{$item->inventory->item_code}}</td>
                                                {{-- <td>{{$item->inventory->item_category}}</td> --}}
                                                <td>{{$item->inventory->item_description}}</td>
                                                <td>{{number_format($item->inventory->qty,2)}}</td>
                                                <td>{{$item->inventory->uom->uomp}}</td>
                                                <td>0.00</td>
                                                <td></td>
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
                    <div class="tab-pane fade" id="attachments">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Attachments</th>
                                        <th>Document Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($po->purchaseRequest->purchaseRequestFiles->isNotEmpty())
                                        @foreach ($po->purchaseRequest->purchaseRequestFiles as $file)
                                            <tr>
                                                <td>
                                                    <a href="{{url($file->file)}}" target="_blank">
                                                        <i class="ti-file"></i>
                                                    </a>
                                                </td>
                                                <td>{{$file->document_type}}</td>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $("#receive_all").on('click', function() {
            if($(this).is(":checked"))
            {
                $("[name='receive_item[]']").each(function(key, value) {
                    $(value).prop('checked', true)
                    $(this).closest('tr').find("[name='qty[]']").prop('disabled', false)
                })
            }
            else
            {
                $("[name='receive_item[]']").each(function(key, value) {
                    $(value).prop('checked', false)
                    $(this).closest('tr').find("[name='qty[]']").prop('disabled', true)
                })
            }
        })
        // $("[name='receive_item[]']").each(function(key, value) {
        //     $(value).on('click', function () {
        //         if ($(value).is(":checked")) 
        //         {
        //             $(this).closest('tr').find("[name='qty[]']").prop('disabled', false);
        //         } 
        //         else 
        //         {
        //             $(this).closest('tr').find("[name='qty[]']").prop('disabled', true);
        //         }
        //     })
        // });
    })
</script>
@endsection