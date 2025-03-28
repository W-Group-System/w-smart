<div class="modal fade" id="editPr{{$purchase_request->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Analyst</h5>
            </div>
            <form method="POST" action="{{url('procurement/edit-assigned/'.$purchase_request->id)}}" onsubmit="show()">
                @csrf 
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="assignedTo" class="form-label">Assigned To:</label>
                        <select data-placeholder="Select assigned to" class="form-control js-example-basic-single" name="assigned_to" style="width: 100%;" required>
                            <option value=""></option>
                            @foreach ($users->where('role', 3) as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
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