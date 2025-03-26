@extends('layouts.header')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">View Item</h4>
                        <div>
                            <a href="{{ url('inventory/inventory_list') }}" class="btn btn-outline-secondary">
                                <i class="ti-arrow-left"></i>
                                Close
                            </a>
                        </div>
                    </div>

                    <p class="h6">Primary Information</p>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <dl class="row">
                                <dt class="col-sm-3 text-right">Item Name/Number :</dt>
                                <dd class="col-sm-9">{{ $inventory->item_code }}</dd>
                                <dt class="col-sm-3 text-right">Display Name/Code :</dt>
                                <dd class="col-sm-9">{{ $inventory->item_description }}</dd>
                                <dt class="col-sm-3 text-right">UOM :</dt>
                                <dd class="col-sm-9">{{ $inventory->uom->uomp }}</dd>
                                <dt class="col-sm-3 text-right">Vendor Name/Code :</dt>
                                <dd class="col-sm-9">&nbsp;</dd>
                            </dl>
                        </div>
                    </div>

                    <p class="h6">Classification</p>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <dl class="row">
                                <dt class="col-sm-3 text-right">Subsidiary :</dt>
                                <dd class="col-sm-9">
                                    @foreach ($inventory->inventory_subsidiary as $inventory_subsidiary)
                                        {{ $inventory_subsidiary->subsidiary->subsidiary_name }} <br>
                                    @endforeach
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <ul class="nav nav-tabs">
                        <div class="nav-item">
                            <a href="" class="nav-link active" data-toggle="tab" href="#relatedRecords">Related Records</a>
                        </div>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="relatedRecords">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="tablewithSearch">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Document No</th>
                                            <th>Vendor Name</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                            <th>Requested By</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
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
        $("#tablewithSearch").DataTable({
            dom: 'Bfrtip',
            ordering: false,
            pageLength: 25,
            paging: true,
        });
    })
</script>
@endsection