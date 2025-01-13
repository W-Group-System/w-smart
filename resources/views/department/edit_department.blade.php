{{-- EDIT --}}
<div class="modal fade" id="edit{{$department->id}}" tabindex="-1" aria-labelledby="addInventoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInventoryModalLabel">Edit department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDepartmentForm" action="{{url('/settings/update-department/'.$department->id)}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group">
                            <label for="deptCode">Department Code</label>
                            <input type="text" class="form-control form-control-sm" name="dept_code" id="deptCode" value="{{$department->code}}" required />
                        </div>
                        <div class="form-group">
                            <label for="deptName">Department Name</label>
                            <input type="text" class="form-control form-control-sm" name="dept_name" id="deptName" value="{{$department->name}}" required />
                        </div>
                        <div class="form-group">
                            <label for="deptName">Department Head</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <select data-placeholder="Select department head" name="department_head" class="form-select chosen-select" required>
                                        <option value=""></option>
                                        @foreach ($dept_head as $head)
                                            <option value="{{$head->id}}" @if($head->id == $department->department_head) selected @endif>{{$head->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subsidiary">Subsidiary</label>
                            <select class="form-select" id="subsidiary" name="subsidiary">
                                <option value=""></option>
                                @foreach ($subsidiary as $sub)
                                    <option value="{{$sub->subsidiary_id}}" @if($sub->subsidiary_id == $department->subsidiary_id) selected @endif>{{$sub->subsidiary_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="saveNewInventory">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>