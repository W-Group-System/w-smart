<div class="modal fade" id="editVendor{{$vendor->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVendorModalLabel">Edit Vendor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editVendorForm" action="{{url('settings/edit-vendor/' . $vendor->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="requestorName" class="form-label" >Requestor Name:</label>
                            <input type="hidden" name="request_id" value="{{ $vendor->requestor_name }}">
                            <input type="text" class="form-control" id="requestorName" required style="height: 50%;" value="{{$vendor->user->name}}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="vendor_name" class="form-label">Vendor Name:</label>
                            <input type="text" name="vendor_name"id="vendor_name" class="form-control form-control-sm" value="{{ $vendor->vendorSupplier->corporate_name }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="vendor_code" class="form-label">Vendor Code:</label>
                            <input type="text" name="vendor_code"id="vendor_code" class="form-control form-control-sm" value="{{ $vendor->vendor_code }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="vendorCategory" class="form-label">Vendor Category:</label>
                            <select name="vendorCategory" id="vendorCategory" class="form-select chosen-select">
                                @foreach ($categories as $category )
                                    <option value="{{ $category->id }}" @if($category->id == $vendor->category) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-center mt-2">
                            <input type="checkbox" class="form-check-input sole_proprietor" data-vendor-id="{{ $vendor->id }}" name="sole_proprietor" value="1" 
                                   @if($vendor->sole_proprietor == 1) checked @endif 
                                   style="width: 30px; height: 30px; margin-right: 10px;">
                            <label class="form-check-label" for="sole_proprietor">Sole Proprietor</label>
                        </div>                        
                        <div class="col-md-6 company_name" data-vendor-id="{{ $vendor->id }}">
                            <label for="company_name" class="form-label">Company Name:</label>
                            <input type="text" name="company_name" class="form-control form-control-sm" value="{{ $vendor->company_name }}">
                        </div>                        
                        <div class="col-md-6" id="vendor_status">
                            <label for="vendor_status" class="form-label">Vendor Status:</label>
                            <input type="text" name="vendor_status"  class="form-control form-control-sm" value="{{ $vendor->vendor_status }}" readonly>
                        </div>
                        {{-- <div class="col-md-12">
                            <label for="contactDetails" class="form-label">Contact Details:</label>
                            <table class="table table-bordered" id="contactDetailsTable{{ $vendor->id }}">
                                <thead>
                                    <tr>
                                        <th>Work Email</th>
                                        <th>Phone Number</th>
                                        <th>Fax Number</th>
                                        <th>Alternate Phone Number</th>
                                        <th>Address</th>
                                        <th>Contact Person</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vendor->vendorContact as $contact)
                                    <tr class="contactRow">
                                        <input type="hidden" name="contact_id[]" class="form-control form-control-sm" value="{{ $contact->id }}" placeholder="Enter Work Email">
                                        <td><input type="text" name="work_email[]" class="form-control form-control-sm" value="{{ $contact->work_email }}" placeholder="Enter Work Email"></td>
                                        <td><input type="text" name="phone_no[]" class="form-control form-control-sm" value="{{ $contact->phone_no }}" placeholder="Enter Phone Number"></td>
                                        <td><input type="text" name="fax_no[]" class="form-control form-control-sm" value="{{ $contact->fax_no }}" placeholder="Enter Fax Number"></td>
                                        <td><input type="text" name="alternative_phone[]" class="form-control form-control-sm" value="{{ $contact->alternative_phone }}" placeholder="Enter Alternate Phone Number"></td>
                                        <td><input type="text" name="address[]" class="form-control form-control-sm" value="{{ $contact->address }}" placeholder="Enter Address"></td>
                                        <td><input type="text" name="contact_person[]" class="form-control form-control-sm" value="{{ $contact->contact_person }}" placeholder="Enter Contact Person"></td>
                                        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addRow(){{ $vendor->id }}">Add Row</button>
                        </div>   --}}
                        <div class="col-md-6">
                            <label for="classification_type" class="form-label">Vendor Classification:</label>
                            <select name="classification_type" id="classification_type" class="form-select chosen-select">
                                <option value="Minor" {{$vendor->classification_type == "Minor" ? 'selected' : '' }}>Minor</option>
                                <option value="Major" {{$vendor->classification_type == "Major" ? 'selected' : '' }}>Major</option>
                            </select>
                        </div> 
                        <div class="col-md-6">
                            <label for="subsidiary" class="form-label">Vendor Subsidiary:</label>
                            <select name="subsidiary[]" id="subsidiary" class="chosen-select" multiple>
                                @php
                                    $selectedSubsidiaries = json_decode($vendor->subsidiary, true);
                                @endphp
                                @foreach ($subsidiaries as $subsidiary)
                                    <option value="{{ $subsidiary->subsidiary_id }}" @if(in_array($subsidiary->subsidiary_id, $selectedSubsidiaries)) selected @endif>
                                        {{ $subsidiary->subsidiary_name }}
                                    </option>
                                @endforeach
                            </select>                            
                        </div>   
                        {{-- <div class="col-md-6">
                            <label for="tin" class="form-label">TIN:</label>
                            <input type="number" name="tin"  class="form-control form-control-sm" value="{{ $vendor->tin }}">
                        </div>    
                        <div class="col-md-6">
                            <label for="registration_dti_no" class="form-label">Sec Registration or DTI Number:</label>
                            <input type="number" name="registration_dti_no"  class="form-control form-control-sm" value="{{ $vendor->registration_dti_no }}">
                        </div>         --}}
                        <div class="col-md-6">
                            <label for="date_registered" class="form-label">Date Registered:</label>
                            <input type="date" name="date_registered" class="form-control" style="height: 50%;" id="date_registered" value="{{ $vendor->date_registered }}">
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-6">
                                <label for="companyProfile" class="form-label">Company Profile</label>
                                <input type="file" name="company_profile[]" id="companyProfile" class="form-control form-control-sm" multiple>
                            </div>
                            <div class="col-md-6">
                                <label for="officeLocationMap" class="form-label">Office Location Map</label>
                                <input type="file" name="office_location_map[]" id="officeLocationMap" class="form-control form-control-sm" multiple>
                            </div>
                            <div class="col-md-6">
                                <label for="secDtiReg" class="form-label">SEC/DTI Registration</label>
                                <input type="file" name="sec_dti_reg[]" id="secDtiReg" class="form-control form-control-sm" multiple>
                            </div>
                            <div class="col-md-6">
                                <label for="articlesOfInc" class="form-label">Articles of Incorporation</label>
                                <input type="file" name="articles_of_inc[]" id="articlesOfInc" class="form-control form-control-sm" multiple>
                            </div>
                            <div class="col-md-6">
                                <label for="birForm" class="form-label">BIR Form</label>
                                <input type="file" name="bir_form[]" id="birForm" class="form-control form-control-sm" multiple>
                            </div>
                            <div class="col-md-6">
                                <label for="latestGeneralInfo" class="form-label">Latest General Information</label>
                                <input type="file" name="latest_general_info[]" id="latestGeneralInfo" class="form-control form-control-sm" multiple>
                            </div>
                            <div class="col-md-6">
                                <label for="corporateSecCert" class="form-label">Corporate Secretary's Certificate</label>
                                <input type="file" name="corporate_sec_cert[]" id="corporateSecCert" class="form-control form-control-sm" multiple>
                            </div>
                            <div class="col-md-6">
                                <label for="auditedFsBir" class="form-label">Latest 3-year Audited FS with BIR Receipt</label>
                                <input type="file" name="audited_fs_bir[]" id="auditedFsBir" class="form-control form-control-sm" multiple>
                            </div>
                            <div class="col-md-6">
                                <label for="businessPermit" class="form-label">Business Permit</label>
                                <input type="file" name="business_permit[]" id="businessPermit" class="form-control form-control-sm" multiple>
                            </div>
                            <div class="col-md-6">
                                <label for="taxIncentive" class="form-label">Tax Incentive Certificate/Large Taxpayer Notice</label>
                                <input type="file" name="tax_incentive[]" id="taxIncentive" class="form-control form-control-sm" multiple>
                            </div>
                            <div class="col-md-6">
                                <label for="sampleInvoice" class="form-label">Sample Sales/Service Invoice</label>
                                <input type="file" name="sample_invoice[]" id="sampleInvoice" class="form-control form-control-sm" multiple>
                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" name="remarks" cols="30" rows="10" style="height: 50%;">{{ $vendor->remarks }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="saveNewVendor">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>