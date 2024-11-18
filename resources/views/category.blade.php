@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    <h4 class="mb-4 mt-4">Category Management</h4>

    <div class="mb-4">
        <button class="btn btn-primary" id="newCategory">Create Category</button>
    </div>

    <div class="mb-4">
        <h5>Category</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Sub Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="categoryList">
            </tbody>
        </table>
    </div>
<div class="modal fade" id="addCategoryModal" aria-labelledby="addCategoryModalLabel" aria-hidden="true" style="z-index: 1600;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm">
                    @csrf
                    <div class="form-group">
                        <label for="categoryName">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" placeholder="Enter category name" required>
                    </div>
                    <div class="form-group" id="itemTableBody">
                        <div class="d-flex justify-content-start align-items-center">
                            <label for="subCategoryName" class="mb-0">Sub-category Name</label>
                            <button type="button" class="btn btn-outline-primary btn-sm mb-1" id="addSubCategoryButton">
                                <i class="fas fa-plus">+</i>
                            </button>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" id="subCategoryName" placeholder="Enter sub-category name">
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addSubCategoryModal" aria-labelledby="addSubCategoryModalLabel" aria-hidden="true" style="z-index: 1600;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New Sub-Category</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addSubCategoryForm">
                    @csrf
                    <div class="form-group" id="itemTableBodySubCategory">
                        <div class="d-flex justify-content-start align-items-center">
                            <label for="subCategoryName" class="mb-0">Sub-category Name</label>
                            <button type="button" class="btn btn-outline-primary btn-sm mb-1" id="addSubCategoryButtonV1">
                                <i class="fas fa-plus">+</i>
                            </button>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" id="subCategoryName" placeholder="Enter sub-category name" required>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/category.js') }}"></script>
@endpush
@endsection