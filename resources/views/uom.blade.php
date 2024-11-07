@extends('layouts.dashboard_layout')

@section('dashboard_content')
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
@endsection