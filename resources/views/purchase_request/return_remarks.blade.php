<div class="modal fade" id="returnRemarks{{$purchase_requests->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Return remarks</h5>
            </div>
            <form method="POST" action="{{url('return_purchase_request/'.$purchase_requests->id)}}">
                @csrf 

                <div class="modal-body">
                    Remarks 
                    <textarea name="remarks" class="form-control" cols="30" rows="10"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>