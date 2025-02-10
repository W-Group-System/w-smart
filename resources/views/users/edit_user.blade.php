<div class="modal fade" id="edit{{$user->id}}" onsubmit="show()">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
            </div>
            <form action="{{url('update_users/'.$user->id)}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter user name" value="{{$user->name}}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter user email" value="{{$user->email}}" required>
                    </div>
                    <div class="form-group">
                        <label for="">Position</label>
                        <input type="text" class="form-control" name="position" placeholder="Enter position (Ex: IT Engineer, System Developer)" value="{{$user->position}}" required>
                    </div>
                    <div class="form-group">
                        <label for="subsidiary">Subsidiary</label>
                        <select data-placeholder="Select subsidiary" class="form-chosen js-example-basic-single" name="subsidiary" style="position: relative; width:100%; height:auto;">
                            <option value=""></option>
                            @foreach ($subsidiaries as $sub)
                                <option value="{{$sub->subsidiary_id}}" @if($user->subsidiary == $sub->subsidiary_name) selected @endif>{{$sub->subsidiary_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="department">Department</label>
                        <select data-placeholder="Select department" class="form-select js-example-basic-single" name="department" style="position: relative; width:100%; height:auto;">
                            <option value=""></option>
                            @foreach ($departments as $department)
                                <option value="{{$department->id}}" @if($department->id == $user->department_id) selected @endif>{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>