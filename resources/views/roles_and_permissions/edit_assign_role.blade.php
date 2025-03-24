<div class="modal fade" id="editAssign{{ $employee->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Update Assign</h6>
            </div>
            <form action="{{ url('assign_role') }}" method="POST" onsubmit="show()">
                @csrf 

                <input type="hidden" name="employee" value="{{ $employee->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="assignRole">Role</label>
                        <select data-placeholder="Select roles" name="role" class="form-control js-example-basic-single" style="position: relative; width:100%;" required>
                            <option value=""></option>
                            @foreach ($roles->where('status',null) as $role)
                                <option value="{{$role->id}}" @if($employee->role == $role->id) selected @endif>{{$role->role}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>