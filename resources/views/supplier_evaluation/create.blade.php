<div class="modal fade" id="addEvaluation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Supplier Evaluation</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <form action="{{ url('procurement/store_supplier_evaluation') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="card-title d-flex justify-content-between align-items-center">I. Supplier Information</h5>
                            <hr>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Vendor ID:</label>
                            <select data-placeholder="Select Vendor ID" class="form-control js-example-basic-single" style="width: 100%;" name="vendor_id" onchange="getVendorName(this.value)" required>
                                <option value=""></option>
                                @foreach($vendor as $vendorItem)
                                    <option value="{{ $vendorItem->id }}" data-code="{{ $vendorItem->vendor_code }}">{{ $vendorItem->vendor_code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Vendor Name:</label>
                            <input type="text" class="form-control" id="name" name="name" style="padding: 0.495rem 1.175rem" placeholder="Enter Vendor Name" readonly>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Type of Product:</label>
                            <select data-placeholder="Select Type of Product" class="form-control js-example-basic-single" style="width: 100%;" name="type">
                                <option value=""></option>
                                <option value="Imported">Imported</option>
                                <option value="Local">Local</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Product/ Services:</label>
                            <input type="text" class="form-control" id="product_services" name="product_services" style="padding: 0.495rem 1.175rem" placeholder="Enter Product/ Services">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Address:</label>
                            <textarea type="text" class="form-control" id="address" rows="2" name="address" placeholder="Enter Address"></textarea>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Contact Person 1:</label>
                            <input type="text" class="form-control" id="contact1" name="contact1" style="padding: 0.495rem 1.175rem" placeholder="Enter Contact Person 1">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Contact Person 2:</label>
                            <input type="text" class="form-control" id="contact2" name="contact2" style="padding: 0.495rem 1.175rem" placeholder="Enter Contact Person 2">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Position 1:</label>
                            <input type="text" class="form-control" id="position1" name="position1" style="padding: 0.495rem 1.175rem" placeholder="Enter Position 1">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Position 2:</label>
                            <input type="text" class="form-control" id="position2" name="position2" style="padding: 0.495rem 1.175rem" placeholder="Enter Position 2">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Telephone No. 1:</label>
                            <input type="text" class="form-control" id="telephone1" name="telephone1" style="padding: 0.495rem 1.175rem" placeholder="Enter Telephone No. 1">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Telephone No. 2:</label>
                            <input type="text" class="form-control" id="telephone2" name="telephone2" style="padding: 0.495rem 1.175rem" placeholder="Enter Telephone No. 2">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Mobile No./ Email 1:</label>
                            <input type="text" class="form-control" id="mobile1" name="mobile1" style="padding: 0.495rem 1.175rem" placeholder="Enter Mobile No./ Email 1">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Mobile No./ Email 2:</label>
                            <input type="text" class="form-control" id="mobile2" name="mobile2" style="padding: 0.495rem 1.175rem" placeholder="Enter Mobile No./ Email 2">
                        </div>
                        <div class="col-md-12 mt-3">
                            <h5 class="card-title d-flex justify-content-between align-items-center">II. Evaluation Result (Refer to Supplier's Evaluation Guide for the criteria)</h5>
                            <hr>
                        </div>
                        <div class="form-inline mb-2">
                            <input class="form-check-input" type="radio" name="result" id="result" value="Pass">
                            <label class="form-check-label" style="margin-right: 1em">
                                Pass
                            </label>
                            <input class="form-check-input" type="radio" name="result" id="result" value="Fail">
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
                                        <td rowspan="3"><textarea type="text" rows="5" class="form-control" name="remarks" placeholder="Enter Performance/ Remarks"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Quality upon delivery</td>
                                        <td>
                                            <input type="number" class="form-control rating-field" name="rating1" placeholder="Enter Rating">
                                        </td>
                                        <td class="weight1" data-weight="15">15.0%</td> 
                                        <td>
                                            <input type="text" class="form-control score-field" name="score1" placeholder="Enter Weighted Score" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>End user feedback</td>
                                        <td><input type="number" class="form-control rating-field2" name="rating2" placeholder="Enter Rating"></td>
                                        <td class="weight2" data-weight="15">15.0%</td>
                                        <td><input type="text" class="form-control score-field" name="score2" placeholder="Enter Weighted Score" readonly></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><b>Price and proposal submission:</b></td>
                                        <td rowspan="3"><textarea type="text" rows="5" class="form-control" name="remarks1" placeholder="Enter Performance/ Remarks"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Price</td>
                                        <td><input type="number" class="form-control rating-field3" name="rating3" placeholder="Enter Rating"></td>
                                        <td class="weight3" data-weight="10">10.0%</td>
                                        <td><input type="text" class="form-control score-field" name="score3" placeholder="Enter Weighted Score" readonly></td>
                                    </tr>
                                    <tr>
                                        <td>Proposal Submission</td>
                                        <td><input type="number" class="form-control rating-field4" name="rating4" placeholder="Enter Rating"></td>
                                        <td class="weight4" data-weight="15">15.0%</td>
                                        <td><input type="text" class="form-control score-field" name="score4" placeholder="Enter Weighted Score" readonly></td>
                                    </tr>
                                    <tr>
                                        <td><b>Timeliness of Delivery:</b></td>
                                        <td><input type="number" class="form-control rating-field5" name="rating5" placeholder="Enter Rating"></td>
                                        <td class="weight5" data-weight="25">25.0%</td>
                                        <td><input type="text" class="form-control score-field" name="score5" placeholder="Enter Weighted Score" readonly></td>
                                        <td><input type="text" class="form-control" name="remarks2" placeholder="Enter Performance/ Remarks"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Terms of Payment:</b></td>
                                        <td><input type="number" class="form-control rating-field6" name="rating6" placeholder="Enter Rating"></td>
                                        <td class="weight6" data-weight="10">10.0%</td>
                                        <td><input type="text" class="form-control score-field" name="score6" placeholder="Enter Weighted Score" readonly></td>
                                        <td><input type="text" class="form-control" name="remarks3" placeholder="Enter Performance/ Remarks"></td>
                                    </tr>
                                    <tr>
                                        <td><b>After Sales Service:</b></td>
                                        <td><input type="number" class="form-control rating-field7" name="rating7" placeholder="Enter Rating"></td>
                                        <td class="weight7" data-weight="10">10.0%</td>
                                        <td><input type="text" class="form-control score-field" name="score7" placeholder="Enter Weighted Score" readonly></td>
                                        <td><input type="text" class="form-control" name="remarks4" placeholder="Enter Performance/ Remarks"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Passing: 1.5 and above:</td>
                                        <td>Total:</td>
                                        <td colspan="2"><input type="text" class="form-control" id="total-score" name="total" placeholder="Total Score" readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Overall Comments:</label>
                            <textarea type="text" class="form-control" id="comments" name="comments" rows="2" placeholder="Enter Comments"></textarea>
                        </div>
                        <div class="col-md-12 mt-3">
                            <h5 class="card-title d-flex justify-content-between align-items-center">III. Results of Discussion with Supplier</h5>
                            <hr>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Action to be Taken:</label>
                            <textarea type="text" class="form-control" id="action" name="action" rows="3" placeholder="Enter Action"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3" align="right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- @section('js')
    <script src="{{ asset('js/supplierEvaluation.js') }}"></script>
    <script>
        async function getVendorName(value) {
            // Get the input field for the corporate name
            let nameInput = document.getElementById("name");

            // Clear the field if no value is selected
            if (!value) {
                nameInput.value = "";
                return;
            }

            try {
                // Make an AJAX request to fetch the vendor's corporate name
                const response = await axios.post(
                    "{{ url('refresh_vendor_name') }}",
                    { vendor_id: value },
                    {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                    }
                );

                // Update the name field with the corporate name
                if (response.data.corporate_name) {
                    nameInput.value = response.data.corporate_name;
                } else {
                    nameInput.value = "Corporate name not found";
                }
            } catch (error) {
                console.error("Error fetching corporate name:", error);
                nameInput.value = "Error fetching corporate name";
            }
        }
    </script>
@endsection --}}