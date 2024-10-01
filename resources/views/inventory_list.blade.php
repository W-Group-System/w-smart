@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">
    <!-- Include the Inventory Header -->
    @include('layouts.inventory_header')

    <!-- Main Content Section -->
    <div class="card p-4 mt-4">
        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>Date</th>
                        <th>Item Code</th>
                        <th>Item Description</th>
                        <th>Item Category</th>
                        <th>QTY</th>
                        <th>UOM</th>
                        <th>Cost</th>
                        <th>Usage</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Data Row, dynamic data will be added here -->
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>00/00/0000</td>
                        <td>000000</td>
                        <td>Item Description</td>
                        <td>Item Category</td>
                        <td>00.00</td>
                        <td>PCS</td>
                        <td>00.00</td>
                        <td>Usage</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-link dropdown-toggle" type="button" id="actionMenu"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionMenu">
                                    <li><a class="dropdown-item" href="#">Edit</a></li>
                                    <li><a class="dropdown-item" href="#">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <div class="d-flex justify-content-between">
            <div>Rows per page:
                <select class="form-select form-select-sm d-inline-block w-auto">
                    <option>5</option>
                    <option>10</option>
                    <option>20</option>
                </select>
            </div>
            <div>Showing 1-5 of 13 items</div>
            <div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/inventory.js') }}"></script>
@endpush