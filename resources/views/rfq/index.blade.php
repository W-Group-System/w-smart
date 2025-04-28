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
                    <div class="card text-success">
                        <div class="card-body">
                            <h4 class="mb-4">RFQ</h4>
                            0
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card grid-margin stretch-card">
                <div class="card-body">
                    <h5 class="card-title">RFQ</h5>

                    <div class="table-responsive mt-2">
                        <table class="table table-hover table-bordered table-striped " id="tablewithSearch">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Request Date </th>
                                    <th>PR Number </th>
                                    <th>Item Description </th>
                                    <th>Due Date </th>
                                    <th>Requestor Name </th>
                                    <th>Department </th>
                                    <th>Subsidiary </th>
                                    {{-- <th>Amount </th> --}}
                                    {{-- <th>Expedited </th> --}}
                                    <th>Status </th>
                                    <th>Assigned to (Buyer) </th>
                                    <th>Assigned Date/Time </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchased_requests as $pr)
                                    <tr>
                                        <td>
                                            <a href="{{url('procurement/show-purchase-request/'.$pr->id)}}" class="btn btn-sm btn-info">
                                                <i class="ti-eye"></i>
                                            </a>
                                            
                                            @if($pr->status == 'Returned')
                                            <a href="{{ url('edit_purchase_request/'.$pr->id) }}" class="btn btn-sm btn-warning">
                                                <i class="ti-pencil-alt"></i>
                                            </a>
                                            @endif
                                        </td>
                                        <td>{{date('m/d/Y', strtotime($pr->created_at))}}</td>
                                        <td>{{str_pad($pr->id,6,'0',STR_PAD_LEFT)}}</td>
                                        <td>
                                            @foreach ($pr->purchaseItems as $item)
                                                {{$item->inventory->item_description ?? ''}} <br>
                                            @endforeach
                                        </td>
                                        <td>{{date('m/d/Y', strtotime($pr->due_date))}}</td>
                                        <td>{{$pr->user->name}}</td>
                                        <td>{{$pr->department->name}}</td>
                                        <td>{{$pr->subsidiary}}</td>
                                        {{-- <td>0.00</td> --}}
                                        {{-- <td>Expedited</td> --}}
                                        <td>{{$pr->status}}</td>
                                        <td>{{optional($pr->assignedTo)->name}}</td>
                                        <td>{{date('m/d/Y', strtotime($pr->created_at))}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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