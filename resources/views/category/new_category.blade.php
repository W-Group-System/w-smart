<div class="modal fade" id="addCategoryModal" aria-labelledby="addCategoryModalLabel" aria-hidden="true" style="z-index: 1600;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{url('store_category')}}" onsubmit="show()">
                @csrf
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="categoryName">Category Name</label>
                        <input type="text" name="category_name" class="form-control" placeholder="Enter category name" required>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-start align-items-center">
                            <label for="subCategoryName" class="mb-0">Sub-category Name</label>
    
                            <button type="button" class="btn btn-outline-primary btn-sm mb-1" onclick="addSubCategory()">
                                <i class="ti-plus"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm mb-1" onclick="removeSubCategory()">
                                <i class="ti-trash"></i>
                            </button>
                        </div>
    
                        <div id="subCategoryContainer">
                            <div class="input-group mb-2">
                                <input type="text" name="sub_category[]" class="form-control" placeholder="Enter sub-category name" required>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>