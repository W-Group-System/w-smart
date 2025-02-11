{{-- @extends('layouts.dashboard_layout')

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
@endsection --}}

@extends('layouts.header')

@section('content')
    <div class="row mb-3">
        <div class="col-lg-3">
            <div class="card card-tale">
                <div class="card-body">
                    <p class="mb-4">Number of Categories</p>
                    <p class="fs-30 mb-2">0</p>
                    <p>as of ({{date('M d Y')}})</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <p class="mb-4">Number of Active Categories</p>
                    <p class="fs-30 mb-2">0</p>
                    <p>as of ({{date('M d Y')}})</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-light-danger">
                <div class="card-body">
                    <p class="mb-4">Number of Inactive Categories</p>
                    <p class="fs-30 mb-2">0</p>
                    <p>as of ({{date('M d Y')}})</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Category Management</h4>

                <div class="mb-4">
                    <button class="btn btn-outline-success" type="button" data-toggle="modal" data-target="#addCategoryModal">
                        <i class="ti-plus"></i>
                        Create Category
                    </button>
                </div>
            
                <div class="mb-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm" id="tableWithSearch">
                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th>Name</th>
                                    <th>Sub Category</th>
                                </tr>
                            </thead>
                            <tbody id="categoryList">
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editCategory{{$category->id}}">
                                                <i class="ti-pencil-alt"></i>
                                            </button>
                                        </td>
                                        <td>{{$category->name}}</td>
                                        <td>
                                            @foreach ($category->subCategory as $subcategory)
                                                {{$subcategory->name}} <br>
                                            @endforeach
                                        </td>

                                        @include('category.edit_category')
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('category.new_category')
@endsection

@section('js')
<script>
    const container = document.querySelector("#subCategoryContainer")

    function addSubCategory()
    {
        const newInput = document.createElement("div")
        newInput.classList.add('input-group','mb-2')
        newInput.innerHTML = `<input type="text" name="sub_category[]" class="form-control" placeholder="Enter sub-category name" required>`

        container.appendChild(newInput)
    }

    function removeSubCategory()
    {
        const childrenSubCategory = container.children

        if (childrenSubCategory.length > 1)
        {
            container.removeChild(container.lastChild)
        }
    }

    function editAddSubCategory(id)
    {
        const editContainer = document.querySelector("#editSubCategoryContainer"+id)

        const newInput = document.createElement("div")
        newInput.classList.add('input-group','mb-2')
        newInput.innerHTML = `<input type="text" name="sub_category[]" class="form-control" placeholder="Enter sub-category name" required>`

        editContainer.appendChild(newInput)
    }

    function editRemoveSubCategory(id)
    {
        const editContainer = document.querySelector("#editSubCategoryContainer"+id)
        const childrenSubCategory = editContainer.children

        if (childrenSubCategory.length > 1)
        {
            editContainer.removeChild(editContainer.lastChild)
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        const table = document.querySelector("#tableWithSearch")
        
        $(table).DataTable({
            dom: 'Bfrtip',
            ordering: true,
            pageLength: 25,
            paging: true,
        });
    })
</script>
@endsection