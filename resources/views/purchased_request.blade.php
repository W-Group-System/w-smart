@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    @include('layouts.procurement_header')

    <!-- Main Content Section -->
    <div class="card p-4" style="border: 1px solid #ddd; border-radius: 20px; margin-top: -25px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h6 class="fw-bold me-3">Procurement List</h6>
                <input type="hidden" id="userId" value="{{ auth()->user()->id }}">
                <input type="hidden" id="userName" value="{{ auth()->user()->name }}">
                <input type="hidden" id="usersubsidiary" value="{{ auth()->user()->subsidiary }}">
                <input type="hidden" id="usersubsidiaryid" value="{{ auth()->user()->subsidiaryid }}">
                <div class="input-group" style="max-width: 350px; position: relative;">
                    <input type="text" class="form-control" placeholder="Search here" aria-label="Search"
                        id="searchInput" style="padding-right: 100px; border-radius: 20px; height: 35px;">
                    <img src="{{ asset('images/search.svg') }}" alt="Search Icon"
                        style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px;">
                </div>
                <div class="btn-group ms-3" style="height: 35px; position: relative;">
                    <button type="button" class="btn btn-outline-secondary" id="downloadButton"
                        style="height: 35px; padding: 0 15px;" data-bs-toggle="popover" data-bs-html="true"
                        data-bs-trigger="focus" data-bs-content='
                        <div style="font-family: "Inter", sans-serif; color: #79747E;">
                            <button class="btn btn-sm btn-light" id="downloadCSV" style="display: flex; justify-content: space-between; width: 100%; align-items: center; border-radius: 8px; color: #79747E;">
                                Download CSV 
                                <img src="{{ asset('images/download.svg') }}" style="width: 16px; height: 16px; margin-left: 8px;" alt="Download CSV">
                            </button>
                            <button class="btn btn-sm btn-light mt-1" id="downloadExcel" style="display: flex; justify-content: space-between; width: 100%; align-items: center; border-radius: 8px; color: #79747E;">
                                Download Excel 
                                <img src="{{ asset('images/download.svg') }}" style="width: 16px; height: 16px; margin-left: 8px;" alt="Download Excel">
                            </button>
                            <button class="btn btn-sm btn-light mt-1" id="downloadPDF" style="display: flex; justify-content: space-between; width: 100%; align-items: center; border-radius: 8px; color: #79747E;">
                                Download PDF 
                                <img src="{{ asset('images/download.svg') }}" style="width: 16px; height: 16px; margin-left: 8px;" alt="Download PDF">
                            </button>
                        </div>'>
                        Download
                    </button>
                    <button type="button" class="btn btn-outline-secondary" style="height: 35px; padding: 0 15px;">
                        Print
                    </button>
                </div>
            </div>

            <div class="d-flex align-items-center">
                <select class="form-select me-3" id="subsidiary"
                    style="width: 150px; height: 35px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); color: #6c757d; border-radius: 25px; font-size: 14px;">
                    <option selected value="1">HO</option>
                    <option value="2">WTCC</option>
                    <option value="3">CITI</option>
                    <option value="4">WCC</option>
                    <option value="5">WFA</option>
                    <option value="6">WOI</option>
                    <option value="7">WGC</option>
                </select>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPurchaseRequest" id="addPR"
                    style="height: 35px; padding: 0 15px; display: flex; align-items: center; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); font-size: 14px;">
                    Add New PR
                </button>
            </div>

        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="border-collapse: collapse; min-width: 1000px;">
                <thead class="table-light">
                    <tr>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Action<i class="bi bi-three-dots-vertical"></i></th>
                        </th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Request Date <i class="bi bi-three-dots-vertical"></i></th>
                        </th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            PR Number <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Item Description <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Due Date <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Requestor Name <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Department <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Subsidiary <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Amount <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Expedited <i class="bi bi-three-dots-vertical"></i></th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Status </th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Assigned to (Buyer) </th>
                        <th
                            style="text-align: center; padding: 8px 10px; border: none; font-weight: 400; color: #637281;">
                            Assigned Date/Time </th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($purchase_requests) > 0)
                        @foreach ($purchase_requests as $pr)
                            <tr>
                                <td style="text-align: center; padding: 5px 10px;">
                                    <a href="{{url('procurement/show-purchase-request/'.$pr->id)}}" class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    
                                    @if($pr->status == 'Returned')
                                    <button type="button" class="btn btn-sm btn-warning text-white" title="Edit" data-bs-toggle="modal" data-bs-target="#editPurchaseRequest{{$pr->id}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    @endif
                                </td>
                                <td style="text-align: center; padding: 5px 10px;">{{date('m/d/Y', strtotime($pr->created_at))}}</td>
                                <td style="text-align: center; padding: 5px 10px;">{{str_pad($pr->id,6,'0',STR_PAD_LEFT)}}</td>
                                <td style="text-align: center; padding: 5px 10px;">
                                    @foreach ($pr->purchaseItems as $item)
                                        {{$item->inventory->item_description}} <br>
                                    @endforeach
                                </td>
                                <td style="text-align: center; padding: 5px 10px;">{{date('m/d/Y', strtotime($pr->due_date))}}</td>
                                <td style="text-align: center; padding: 5px 10px;">{{$pr->user->name}}</td>
                                <td style="text-align: center; padding: 5px 10px;">{{$pr->department->name}}</td>
                                <td style="text-align: center; padding: 5px 10px;">{{$pr->subsidiary}}</td>
                                <td style="text-align: center; padding: 5px 10px;">0.00</td>
                                <td style="text-align: center; padding: 5px 10px;">Expedited</td>
                                <td style="text-align: center; padding: 5px 10px;">{{$pr->status}}</td>
                                <td style="text-align: center; padding: 5px 10px;">{{optional($pr->assignedTo)->name}}</td>
                                <td style="text-align: center; padding: 5px 10px;">{{date('m/d/Y', strtotime($pr->created_at))}}</td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td class="text-center" colspan="13">No data available.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <hr style="border-top: 1px solid #ddd; margin-top: 10px; margin-bottom: 10px;">

        <div class="d-flex justify-content-end align-items-center mt-3 border-top pt-3">
            <div class="d-flex align-items-center me-3">
                <span>Rows per page:</span>
                <select class="form-select form-select-sm d-inline-block w-auto ms-2" style="border-radius: 5px;">
                    <option>5</option>
                    <option>10</option>
                    <option>20</option>
                </select>
            </div>
            <div class="me-3 dynamic-rows-info">{{$purchase_requests->firstItem()}}-{{$purchase_requests->lastItem()}} of {{$purchase_requests->total()}}</div>
            {!! $purchase_requests->links() !!}
        </div>
    </div>
