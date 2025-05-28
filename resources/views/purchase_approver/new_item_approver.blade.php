<div class="modal fade" id="newItemApprover">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new item approver</h5>
            </div>
            <form method="POST" action="{{ url('store_item_approver') }}" onsubmit="show()">
                @csrf 

                <div class="modal-body">
                    <div class="form-group">
                        Select Subsidiary
                        <select data-placeholder="Select subsidiary" name="subsidiary" class="form-control js-example-basic-single" style="width: 100%;" required>
                            <option value=""></option>
                            @foreach ($subsidiaries as $subsidiary)
                                <option value="{{ $subsidiary->subsidiary_id }}">{{ $subsidiary->subsidiary_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        Select User
                        <select data-placeholder="Select user" name="employee[]" class="form-control js-example-basic-multiple" style="width: 100%;" multiple>
                            <option value=""></option>
                            @foreach ($approvers as $approver)
                                <option value="{{ $approver->id }}">{{ $approver->name }}</option>
                            @endforeach
                        </select>
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