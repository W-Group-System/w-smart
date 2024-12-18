<div class="modal fade" id="editFile{{$file->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit file</h5>
            </div>
            <form method="POST" action="{{url('procurement/update-files/'.$file->id)}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body">
                    <div class="form-group">
                        Attachments
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="saveNewInventory">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>