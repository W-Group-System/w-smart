{{-- <div class="modal fade" id="addPurchaseRequest">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInventoryModalLabel">Add new purchase request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addInventoryForm" action="{{url('procurement/store-purchase-request')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6 mb-2">
                            <label for="puchaseNo" class="form-label">Purchase No.:</label>
                            <input type="text" class="form-control" value="The PR No. is auto generated when submitting a form" readonly>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="requestorName" class="form-label">Requestor Name:</label>
                            <input type="hidden" name="requestor_name" value="{{auth()->user()->id}}">
                            <input type="text" class="form-control" id="requestorName" required value="{{auth()->user()->name}}" readonly>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" name="remarks" cols="30" rows="10"></textarea>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="requestDueDate" class="form-label">Request Due-Date:</label>
                            <input type="date" name="requestDueDate" name="request_due_date" id="requestDueDate" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="subsidiary" class="form-label">Subsidiary:</label>
                            <input type="text" name="subsidiary" value="{{auth()->user()->subsidiary}}" class="form-control form-control-sm" readonly>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="class" class="form-label" >Class:</label>
                            <select data-placeholder="Select class" class="form-control js-example-basic-single" style="width: 100%; position: relative;" required>
                                <option value=""></option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="department" class="form-label">Department</label>
                            <input type="hidden" name="department" value="{{auth()->user()->department_id}}">
                            <input type="text"  value="{{auth()->user()->department->name}}" class="form-control form-control-sm" readonly>
                        </div>

                        <div class="col-md-12 mb-2">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" style="table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <th style="padding: 5px 10px">Item Code</th>
                                            <th style="padding: 5px 10px">Item Category</th>
                                            <th style="padding: 5px 10px">Item Description</th>
                                            <th style="padding: 5px 10px">Item Quantity</th>
                                            <th style="padding: 5px 10px">Unit of Measurement</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyAddRow">
                                        <tr>
                                            <td style="padding: 5px 10px">
                                                <p class="item_code"></p>
                                            </td>
                                            <td style="padding: 5px 10px">
                                                <p class="item_category"></p>
                                            </td>
                                            <td style="padding: 5px 10px">
                                                <select data-placeholder="Select item description" name="inventory_id[]" class="form-control js-example-basic-single" style="width: 100%; position: relative;" onchange="itemDescription(this.value)">
                                                    <option value=""></option>
                                                    @foreach ($inventory_list as $inventory)
                                                        <option value="{{$inventory->inventory_id}}">{{$inventory->item_description}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td style="padding: 5px 10px">
                                                <p class="item_quantity"></p>
                                            </td>
                                            <td style="padding: 5px 10px">
                                                <select data-placeholder="Select unit of measurement" name="unit_of_measurement[]" class="form-control js-example-basic-single" style="width: 100%; position: relative;" required>
                                                    <option value=""></option>
                                                    <option value="KG">KG</option>
                                                    <option value="G">Grams</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>    
                            <button type="button" class="btn btn-sm btn-success" id="addRowBtn">
                                <i class="ti-plus"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" id="deleteRowBtn">
                                <i class="ti-minus"></i>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <label for="attachments" class="form-label">Attachments:</label>
                            <input type="file" name="attachments[]" class="form-control" multiple>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="saveNewInventory">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div> --}}

@extends('layouts.header')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Create Purchase Request</h4>
    
                <form method="POST" action="{{url('procurement/store-purchase-request')}}" onsubmit="show()" enctype="multipart/form-data">
                    @csrf 
    
                    <div class="row g-3">
                        <div class="col-md-6 mb-2">
                            <label for="puchaseNo" class="form-label">Purchase No.:</label>
                            <input type="text" class="form-control" value="The PR No. is auto generated when submitting a form" readonly>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="requestorName" class="form-label">Requestor Name:</label>
                            <input type="hidden" name="requestor_name" value="{{auth()->user()->id}}">
                            <input type="text" class="form-control" id="requestorName" required value="{{auth()->user()->name}}" readonly>
                        </div>
        
                        <div class="col-md-6 mb-2">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" name="remarks" cols="30" rows="10"></textarea>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="requestDueDate" class="form-label">Request Due-Date:</label>
                            <input type="date" name="requestDueDate" name="request_due_date" id="requestDueDate" class="form-control form-control-sm" required>
                        </div>
        
                        <div class="col-md-6 mb-2">
                            <label for="subsidiary" class="form-label">Subsidiary:</label>
                            <input type="text" name="subsidiary" value="{{auth()->user()->subsidiary}}" class="form-control form-control-sm" readonly>
                        </div>
        
                        <div class="col-md-6 mb-2">
                            <label for="class" class="form-label" >Class:</label>
                            <select data-placeholder="Select class" class="form-control js-example-basic-single" style="width: 100%; position: relative;" >
                                <option value=""></option>
                            </select>
                        </div>
        
                        <div class="col-md-6 mb-2">
                            <label for="department" class="form-label">Department</label>
                            <input type="hidden" name="department" value="{{auth()->user()->department_id}}">
                            <input type="text"  value="{{auth()->user()->department->name}}" class="form-control form-control-sm" readonly>
                        </div>
        
                        <div class="col-md-12 mb-2">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" style="table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <th>Item Code</th>
                                            <th>Item Category</th>
                                            <th>Item Description</th>
                                            <th>Item Quantity</th>
                                            <th>Unit of Measurement</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyAddRow">
                                        <tr>
                                            <td>
                                                <p class="item_code"></p>
                                            </td>
                                            <td>
                                                <p class="item_category"></p>
                                            </td>
                                            <td>
                                                <select data-placeholder="Select item description" name="inventory_id[]" class="form-control js-example-basic-single" style="width: 100%; position: relative;" onchange="itemDescription(this)">
                                                    <option value=""></option>
                                                    @foreach ($inventory_list as $inventory)
                                                        <option value="{{$inventory->inventory_id}}">{{$inventory->item_description}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <p class="item_quantity"></p>
                                            </td>
                                            <td>
                                                <select data-placeholder="Select unit of measurement" name="unit_of_measurement[]" class="form-control js-example-basic-single" style="width: 100%; position: relative;" required>
                                                    <option value=""></option>
                                                    <option value="KG">KG</option>
                                                    <option value="G">Grams</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>    
                            <button type="button" class="btn btn-sm btn-success" id="addRowBtn">
                                <i class="ti-plus"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" id="deleteRowBtn">
                                <i class="ti-minus"></i>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <label for="attachments" class="form-label">Attachments:</label>
                            <input type="file" name="attachments[]" class="form-control" multiple>
                        </div>
        
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success float-right mt-5">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    
function itemDescription(element)
{
    var itemCode = $(element).closest('tr').find('.item_code')
    var itemCategory = $(element).closest('tr').find('.item_category')
    var itemQuantity = $(element).closest('tr').find('.item_quantity')
    
    $.ajax({
        type: "POST",
        url: "{{route('refreshInventory')}}",
        data: {
            id: element.value
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            itemCode.text(data.item_code)
            itemCategory.text(data.item_category)
            itemQuantity.text(data.qty)
        }
    })
}

$(document).ready(function() {
    $("#addRowBtn").on('click', function() {
        var newRow = `
            <tr>
                <td>
                    <p class="item_code"></p>
                </td>
                <td>
                    <p class="item_category"></p>
                </td>
                <td>
                    <select data-placeholder="Select item description" name="inventory_id[]" class="form-control js-example-basic-single" style="width: 100%; position: relative;" onchange="itemDescription(this)">
                        <option value=""></option>
                        @foreach ($inventory_list as $inventory)
                            <option value="{{$inventory->inventory_id}}">{{$inventory->item_description}}</option>
                        @endforeach
                    </select>
                </td>
                <td >
                    <p class="item_quantity"></p>
                </td>
                <td>
                    <select data-placeholder="Select unit of measurement" name="unit_of_measurement[]" class="form-select js-example-basic-single" style="width: 100%; position: relative;" required>
                        <option value=""></option>
                        <option value="KG">KG</option>
                        <option value="G">Grams</option>
                    </select>
                </td>
            </tr>
        `;

        $('#tbodyAddRow').append(newRow)
        $('.js-example-basic-single').select2()
        // $('#tbodyAddRow .chosen-select').chosen();
    })

    $(document).on('change', '.item-description', function() {
        const selectedValue = $(this).val();
        
        itemDescription(selectedValue);
    });

    $("#deleteRowBtn").on('click', function() {
        
        var row = $('#tbodyAddRow').children();
        
        if (row.length > 1) {
            row.last().remove()
        }
        // $("#tbodyAddRow").children().last().remove()
        
    })

    // $("[name='inventory_id[]']").on('change', function() {
    //     var itemCode = $(this).closest('tr').find('.item_code')
    //     var itemCategory = $(this).closest('tr').find('.item_category')
    //     var itemQuantity = $(this).closest('tr').find('.item_quantity')
        
    //     // var hiddenItemCode = $('[name="item_code[]"]')
    //     // var hiddenItemCategory = $('[name="item_category[]"]')
    //     // var hiddenItemQuantity = $('[name="item_quantity[]"]')
    //     // var hiddenItemDescription = $('[name="item_description[]"]')
        
    //     $.ajax({
    //         type: "POST",
    //         url: "{{route('refreshInventory')}}",
    //         data: {
    //             id: value
    //         },
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(data) {
    //             console.log(data);
                
    //             itemCode.text(data.item_code)
    //             itemCategory.text(data.item_category)
    //             itemQuantity.text(data.qty)

    //             // hiddenItemCode.val(data.item_code)
    //             // hiddenItemCategory.val(data.item_category)
    //             // hiddenItemQuantity.val(data.qty)
    //             // hiddenItemDescription.val(data.item_description)
    //         }
    //     })
    // })
})

</script>
@endsection