@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="col-12 grid-margin stretch-card">
    <div class="card mt-3">
        <div class="card-body">
            <h4 class="card-title d-flex justify-content-between align-items-center">
            View Supplier Evaluation
                <div align="right">
                    <a href="{{ url('procurement/edit_supplier_evaluation/' . $data->id) }}" class="text-decoration-none">
                        <button class="btn btn-warning text-white">Edit</button>
                    </a>
                    <button type="button" class="btn btn-success text-white" title="Approved Supplier" data-bs-toggle="modal" data-bs-target="#approved{{$data->id}}">
                        Confirmed
                    </button>
                    <!-- <button type="button" class="btn btn-danger text-white" title="Request for quotation" data-bs-toggle="modal" data-bs-target="#declined{{$data->id}}">
                        Declined
                    </button> -->
                    <a href="{{ url('procurement/supplier_evaluation') }}" type="button" class="btn btn-secondary text-white">
                        Close   
                    </a>
                </div>
            </h4>
            <p class="h5 mt-4">I. Supplier Information</p>
            <hr class="mt-0">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Vendor ID:</p>
                    {{ $data->code->first()->vendor_code }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Vendor Name:</p>
                    {{ $data->name }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Type of Product:</p>
                    {{ $data->type }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Product/ Services:</p>
                    {{ $data->product_services }}
                </div>
                <div class="col-md-12 mb-2">
                    <p class="m-0 fw-bold">Address:</p>
                    {{ $data->address }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Contact Person 1:</p>
                    {{ $data->contact1 }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Contact Person 2:</p>
                    {{ $data->contact2 }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Position 1:</p>
                    {{ $data->position1 }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Position 2:</p>
                    {{ $data->position2 }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Telephone Number 1:</p>
                    {{ $data->telephone1 }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Telephone Number 2:</p>
                    {{ $data->telephone2 }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Mobile No./ Email 1:</p>
                    {{ $data->mobile1 }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Mobile No./ Email 2:</p>
                    {{ $data->mobile2 }}
                </div>
            </div>
            <p class="h5 mt-4">II. Evaluation Result (Refer to Supplier's Evaluation Guide for the criteria)</p>
            <hr class="mt-0">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <input class="form-check-input" type="radio" name="result" id="result" value="Pass" {{ collect($data->results)->contains('result', 'Pass') ? 'checked' : '' }}>
                    <label class="form-check-label" style="margin-right: 1em">
                        Pass
                    </label>
                    <input class="form-check-input" type="radio" name="result" id="result" value="Fail" {{ collect($data->results)->contains('result', 'Fail') ? 'checked' : '' }}>
                    <label class="form-check-label">
                        Fail
                    </label>
                </div>
                <div class="col-md-12 mb-2">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="25%">Criteria and Weight</th>
                                <th width="20%">Rating</th>
                                <th width="8%">Weight</th>
                                <th width="20%">Weighted Score</th>
                                <th width="27%">Performance/ Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4"><b>Consistency of Quality:</b></td>
                                <td rowspan="3">{{ optional($data->results->first())->remarks }}</td>
                            </tr>
                            <tr>
                                <td>Quality upon delivery</td>
                                <td>{{ optional($data->results->first())->rating1 }}</td>
                                <td>15.0%</td>
                                <td>{{ optional($data->results->first())->score1 }}</td>
                            </tr>
                            <tr>
                                <td>End user feedback</td>
                                <td>{{ optional($data->results->first())->rating2 }}</td>
                                <td>15.0%</td>
                                <td>{{ optional($data->results->first())->score2 }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"><b>Price and proposal submission:</b></td>
                                <td rowspan="3">{{ optional($data->results->first())->remarks1 }}</td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td>{{ optional($data->results->first())->rating3 }}</td>
                                <td>10.0%</td>
                                <td>{{ optional($data->results->first())->score3 }}</td>
                            </tr>
                            <tr>
                                <td>Proposal Submission</td>
                                <td>{{ optional($data->results->first())->rating4 }}</td>
                                <td>15.0%</td>
                                <td>{{ optional($data->results->first())->score4 }}</td>
                            </tr>
                            <tr>
                                <td><b>Timeliness of Delivery:</b></td>
                                <td>{{ optional($data->results->first())->rating5 }}</td>
                                <td>25.0%</td>
                                <td>{{ optional($data->results->first())->score5 }}</td>
                                <td>{{ optional($data->results->first())->remarks2 }}</td>
                            </tr>
                            <tr>
                                <td><b>Terms of Payment:</b></td>
                                <td>{{ optional($data->results->first())->rating6 }}</td>
                                <td>10.0%</td>
                                <td>{{ optional($data->results->first())->score6 }}</td>
                                <td>{{ optional($data->results->first())->remarks3 }}</td>
                            </tr>
                            <tr>
                                <td><b>After Sales Service:</b></td>
                                <td>{{ optional($data->results->first())->rating7 }}</td>
                                <td>10.0%</td>
                                <td>{{ optional($data->results->first())->score7 }}</td>
                                <td>{{ optional($data->results->first())->remarks4}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">Passing: 1.5 and above:</td>
                                <td>Total:</td>
                                <td colspan="2">{{ optional($data->results->first())->total}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 mb-2">
                    <p class="m-0 fw-bold">Overall Comments:</p>
                    {{ $data->comments }}
                </div>
            </div>
            <p class="h5 mt-4">III. Results of Discussion with Supplier</p>
            <hr class="mt-0">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <p class="m-0 fw-bold">Action to be Taken:</p>
                    {{ $data->action }}
                </div>
                <div class="col-md-12" align="right">
                    <a href="{{ url('procurement/supplier_evaluation') }}" class="btn btn-secondary">Close</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection