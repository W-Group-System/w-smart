@extends('layouts.header')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Asset List Details</h4>
                    <div>
                        <a href="{{url('equipment/asset_list')}}" class="btn btn-outline-secondary">
                            <i class="ti-arrow-left"></i>
                            Back
                        </a>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right">Date Purchased :</dt>
                            <dd class="col-sm-9">{{date('M d Y', strtotime($equipment->date_purchased))}}</dd>
                            <dt class="col-sm-3 text-right">Date Acquired :</dt>
                            <dd class="col-sm-9">{{date('M d Y', strtotime($equipment->date_acquired))}}</dd>
                            <dt class="col-sm-3 text-right">Date Repaired :</dt>
                            <dd class="col-sm-9">{{date('M d Y', strtotime($equipment->date_repaired))}}</dd>
                            <dt class="col-sm-3 text-right">Asset Name :</dt>
                            <dd class="col-sm-9">{{$equipment->asset_name}}</dd>
                            <dt class="col-sm-3 text-right">Subsidiary :</dt>
                            <dd class="col-sm-9">{{$equipment->subsidiary->subsidiary_name}}</dd>
                            <dt class="col-sm-3 text-right">Estimated Useful Life :</dt>
                            <dd class="col-sm-9">{{$equipment->estimated_useful_life}}</dd>
                            <dt class="col-sm-3 text-right">Status :</dt>
                            <dd class="col-sm-9">{{$equipment->status}}</dd>
                            <dt class="col-sm-3 text-right">Assigned To :</dt>
                            <dd class="col-sm-9">{{$equipment->assigned_to}}</dd>
                            <dt class="col-sm-3 text-right">Equipment Model :</dt>
                            <dd class="col-sm-9">{{$equipment->equipment_model}}</dd>
                            <dt class="col-sm-3 text-right">PO Number :</dt>
                            <dd class="col-sm-9">{{$equipment->po_number}}</dd>
                            <dt class="col-sm-3 text-right">Specifications :</dt>
                            <dd class="col-sm-9">{{$equipment->specifications}}</dd>
                            <dt class="col-sm-3 text-right">Asset Value :</dt>
                            <dd class="col-sm-9">{{$equipment->asset_value}}</dd>
                        </dl>
                    </div>
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right">Date Installation :</dt>
                            <dd class="col-sm-9">{{date('M d Y', strtotime($equipment->date_installation))}}</dd>
                            <dt class="col-sm-3 text-right">Date Transferred :</dt>
                            <dd class="col-sm-9">{{date('M d Y', strtotime($equipment->date_transferred))}}</dd>
                            <dt class="col-sm-3 text-right">Asset Code :</dt>
                            <dd class="col-sm-9">{{date($equipment->asset_code)}}</dd>
                            <dt class="col-sm-3 text-right">Category :</dt>
                            <dd class="col-sm-9">{{$equipment->category->name}}</dd>
                            <dt class="col-sm-3 text-right">Location :</dt>
                            <dd class="col-sm-9">{{$equipment->location}}</dd>
                            <dt class="col-sm-3 text-right">Type :</dt>
                            <dd class="col-sm-9">{{$equipment->type}}</dd>
                            <dt class="col-sm-3 text-right">Remarks :</dt>
                            <dd class="col-sm-9">{!! nl2br(e($equipment->remarks)) !!}</dd>
                            <dt class="col-sm-3 text-right">Serial Number :</dt>
                            <dd class="col-sm-9">{{$equipment->serial_number}}</dd>
                            <dt class="col-sm-3 text-right">Warranty (Months) :</dt>
                            <dd class="col-sm-9">{{$equipment->warranty}}</dd>
                            <dt class="col-sm-3 text-right">Brand :</dt>
                            <dd class="col-sm-9">{{$equipment->brand}}</dd>
                            <dt class="col-sm-3 text-right">Photo :</dt>
                            <dd class="col-sm-9">
                                <a href="{{url($equipment->photo)}}" target="_blank">
                                    <i class="ti-file"></i>
                                </a>
                            </dd>
                            <dt class="col-sm-3 text-right">Item Code :</dt>
                            <dd class="col-sm-9">{{$equipment->item_code}}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection