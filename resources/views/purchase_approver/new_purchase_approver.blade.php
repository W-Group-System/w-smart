<div class="modal fade" id="new">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new approver</h5>
            </div>
            <form method="POST" action="{{ url('store_purchase_approver') }}" onsubmit="show()">
                @csrf 

                <div class="modal-body">
                    <button type="button" class="btn btn-sm btn-outline-success mb-2" id="addApproverBtn">
                        <i class="ti-plus"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger mb-2" id="removeApproverBtn">
                        <i class="ti-minus"></i>
                    </button>
    
                    <div id="approverContainer">
                        @if(count($purchase_approvers) > 0)
                            @foreach ($purchase_approvers as $purchase_approver)
                                <div class="row" id="approverRow_{{ $purchase_approver->level }}">
                                    <div class="col-lg-2">
                                        {{ $purchase_approver->level }}
                                    </div>
                                    <div class="col-lg-10 mb-2">
                                        <select data-placeholder="Select approver" name="approver[]" class="form-control js-example-basic-single" style="width: 100%; position: relative;">
                                            <option value=""></option>
                                            @foreach ($approvers as $approver)
                                                <option value="{{ $approver->id }}" @if($purchase_approver->user_id == $approver->id) selected @endif>{{ $approver->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row" id="approverRow_1">
                                <div class="col-lg-2">
                                    1
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
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>