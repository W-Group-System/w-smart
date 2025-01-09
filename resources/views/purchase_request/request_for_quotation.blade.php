<div class="modal fade" id="rfq{{$purchase_requests->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request For Quotation (RFQ)</h5>
            </div>
            <form method="POST" action="{{url('store-request-for-quotation')}}">
                @csrf 
                
                <input type="hidden" name="purchase_request_id" value="{{$purchase_requests->id}}">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <p class="m-0 fw-bold">Purchase No.:</p>
                            {{str_pad($purchase_requests->id, 6, '0', STR_PAD_LEFT)}}
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-4 mb-2">
                            <p class="m-0 fw-bold">Requestor Name:</p>
                            {{auth()->user()->name}}
                        </div>
                        <div class="col-md-4 mb-2">
                            <p class="m-0 fw-bold">Request Date/Time.:</p>
                            {{date('m/d/Y g:i:A', strtotime($purchase_requests->created_at))}}
                        </div>
                        <div class="col-md-4 mb-2">
                            <p class="m-0 fw-bold">Request Due Date:</p>
                            {{date('m/d/Y', strtotime($purchase_requests->due_date))}}
                        </div>
    
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <th style="padding: 5px 10px;">Vendor Name</th>
                                            <th style="padding: 5px 10px;">Vendor Email</th>
                                        </tr>
                                    </thead>
                                    {{-- {{dd($purchase_requests->rfqEmail)}} --}}
                                    <tbody id="vendorTbodyRow">
                                        @if($purchase_requests->rfqEmail->isNotEmpty())
                                            @foreach ($purchase_requests->rfqEmail as $rfqEmail)
                                                <tr>
                                                    <td style="padding: 5px 10px;">
                                                        <select name="vendor_name[]" class="form-select" onchange="getVendorEmail(this.value)" required>
                                                            <option value="">Select vendor name</option>
                                                            @foreach ($vendor_list as $key=>$vendor)
                                                                <option value="{{$key}}" @if($rfqEmail->vendor_id == $key) selected @endif>{{$vendor}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="padding: 5px 10px;">
                                                        <input type="hidden" name="vendor_email[]" value="{{$rfqEmail->vendor_email}}">
                                                        @php
                                                            $vendor_email = $rfqEmail->vendor_email;
                                                            $display_email = explode(',', $vendor_email);
                                                        @endphp
                                                        <p class="vendor_email">
                                                            @foreach ($display_email as $item)
                                                                {{$item}} <br>
                                                            @endforeach
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td style="padding: 5px 10px;">
                                                    <select name="vendor_name[]" class="form-select" onchange="getVendorEmail(this.value)" required>
                                                        <option value="">Select vendor name</option>
                                                        @foreach ($vendor_list as $key=>$vendor)
                                                            <option value="{{$key}}">{{$vendor}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td style="padding: 5px 10px;">
                                                    <input type="hidden" name="vendor_email[]">
                                                    <p class="vendor_email"></p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
    
                                <button type="button" class="btn btn-sm btn-success mt-2" id="addVendorBtn">
                                    Add row
                                </button>
                                <button type="button" class="btn btn-sm btn-danger mt-2" id="deleteVendorBtn">
                                    Delete row
                                </button>
                            </div>
                        </div>
    
                        <div class="col-md-12 mt-2">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="padding: 5px 10px" class="text-center">
                                                <input type="checkbox" name="all" id="itemCheckboxAll">
                                            </th>
                                            <th style="padding: 5px 10px;">Item Code</th>
                                            <th style="padding: 5px 10px;">Item Category</th>
                                            <th style="padding: 5px 10px;">Item Description</th>
                                            <th style="padding: 5px 10px;">Item Quantity</th>
                                            <th style="padding: 5px 10px;">Unit of Measurement</th>
                                        </tr>
                                    </thead>
                                    <tbody id="vendorTbodyRow">
                                        @if($purchase_requests->purchaseItems->isNotEmpty())
                                            @foreach ($purchase_requests->purchaseItems as $item)
                                                @php
                                                    $rfq_item = ($purchase_requests->rfqItem)->pluck('purchase_item_id')->toArray();
                                                @endphp
                                                <tr>
                                                    <td style="padding: 5px 10px" class="text-center">
                                                        <input type="checkbox" name="item_checkbox[]" class="itemCheckbox" @if(in_array($item->id, $rfq_item)) checked @endif value="{{$item->id}}">
                                                    </td>
                                                    <td style="padding: 5px 10px;">{{$item->item_code}}</td>
                                                    <td style="padding: 5px 10px;">{{$item->item_category}}</td>
                                                    <td style="padding: 5px 10px;">{{$item->item_description}}</td>
                                                    <td style="padding: 5px 10px;">{{$item->item_quantity}}</td>
                                                    <td style="padding: 5px 10px;">{{$item->unit_of_measurement}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td style="padding: 5px 10px;" class="text-center" colspan="6">No data available.</td>
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
                                            <th style="padding: 5px 10px;">Attachments</th>
                                            <th style="padding: 5px 10px;">Document Type</th>
                                            <th style="padding: 5px 10px;">Remove</th>
                                            <th style="padding: 5px 10px;">Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody id="vendorTbodyRow">
                                        @if($purchase_requests->purchaseRequestFiles->isNotEmpty())
                                            @foreach ($purchase_requests->purchaseRequestFiles as $item)
                                                @php
                                                    $rfq_files = ($purchase_requests->rfqFile)->pluck('purchase_request_file_id')->toArray();
                                                @endphp
                                                <tr>
                                                    <td style="padding: 5px 10px" class="text-center">
                                                        <input type="checkbox" name="file_checkbox[]" value="{{$item->id}}" @if(in_array($item->id, $rfq_files)) checked @endif class="fileCheckbox">
                                                    </td>
                                                    <td style="padding: 5px 10px;">
                                                        <a href="{{url($item->file)}}">
                                                            <i class="bi bi-files"></i>
                                                        </a>
                                                    </td>
                                                    <td style="padding: 5px 10px;">{{$item->document_type}}</td>
                                                    <td style="padding: 5px 10px;">
                                                        <button type="button" class="btn btn-sm btn-danger text-white" title="Remove File">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </td>
                                                    <td style="padding: 5px 10px;">
                                                        <button type="button" class="btn btn-sm btn-warning text-white" title="Edit File">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td style="padding: 5px 10px;" class="text-center" colspan="5">No data available.</td>
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