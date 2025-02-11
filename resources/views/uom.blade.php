{{-- @extends('layouts.dashboard_layout')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4 mt-4">UOM Management</h4>

    <div class="mb-4">
        <button class="btn btn-primary" id="newUOMButton">Create UOM</button>
    </div>

    <div class="mb-4">
        <input type="text" class="form-control" id="searchPrimaryUOM" placeholder="Search Primary UOM">
    </div>

    <div class="mb-4">
        <h5>List of UOMs</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Primary UOM</th>
                    <th>Primary Value</th>
                    <th>Secondary UOM</th>
                    <th>Secondary Value</th>
                    <th>Tertiary UOM</th>
                    <th>Tertiary Value</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="uomList">
            </tbody>
        </table>
    </div>

    <!-- UOM Modal -->
    <div class="modal fade" id="addUOMModal" aria-labelledby="addUOMModalLabel" aria-hidden="true"
        style="z-index: 1600;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUOMModalLabel">Add New UOM</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addUOMForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="primaryUOM">Primary UOM</label>
                            <input type="text" class="form-control" id="primaryUOM" placeholder="Enter primary UOM name"
                                required>
                            <input type="number" class="form-control mt-2" id="primaryUOMValue"
                                placeholder="Enter primary UOM value" required step="any">
                        </div>

                        <div class="form-group mb-3">
                            <label for="secondaryUOM">Secondary UOM</label>
                            <input type="text" class="form-control" id="secondaryUOM"
                                placeholder="Enter secondary UOM name" required>
                            <input type="number" class="form-control mt-2" id="secondaryUOMValue"
                                placeholder="Enter secondary UOM value" required step="any">
                        </div>

                        <div class="form-group mb-3">
                            <label for="tertiaryUOM">Tertiary UOM (Optional)</label>
                            <input type="text" class="form-control" id="tertiaryUOM"
                                placeholder="Enter tertiary UOM name">
                            <input type="number" class="form-control mt-2" id="tertiaryUOMValue"
                                placeholder="Enter tertiary UOM value" step="any">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="saveUOMButton" disabled>Save UOM</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- UOM Details Modal -->
    <div class="modal fade" id="uomDetailsModal" aria-labelledby="uomDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uomDetailsModalLabel">UOM Variants</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="uomDetailsContent">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>



@push('scripts')
    <script src="{{ asset('js/uom.js') }}"></script>
@endpush
@endsection --}}

@extends('layouts.header')

@section('content')
    <div class="row mb-3">
        <div class="col-lg-3">
            <div class="card card-tale">
                <div class="card-body">
                    <p class="mb-4">Number of UOM</p>
                    <p class="fs-30 mb-2">0</p>
                    <p>as of ({{date('M d Y')}})</p>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <p class="mb-4">Number of Active UOM</p>
                    <p class="fs-30 mb-2">0</p>
                    <p>as of ({{date('M d Y')}})</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-light-danger">
                <div class="card-body">
                    <p class="mb-4">Number of Inactive UOM</p>
                    <p class="fs-30 mb-2">0</p>
                    <p>as of ({{date('M d Y')}})</p>
                </div>
            </div>
        </div> --}}
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">UOM Management</h4>

                <button class="btn btn-outline-success" data-toggle="modal" data-target="#addUOMModal">
                    <i class="ti-plus"></i>
                    Create UOM
                </button>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="tableWithSearch">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Primary UOM</th>
                                <th>Primary Value</th>
                                <th>Secondary UOM</th>
                                <th>Secondary Value</th>
                                <th>Tertiary UOM</th>
                                <th>Tertiary Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($uoms as $uom)
                                {{-- <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('uom.new_uom')
@endsection

@section('js')
<script>
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