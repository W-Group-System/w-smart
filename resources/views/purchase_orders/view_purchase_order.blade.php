@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    {{-- @include('layouts.procurement_header') --}}

    <!-- Main Content Section -->
    <div class="card p-4 mt-3" style="border: 1px solid #ddd; border-radius: 20px; margin-top: -25px;">
        <div class="d-flex justify-content-between align-items-center">
            <h4>PO-{{str_pad($po->id, 6, '0', STR_PAD_LEFT)}} - {{$po->status}}</h4>

            <div>
                {{-- <button type="button" class="btn btn-warning text-white" title="Edit" data-bs-toggle="modal" data-bs-target="#editPr{{$purchase_requests->id}}">
                    Edit
                </button>
                @if($purchase_requests->status == 'For RFQ')
                <button type="button" class="btn btn-info text-white" title="Request for quotation" data-bs-toggle="modal" data-bs-target="#rfq{{$purchase_requests->id}}">
                    Request For Quotation (RFQ)
                </button>
                @endif --}}
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
                        @foreach ($po->rfqEmail->vendor->vendorContact as $vendor)
                            {{$vendor->contact_person}} <br>
                        @endforeach
                    </div>
                    <div class="col-lg-4 mb-2"><b>Supplier Address:</b></div>
                    <div class="col-lg-8 mb-2">
                        @foreach ($po->rfqEmail->vendor->vendorContact as $vendor)
                            {{$vendor->address}} <br>
                        @endforeach
                    </div>
                    <div class="col-lg-4 mb-2"><b>Contact Information:</b></div>
                    <div class="col-lg-8 mb-2">
                        @foreach ($po->rfqEmail->vendor->vendorContact as $vendor)
                            {{$vendor->alternative_phone}} <br>
                        @endforeach
                    </div>
                    
                    <div class="col-lg-4 mb-2 mt-5"><b>Ship To:</b></div>
                    <div class="col-lg-8 mb-2 mt-5">{{$po->purchaseRequest->subsidiary}}</div>
                    <div class="col-lg-4 mb-2"><b>Contact Person:</b></div>
                    <div class="col-lg-8 mb-2">{{$po->purchaseRequest->assignedTo->name}}</div>
                    <div class="col-lg-4 mb-2"><b>Contact Number:</b></div>
                    <div class="col-lg-8 mb-2">Sample</div>
                    <div class="col-lg-4 mb-2"><b>Shipping Address:</b></div>
                    <div class="col-lg-8 mb-2">Sample</div>
                    <div class="col-lg-4 mb-2"><b>Expected Delivery Date:</b></div>
                    <div class="col-lg-8 mb-2">Sample</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-4 mb-2"><b>PO Date:</b></div>
                    <div class="col-lg-8 mb-2">{{date('M d Y', strtotime($po->created_at))}}</div>
                    <div class="col-lg-4 mb-2"><b>Payment Terms:</b></div>
                    <div class="col-lg-8 mb-2">Sample</div>
                    <div class="col-lg-4 mb-2"><b>Bill To:</b></div>
                    <div class="col-lg-8 mb-2">Sample</div>
                    <div class="col-lg-4 mb-2"><b>Bill Address:</b></div>
                    <div class="col-lg-8 mb-2">Sample</div>
                    {{-- <div class="col-lg-4 mb-2"><b>Contact Person:</b></div>
                    <div class="col-lg-8 mb-2">Sample</div> --}}
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

                                    {{-- @include('purchase_request.edit_file') --}}
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

@endpush