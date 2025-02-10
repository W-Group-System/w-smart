<div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoleModalLabel">Add Role</h5>
                </div>
                <form method="POST" action="{{url('store_role')}}" onsubmit="show()">
                    @csrf 
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role">Role Name</label>
                            <input type="text" class="form-control" id="role" name="role" required>
                        </div>
                        <div class="form-group">
                            <label for="features">Assign Permission</label>
                            <select data-placeholder="Choose permission" class="form-control js-example-basic-multiple" name="permission[]" style="position: relative; width:100%;" multiple required>
                                <option value=""></option>
                                @foreach ($features as $feature)
                                    <option value="{{$feature->id}}">{{$feature->feature}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>