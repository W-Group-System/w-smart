@extends('layouts.header')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Purchase Approvers</h4>

                    <button type="button" class="btn btn-outline-success mb-4" data-toggle="modal" data-target="#new">
                        <i class="ti-plus"></i>
                        Add Purchase Approver
                    </button>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tablewithSearch">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchase_approvers as $purchase_approver)
                                    <tr>
                                        <td>{{ $purchase_approver->user->name }}</td>
                                        <td>{{ $purchase_approver->level }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Item Approver</h4>

                    <button type="button" class="btn btn-outline-success mb-4" data-toggle="modal" data-target="#newItemApprover">
                        <i class="ti-plus"></i>
                        Add Item Approver
                    </button>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="approverTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Subsidiary</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item_approvers as $approver)
                                    <tr>
                                        <td>{{ $approver->user->name }}</td>
                                        <td>{{ $approver->subsidiary->subsidiary_name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('purchase_approver.new_purchase_approver')
    @include('purchase_approver.new_item_approver')
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

        $("#approverTable").DataTable({
            dom: 'Bfrtip',
            ordering: false,
            pageLength: 25,
            paging: true,
        });

        $("#addApproverBtn").on('click', function() {
            var lastId = $("#approverContainer").children().last().attr('id')
            var finalId = lastId.split('_')
            var displayId = parseInt(finalId[1]) + 1
            
            var newRow = `
                <div class="row" id="approverRow_${displayId}">
                    <div class="col-lg-2">
                        ${displayId}
                    </div>
                    <div class="col-lg-10 mb-2">
                        <select data-placeholder="Select approver" name="approver[]" class="form-control js-example-basic-single" style="width: 100%; position: relative;">
                            <option value=""></option>
                            @foreach ($approvers as $approver)
                                <option value="{{ $approver->id }}">{{ $approver->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            `

            $("#approverContainer").append(newRow)
            $(".js-example-basic-single").select2()
        })

        $("#removeApproverBtn").on('click', function() {
            var lastChild = $("#approverContainer").children()
            
            if (lastChild.length > 1)
            {
                lastChild.last().remove()
            }
        })
    })
</script>
@endsection