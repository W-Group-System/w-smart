<div class="modal fade" id="editCategory{{$category->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryLabel">Edit Category</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{url('update_category/'.$category->id)}}" onsubmit="show()">
                @csrf
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="categoryName">Category Name</label>
                        <input type="text" name="category_name" class="form-control" placeholder="Enter category name" value="{{$category->name}}" required>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-start align-items-center">
                            <label for="subCategoryName" class="mb-0">Sub-category Name</label>
    
                            <button type="button" class="btn btn-outline-primary btn-sm mb-1" id="editAddSubCategory" onclick="editAddSubCategory({{$category->id}})">
                                <i class="ti-plus"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm mb-1" id="editRemoveSubCategory" onclick="editRemoveSubCategory({{$category->id}})">
                                <i class="ti-trash"></i>
                            </button>
                        </div>
                        <div id="editSubCategoryContainer{{$category->id}}">
                            @if($category->subCategory->isEmpty())
                                <div class="input-group mb-2">
                                    <input type="text" name="sub_category[]" class="form-control" placeholder="Enter sub-category name" required>
                                </div>
                            @else
                                @foreach ($category->subCategory as $subcategory)
                                    <div class="input-group mb-2">
                                        <input type="text" name="sub_category[]" class="form-control" placeholder="Enter sub-category name" value="{{$subcategory->name}}" required>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>