@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    {{-- @include('layouts.procurement_header') --}}

    <!-- Main Content Section -->
    <div class="card p-4 mt-3" style="border: 1px solid #ddd; border-radius: 20px; margin-top: -25px;">
        <div class="d-flex justify-content-end align-items-center mb-3">
            <div>
                {{-- <button type="button" class="btn btn-warning text-white" title="Edit" data-bs-toggle="modal" data-bs-target="#editPr{{$purchase_requests->id}}">
                    Edit
                </button>
                <button type="button" class="btn btn-info text-white" title="Request for quotation" data-bs-toggle="modal" data-bs-target="#rfq{{$purchase_requests->id}}">
                    Request For Quotation (RFQ)
                </button> --}}
                <a href="{{url('procurement/canvassing')}}" type="button" class="btn btn-danger text-white">
                    Close   
                </a>
            </div>
        </div>
        <hr class="mb-3 mt-0">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-4">
                        <p><b>Subsidiary:</b></p>
                    </div>
                    <div class="col-lg-8">
                        <p>{{$purchase_request->subsidiary}}</p>
                    </div>
                    <div class="col-lg-4">
                        <p><b>Contact Person:</b></p>
                    </div>
                    <div class="col-lg-8">
                    </div>
                    <div class="col-lg-4">
                        <p><b>Contact No.:</b></p>
                    </div>
                    <div class="col-lg-8">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-4">
                        <p><b>PR NO.:</b></p>
                    </div>
                    <div class="col-lg-8">
                        <p>{{str_pad($purchase_request->id, 6, '0', STR_PAD_LEFT)}}</p>
                    </div>
                    <div class="col-lg-4">
                        <p><b>PR Date:</b></p>
                    </div>
                    <div class="col-lg-8">
                        <p>{{date('M d Y', strtotime($purchase_request->created_at))}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="padding: 5px;">No.</th>
                            <th style="padding: 5px;">Item Description</th>
                            <th style="padding: 5px;">Qty</th>
                            <th style="padding: 5px;">UOM</th>
                            <th style="padding: 5px;">Unit Cost</th>
                            <th style="padding: 5px;">Total Amount</th>
                            <th style="padding: 5px;">Unit Cost</th>
                            <th style="padding: 5px;">Total Amount</th>
                            <th style="padding: 5px;">Unit Cost</th>
                            <th style="padding: 5px;">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchase_request->rfqItem as $key=>$item)
                            <tr>
                                <td style="padding: 5px;">{{$key+1}}</td>
                                <td style="padding: 5px;">{{$item->purchaseItem->item_description}}</td>
                                <td style="padding: 5px;">{{$item->purchaseItem->item_quantity}}</td>
                                <td style="padding: 5px;"></td>
                                <td style="padding: 5px;"></td>
                                <td style="padding: 5px;"></td>
                                <td style="padding: 5px;"></td>
                                <td style="padding: 5px;"></td>
                                <td style="padding: 5px;"></td>
                                <td style="padding: 5px;"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
@endpush