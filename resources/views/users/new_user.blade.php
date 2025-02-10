<div class="modal fade" id="newUser">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new User</h5>
            </div>
            <form action="{{url('store_users')}}" method="POST" onsubmit="show()">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter user name" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter user email" required>
                    </div>
                    <div class="form-group">
                        <label for="">Position</label>
                        <input type="text" class="form-control" name="position" placeholder="Enter position (Ex: IT Engineer, System Developer)" required>
                    </div>
                    <div class="form-group">
                        <label for="subsidiary">Subsidiary</label>
                        <select data-placeholder="Select subsidiary" class="form-select js-example-basic-single" name="subsidiary" style="position: relative; width:100%; height:auto;">
                            <option value=""></option>
                            @foreach ($subsidiaries as $sub)
                                <option value="{{$sub->subsidiary_id}}">{{$sub->subsidiary_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="department">Department</label>
                        <select data-placeholder="Select department" class="form-select js-example-basic-single" name="department" style="position: relative; width:100%; height:auto;">
                            <option value=""></option>
                            @foreach ($departments as $department)
                                <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>