</div>

@foreach ($purchase_requests as $pr)
@include('purchase_request.edit_purchase_request')
@endforeach

@include('purchase_request.new_purchase_request')
@endsection

@push('scripts')
    {{-- <script src="{{ asset('js/purchaseRequest.js') }}"></script> --}}
<script src="{{asset('js/chosen.jquery.js')}}"></script>
<script>
function addRow(id)
{
    var newRow = `
            <tr>
                <td style="padding: 5px 10px">
                    <p class="item_code"></p>
                </td>
                <td style="padding: 5px 10px">
                    <p class="item_category"></p>
                </td>
                <td style="padding: 5px 10px">
                    <select data-placeholder="Select item description" name="inventory_id[]" class="form-select chosen-select item-description" >
                        <option value=""></option>
                        @foreach ($inventory_list as $inventory)
                            <option value="{{$inventory->inventory_id}}">{{$inventory->item_description}}</option>
                        @endforeach
                    </select>
                </td>
                <td style="padding: 5px 10px" >
                    <p class="item_quantity"></p>
                </td>
                <td style="padding: 5px 10px">
                    <select data-placeholder="Select unit of measurement" name="unit_of_measurement[]" class="form-select chosen-select" required>
                        <option value=""></option>
                        <option value="KG">KG</option>
                        <option value="G">Grams</option>
                    </select>
                </td>
            </tr>
        `;

    $('#tbodyAddRow'+id).append(newRow)
}

function deleteRow(id)
{
    var row = $('#tbodyAddRow'+id).children();
        
    if (row.length > 1) {
        row.last().remove()
    }
}

function removeFiles(id)
{
    // console.log('dasdad');
    var form = $("#deleteForm"+id)[0];

    Swal.fire({
        title: "Are you sure?",
        text: "The file will be deleted",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit()
        }
    });
    
}

$(document).ready(function() {
    $("#addRowBtn").on('click', function() {
        // console.log('sadasd');
        
        var newRow = `
            <tr>
                <td style="padding: 5px 10px">
                    <p class="item_code"></p>
                </td>
                <td style="padding: 5px 10px">
                    <p class="item_category"></p>
                </td>
                <td style="padding: 5px 10px">
                    <select data-placeholder="Select item description" name="inventory_id[]" class="form-select chosen-select item-description" >
                        <option value=""></option>
                        @foreach ($inventory_list as $inventory)
                            <option value="{{$inventory->inventory_id}}">{{$inventory->item_description}}</option>
                        @endforeach
                    </select>
                </td>
                <td style="padding: 5px 10px" >
                    <p class="item_quantity"></p>
                </td>
                <td style="padding: 5px 10px">
                    <select data-placeholder="Select unit of measurement" name="unit_of_measurement[]" class="form-select chosen-select" required>
                        <option value=""></option>
                        <option value="KG">KG</option>
                        <option value="G">Grams</option>
                    </select>
                </td>
            </tr>
        `;

        $('#tbodyAddRow').append(newRow)
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

    
})

function itemDescription(value)
{
    var itemCode = $(event.target).closest('tr').find('.item_code')
    var itemCategory = $(event.target).closest('tr').find('.item_category')
    var itemQuantity = $(event.target).closest('tr').find('.item_quantity')

    // var hiddenItemCode = $('[name="item_code[]"]')
    // var hiddenItemCategory = $('[name="item_category[]"]')
    // var hiddenItemQuantity = $('[name="item_quantity[]"]')
    // var hiddenItemDescription = $('[name="item_description[]"]')
    
    $.ajax({
        type: "POST",
        url: "{{route('refreshInventory')}}",
        data: {
            id: value
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            itemCode.text(data.item_code)
            itemCategory.text(data.item_category)
            itemQuantity.text(data.qty)

            // hiddenItemCode.val(data.item_code)
            // hiddenItemCategory.val(data.item_category)
            // hiddenItemQuantity.val(data.qty)
            // hiddenItemDescription.val(data.item_description)
        }
    })
}

</script>
@endpush