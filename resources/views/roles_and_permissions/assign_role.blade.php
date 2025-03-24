<div class="modal fade" id="assignRoleModal" tabindex="-1" aria-labelledby="assignRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignRoleModalLabel">Assign Role to Employee</h5>
                </div>
                <form action="{{ url('assign_role') }}" method="POST" onsubmit="show()">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="employee">Employee</label>
                            <select data-placeholder="Select employee" name="employee" class="form-control js-example-basic-single" style="position: relative; width:100%;" required>
                                <option value=""></option>
                                @foreach ($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="assignRole">Role</label>
                            <select data-placeholder="Select roles" name="role" class="form-control js-example-basic-single" style="position: relative; width:100%;" required>
                                <option value=""></option>
                                @foreach ($roles->where('status',null) as $role)
                                    <option value="{{$role->id}}">{{$role->role}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Assign Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>