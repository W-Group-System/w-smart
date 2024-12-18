<div class="modal fade" id="editPr{{$purchase_requests->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit purchase request</h5>
            </div>
            <form method="POST" action="{{url('procurement/edit-assigned/'.$purchase_requests->id)}}">
                @csrf 
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="assignedTo" class="form-label">Assigned To:</label>
                        <select class="form-select" id="assignedTo" name="assigned_to" required>
                            <option value="">Assigned To</option>
                            @foreach ($users as $key=>$user)
                                <option value="{{$key}}">{{$user}}</option>
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