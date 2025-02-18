<div class="modal fade" id="rfq{{$purchase_request->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request For Quotation (RFQ)</h5>
            </div>
            <form method="POST" action="{{url('store-request-for-quotation')}}" onsubmit="show()">
                @csrf 
                
                <input type="hidden" name="purchase_request_id" value="{{$purchase_request->id}}">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <p class="m-0 fw-bold">Purchase No.:</p>
                            {{str_pad($purchase_request->id, 6, '0', STR_PAD_LEFT)}}
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-4 mb-2">
                            <p class="m-0 fw-bold">Requestor Name:</p>
                            {{auth()->user()->name}}
                        </div>
                        <div class="col-md-4 mb-2">
                            <p class="m-0 fw-bold">Request Date/Time.:</p>
                            {{date('m/d/Y g:i:A', strtotime($purchase_request->created_at))}}
                        </div>
                        <div class="col-md-4 mb-2">
                            <p class="m-0 fw-bold">Request Due Date:</p>
                            {{date('m/d/Y', strtotime($purchase_request->due_date))}}
                        </div>
    
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <th>Vendor Name</th>
                                            <th>Vendor Email</th>
                                        </tr>
                                    </thead>
                                    {{-- {{dd($purchase_request->rfqEmail)}} --}}
                                    <tbody id="vendorTbodyRow">
                                        @if($purchase_request->rfqEmail->isNotEmpty())
                                            @foreach ($purchase_request->rfqEmail as $rfqEmail)
                                                <tr>
                                                    <td>
                                                        {{-- <select name="vendor_name[]" class="form-select" onchange="getVendorEmail(this.value)" required>
                                                            <option value="">Select vendor name</option>
                                                            @foreach ($vendor_list as $key=>$vendor)
                                                                <option value="{{$vendor->id}}" @if($rfqEmail->vendor_id == $vendor->id) selected @endif>{{$vendor->vendorSupplier->corporate_name}}</option>
                                                            @endforeach
                                                        </select> --}}
                                                    </td>
                                                    <td>
                                                        {{-- <input type="hidden" name="vendor_email[]" value="{{$rfqEmail->vendor_email}}">
                                                        @php
                                                            $vendor_email = $rfqEmail->vendor_email;
                                                            $display_email = explode(',', $vendor_email);
                                                        @endphp
                                                        <p class="vendor_email">
                                                            @foreach ($display_email as $item)
                                                                {{$item}} <br>
                                                            @endforeach
                                                        </p> --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>
                                                    <select data-placeholder="Select vendor name" name="vendor_name[]" class="form-control js-example-basic-single" style="width: 100%;" required>
                                                        <option value=""></option>
                                                        @foreach ($suppliers as $key=>$supplier)
                                                            <option value="{{$supplier->id}}">{{$supplier->corporate_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="vendor_email[]">
                                                    <p class="vendor_email"></p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
    
                                <button type="button" class="btn btn-sm btn-success mt-2" id="addVendorBtn">
                                    <i class="ti-plus"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger mt-2" id="deleteVendorBtn">
                                    <i class="ti-minus"></i>
                                </button>
                            </div>
                        </div>
    
                        <div class="col-md-12 mt-2">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <input type="checkbox" name="all" id="itemCheckboxAll">
                                            </th>
                                            <th>Item Code</th>
                                            <th>Item Category</th>
                                            <th>Item Description</th>
                                            <th>Item Quantity</th>
                                            <th>Unit of Measurement</th>
                                        </tr>
                                    </thead>
                                    <tbody id="vendorTbodyRow">
                                        @if($purchase_request->purchaseItems->isNotEmpty())
                                            @foreach ($purchase_request->purchaseItems as $item)
                                                @php
                                                    $rfq_item = ($purchase_request->rfqItem)->pluck('purchase_item_id')->toArray();
                                                @endphp
                                                <tr>
                                                    <td class="text-center">
                                                        <input type="checkbox" name="item_checkbox[]" class="itemCheckbox" @if(in_array($item->id, $rfq_item)) checked @endif value="{{$item->id}}">
                                                    </td>
                                                    <td>{{$item->inventory->item_code}}</td>
                                                    <td>{{$item->inventory->item_category}}</td>
                                                    <td>{{$item->inventory->item_description}}</td>
                                                    <td>{{$item->inventory->qty}}</td>
                                                    <td>{{$item->unit_of_measurement}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="text-center" colspan="6">No data available.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
    
                        <div class="col-md-12 mt-2">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="padding: 5px 10px" class="text-center">
                                                <input type="checkbox" name="all" id="fileCheckboxAll">
                                            </th>
                                            <th>Attachments</th>
                                            <th>Document Type</th>
                                            <th>Remove</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody id="vendorTbodyRow">
                                        @if($purchase_request->purchaseRequestFiles->isNotEmpty())
                                            @foreach ($purchase_request->purchaseRequestFiles as $item)
                                                @php
                                                    $rfq_files = ($purchase_request->rfqFile)->pluck('purchase_request_file_id')->toArray();
                                                @endphp
                                                <tr>
                                                    <td style="padding: 5px 10px" class="text-center">
                                                        <input type="checkbox" name="file_checkbox[]" value="{{$item->id}}" @if(in_array($item->id, $rfq_files)) checked @endif class="fileCheckbox">
                                                    </td>
                                                    <td>
                                                        <a href="{{url($item->file)}}" target="_blank">
                                                            <i class="ti-files"></i>
                                                        </a>
                                                    </td>
                                                    <td>{{$item->document_type}}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger text-white" title="Remove File">
                                                            <i class="ti-trash"></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-warning text-white" title="Edit File">
                                                            <i class="ti-pencil-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="5">No data available.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>