@extends('layouts.header')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Assign Analyst</h4>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tablewithSearch">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>PR Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchase_requests as $purchase_request)
                                    <tr>
                                        <td>
                                            <a href="{{url('procurement/show-purchase-request/'.$purchase_request->id)}}" class="btn btn-sm btn-info text-white">
                                                <i class="ti-eye"></i>
                                            </a>
                                        </td>
                                        <td>{{ str_pad($purchase_request->id,6,'0',STR_PAD_LEFT) }}</td>
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
            ordering: true,
            pageLength: 25,
            paging: true,
        });
    })
</script>
@endsection