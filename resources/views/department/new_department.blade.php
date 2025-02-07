<div class="modal fade" id="newDepartmentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInventoryModalLabel">Add new department</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <form id="addDepartmentForm" action="{{url('settings/store-department')}}" method="POST" onsubmit="show()">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="deptCode">Department Code</label>
                        <input type="text" name="dept_code" class="form-control form-control-sm" id="deptCode" required />
                    </div>
                    <div class="form-group">
                        <label for="deptName">Department Name</label>
                        <input type="text" name="dept_name" class="form-control form-control-sm" id="deptName" required />
                    </div>
                    <div class="form-group">
                        <label for="deptName">Department Head</label>
                        <select data-placeholder="Select department head" name="department_head" class="form-select js-example-basic-single" style="position: relative; width:100%;" required>
                            <option value=""></option>
                            @foreach ($dept_head as $head)
                                <option value="{{$head->id}}">{{$head->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subsidiary">Subsidiary</label>
                        <select data-placeholder="Select subsidiary" class="form-select js-example-basic-single" id="subsidiary" name="subsidiary" style="position: relative; width:100%;">
                            <option value=""></option>
                            @foreach ($subsidiary->where('status', null) as $sub)
                                <option value="{{$sub->subsidiary_id}}">{{$sub->subsidiary_name}}</option>
                            @endforeach
                        </select>
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