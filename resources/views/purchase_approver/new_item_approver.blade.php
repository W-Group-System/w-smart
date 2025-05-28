<div class="modal fade" id="newItem">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new approver</h5>
            </div>
            <form method="POST" action="{{ url('') }}" onsubmit="show()">
                @csrf 

                <div class="modal-body">
                    <div class="form-group">

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