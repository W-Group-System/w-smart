<div class="modal fade" id="view{{$purchase_request->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View for approval</h5>
            </div>
            <form method="POST" action="{{url('procurement/action/'.$purchase_request->id)}}">
                @csrf

                <div class="modal-body">
                    {{-- <p class="h5">Primary Information</p>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <p class="m-0 fw-bold">Purchase No.:</p>
                            {{str_pad($pr->id, 6, '0', STR_PAD_LEFT)}}
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6 mb-2">
                            <p class="m-0 fw-bold">Requestor Name:</p>
                            {{$pr->user->name}}
                        </div>
                        <div class="col-md-6">
                            <p class="m-0 fw-bold">Request Date Time:</p>
                            {{date('m/d/Y', strtotime($pr->created_at))}}
                        </div>
                        <div class="col-md-6 mb-2">
                            <p class="m-0 fw-bold">Remarks:</p>
                            {!! nl2br(e($pr->remarks)) !!}
                        </div>
                        <div class="col-md-6 mb-2">
                            <p class="m-0 fw-bold">Request Due Date:</p>
                            {{date('m/d/Y', strtotime($pr->due_date))}}
                        </div>
                        <div class="col-md-6 mb-2">
                            <p class="m-0 fw-bold">Assigned To:</p>
                            {{optional($pr->assignedTo)->name}}
                        </div>
                    </div>
    
                    <p class="h5 mt-3">Classification</p>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <p class="m-0 fw-bold">Subsidiary:</p>
                            {{$pr->subsidiary}}
                        </div>
                        <div class="col-md-6 mb-2">
                            <p class="m-0 fw-bold">Class:</p>
                            
                        </div>
                        <div class="col-md-6 mb-2">
                            <p class="m-0 fw-bold">Department:</p>
                            {{$pr->department->name}}
                        </div>
                        <div class="col-md-6 mb-2">
                            <p class="m-0 fw-bold">Return Remarks:</p>
                            {!! nl2br(e($pr->return_remarks)) !!}
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="padding:5px 10px;">Item Code</th>
                                            <th style="padding:5px 10px;">Item Category</th>
                                            <th style="padding:5px 10px;">Item Description</th>
                                            <th style="padding:5px 10px;">Quantity</th>
                                            <th style="padding:5px 10px;">Unit of Measurement</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($pr->purchaseItems->isNotEmpty())
                                            @foreach ($pr->purchaseItems as $item)
                                                <tr>
                                                    <td style="padding: 5px 10px;">{{$item->inventory->item_code}}</td>
                                                    <td style="padding: 5px 10px;">{{$item->inventory->item_category}}</td>
                                                    <td style="padding: 5px 10px;">{{$item->inventory->item_description}}</td>
                                                    <td style="padding: 5px 10px;">{{$item->inventory->qty}}</td>
                                                    <td style="padding: 5px 10px;">{{$item->unit_of_measurement}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="padding:5px 10px;">Attachments</th>
                                            <th style="padding:5px 10px;">Document Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($pr->purchaseRequestFiles->isNotEmpty())
                                            @foreach ($pr->purchaseRequestFiles as $file)
                                                <tr>
                                                    <td style="padding: 5px 10px;">
                                                        <a href="{{url($file->file)}}" target="_blank">
                                                            <i class="bi bi-files"></i>
                                                        </a>
                                                    </td>
                                                    <td style="padding: 5px 10px;">{{$file->document_type}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}
    
                    {{-- <p class="h5 mt-3">Action</p>
                    <hr class="mt-0"> --}}
    
                    <div class="row">
                        <div class="col-lg-12">
                            Select action
                            <select data-placeholder="Select action" name="action" class="form-control chosen-select" onchange="actionFunction(this.value)">
                                <option value=""></option>
                                <option value="Approved">Approved</option>
                                <option value="Returned">Returned</option>
                            </select>
                        </div>
                        <div class="col-lg-12" id="returnRemarksCol" hidden>
                            Remarks
                            <textarea name="return_remarks" id="returnRemarks" class="form-control" cols="30" rows="10" ></textarea>
                        </div>
                    </div>
    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>