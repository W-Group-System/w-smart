<div class="modal fade" id="editRole{{$role->id}}" tabindex="-1" aria-labelledby="createRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoleModalLabel">Edit Role</h5>
                </div>
                <form method="POST" action="{{url('update_role/'.$role->id)}}" onsubmit="show()">
                    @csrf 
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role">Role Name</label>
                            <input type="text" class="form-control" id="role" name="role" value="{{$role->role}}" readonly>
                        </div>
                        {{-- <div class="form-group">
                            <label for="features">Assign Permission</label>
                            @php
                                $features_ids = $role->permission->pluck('featureid')->toArray();
                            @endphp
                            <select data-placeholder="Choose permission" class="form-control js-example-basic-multiple" name="permission[]" style="position: relative; width:100%;" multiple required>
                                <option value=""></option>
                                @foreach ($features as $feature)
                                    <option value="{{$feature->id}}" @if(in_array($feature->id, $features_ids)) selected @endif>{{$feature->feature}}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="row">
                            @php
                                $module = $role->user_access_module->pluck('subfeature_id')->toArray();
                            @endphp
                            @foreach ($features as $feature)
                                <div class="col-lg-3">
                                    {{ $feature->feature }}
                                    <hr>

                                    <div class="row">
                                        @foreach ($feature->subfeature->where('status', null) as $subfeature)
                                            <div class="col-lg-12">
                                                <input type="checkbox" name="subfeature[{{ $feature->id }}][]" value="{{ $subfeature->id }}" @if(in_array($subfeature->id, $module)) checked @endif> {{ $subfeature->subfeature_name }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>