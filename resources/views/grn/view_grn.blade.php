@extends('layouts.header')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title m-0">{{ $grn->grn_no }}</h4>
                        </div>
                        <a href="{{url('procurement/purchase-order')}}" type="button" class="btn btn-outline-secondary">
                            <i class="ti-arrow-left"></i>
                            Back   
                        </a>
                    </div>
                    <hr>

                    Primary Information
                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <dl class="row">
                                <dt class="col-sm-3 text-right">Reference :</dt>
                                <dd class="col-sm-9">{{ $grn->grn_no }}</dd>
                                <dt class="col-sm-3 text-right">Vendor :</dt>
                                <dd class="col-sm-9">{{ $grn->purchaseOrder->supplier->corporate_name }}</dd>
                                <dt class="col-sm-3 text-right">Created From :</dt>
                                <dd class="col-sm-9">
                                    <a href="{{ url('procurement/show_purchase_order/'.$grn->purchase_order_id) }}">{{ $grn->purchaseOrder->purchase_order_no }}</a>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-lg-6">
                            <dl class="row">
                                <dt class="col-sm-3 text-right">Date :</dt>
                                <dd class="col-sm-9">{{ date('M d Y', strtotime($grn->created_at)) }}</dd>
                                <dt class="col-sm-3 text-right">Posting Period :</dt>
                                <dd class="col-sm-9">{{ date('M Y', strtotime($grn->created_at)) }}</dd>
                            </dl>
                        </div>
                    </div>

                    Classification
                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <dl class="row">
                                <dt class="col-sm-3 text-right">
                                    Subsidiary :
                                </dt>
                                <dd class="col-sm-9">
                                    {{$grn->purchaseOrder->purchaseRequest->subsidiary}}
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#items">Items</a>
                        </li>
                    </ul>
    
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="items">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Item Code</th>
                                            <th>Item Description</th>
                                            <th>Remaining</th>
                                            <th>On Hand</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($grn->grnItemHistory as $grnItem)
                                            <tr>
                                                <td>{{ $grnItem->inventory->item_code }}</td>
                                                <td>{{ $grnItem->inventory->item_description }}</td>
                                                <td>{{ $grnItem->inventory->qty }}</td>
                                                <td>
                                                    {{ (int)$grnItem->inventory->qty - (int)$grnItem->received_qty }}
                                                </td>
                                                <td>
                                                    {{ $grnItem->received_qty }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection