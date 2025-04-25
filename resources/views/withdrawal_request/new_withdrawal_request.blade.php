@extends('layouts.header')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4 align-items-center">
                        <h4 class="card-title mb-0">Add new withdrawal transfer</h4>

                        <div>
                            <a href="{{ url('inventory/withdrawal') }}" class="btn btn-outline-secondary">
                                <i class="ti-arrow-left"></i>
                                Back
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ url('store_withdrawal') }}" method="POST" onsubmit="show()">
                                @csrf 

                                {{-- <div class="form-group row">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <label for="requestNumber" class="col-sm-3 col-form-label">Request Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="requestNumber" value="Auto-Generated when submitting a form" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="requestorName" class="col-sm-3 col-form-label">Custodian Name</label>
                                    <input type="hidden" name="request_name" value="{{ auth()->user()->id }}">
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="requestName" value="{{ auth()->user()->name }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="requestorName" class="col-sm-3 col-form-label">Subsidiary</label>
                                    <input type="hidden" name="subsidiary" value="{{ auth()->user()->subsidiaryId->subsidiary_id }}">
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="subsidiary" value="{{ auth()->user()->subsidiaryId->subsidiary_name }}" value="HO" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="remarks" class="col-sm-3 col-form-label">Remarks</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control form-control-sm" name="remarks" id="remarks"></textarea>
                                    </div>
                                </div>
                                <!-- Item Information Table -->

                                <div class="table-responsive mb-3">
                                    <!-- Button to add a new row -->
                                    <button type="button" class="btn btn-sm btn-success mb-2" id="addRowBtn">
                                        <i class="ti-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger mb-2" id="removeRowBtn">
                                        <i class="ti-minus"></i>
                                    </button>
                                    <table class="table table-bordered table-sm" id="itemsTable">
                                        <thead>
                                            <tr>
                                                <th>Item Code</th>
                                                <th>Item Description</th>
                                                <th>Category</th>
                                                <th>Qty</th>
                                                <th>UOM</th>
                                                <th>Reason of Withdrawal</th>
                                                <th>Requested QTY</th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemTableBody">
                                            <tr>
                                                <td>
                                                    <p id="itemCodeText"></p>
                                                </td>
                                                <td>
                                                    <select data-placeholder="Select item" class="form-control js-example-basic-single" name="item[]" style="width: 100%;" required>
                                                        <option value=""></option>
                                                        @foreach ($inventories as $inventory)
                                                            <option value="{{ $inventory->inventory_id }}">{{ $inventory->item_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <p id="categoryText"></p>
                                                </td>
                                                <td id="qty">

                                                </td>
                                                <td>
                                                    <select data-placeholder="Select uom" class="form-control js-example-basic-single" name="uom[]" style="width: 100%;" required>
                                                        <option value=""></option>
                                                        @foreach ($uoms as $uom)
                                                            <option value="{{ $uom->id }}">{{ $uom->uomp }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="reason">
                                                    <textarea name="reason[]" class="form-control"></textarea>
                                                </td>
                                                <td class="requestedQty">
                                                    <input type="number" name="requestQty[]" class="form-control" required>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-success float-right">Save</button>
                                    </div>
                                </div>
                            </form>
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
        $("#addRowBtn").on('click', function() {
            var newRow = `
                <tr>
                    <td>
                        <p id="itemCodeText"></p>
                    </td>
                    <td>
                        <select data-placeholder="Select item" class="form-control inventorySelect" name="item[]" style="width: 100%;" required>
                            <option value=""></option>
                            @foreach ($inventories as $inventory)
                                <option value="{{ $inventory->inventory_id }}">{{ $inventory->item_description }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <p id="categoryText"></p>
                    </td>
                    <td id="qty">

                    </td>
                    <td>
                        <select data-placeholder="Select uom" class="form-control inventorySelect" name="uom[]" style="width: 100%;" required>
                            <option value=""></option>
                            @foreach ($uoms as $uom)
                                <option value="{{ $uom->id }}">{{ $uom->uomp }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td contenteditable="true" class="reason">
                        <textarea name="reason[]" class="form-control"></textarea>
                    </td>
                    <td>
                        <input type="number" name="requestQty[]" class="form-control" required>
                    </td>
                </tr>
            `

            $("#itemTableBody").append(newRow)
            $('.inventorySelect').select2()
        })

        $("#removeRowBtn").on('click', function() {
            var itemTableBody = $("#itemTableBody").children()

            if (itemTableBody.length > 1)
            {
                itemTableBody.last().remove()
            }
        })

        $(document).on('change', "[name='item[]']", function() {
            var value = $(this).val()
            var itemCode = $(this).closest('tr').find('#itemCodeText')
            var category = $(this).closest('tr').find('#categoryText')
            var qty = $(this).closest('tr').find('#qty')
            
            $.ajax({
                type:"POST",
                url:"{{ url('refresh_inventory') }}",
                data: {
                    id: value,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    itemCode.text(res.item_code)
                    category.text(res.category.name)
                    qty.text(res.qty)
                }
            })
        })

        $(document).on('input', '[name="requestQty[]"]', function() {
            var actualQty = $(this).closest('tr').find('#qty').text()
            
            $(this).prop('max', actualQty)
        })
    })
</script>
@endsection