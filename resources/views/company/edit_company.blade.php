<div class="modal fade" id="edit{{$comp->subsidiary_id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCompanyModalLabel">Edit Company</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addCompanyForm" method="POST" action="{{url('update-company/'.$comp->subsidiary_id)}}">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="companyName">Company Name</label>
                        <input type="text" class="form-control form-control-sm" name="subsidiary" id="companyName" placeholder="Enter company name" value="{{$comp->subsidiary_name}}" required>
                    </div>
                    <div class="form-group">
                        <label for="companyName">Company Address</label>
                        <textarea name="address" class="form-control" cols="30" rows="10" placeholder="Enter company address" required>{{$comp->address}}</textarea>
                    </div>
            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Company</button>
                </div>
            </form>
        </div>
    </div>
</div>