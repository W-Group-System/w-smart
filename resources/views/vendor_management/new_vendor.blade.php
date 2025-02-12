<div class="modal fade" id="addVendor" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVendorModalLabel">Add New Vendor</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addVendorForm" action="{{url('settings/store-vendor')}}" method="POST" enctype="multipart/form-data" onsubmit="show()">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="requestorName" class="form-label" >Requestor Name:</label>
                            <input type="hidden" name="request_id" value="{{auth()->user()->id}}">
                            <input type="text" class="form-control" id="requestorName" required style="height: 50%;" value="{{auth()->user()->name}}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="vendor_name" class="form-label">Vendor Name:</label>
                            <select data-placeholder="Select Supplier" name="vendor_name" id="vendor-Name" class="form-control js-example-basic-single" onchange="vendorNameSelect(this.value)" style="position: relative; width:100%;">
                                <option value=""></option>
                                @foreach ($accredited_suppliers as $supplier )
                                    <option value="{{ $supplier->id }}" vendor-code="{{ $supplier->vendor_code }}">{{ $supplier->corporate_name }}</option>
                                @endforeach
                            </select>
                            {{-- <input type="text" name="vendor_name"id="vendor_name" class="form-control form-control-sm"> --}}
                        </div>
                        <div class="col-md-6">
                            <label for="vendor_code" class="form-label">Vendor Code:</label>
                            <input type="text" name="vendor_code" id="vendor-Code" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="vendorCategory" class="form-label">Vendor Category:</label>
                                    <select name="vendorCategory" id="vendorCategory" class="form-control js-example-basic-single" style="position: relative; width:100%;" required >
                                        @foreach ($categories as $category )
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <input type="checkbox" id="sole_proprietor" name="sole_proprietor" value="1">
                                    <label class="form-check-label" for="sole_proprietor">Sole Proprietor</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="company_name">
                            <label for="company_name" class="form-label" >Company Name:</label>
                            <input type="text" name="company_name"  class="form-control form-control-sm">
                        </div>
                        {{-- <div class="col-md-6" id="vendor_status">
                            <label for="vendor_status" class="form-label">Vendor Status:</label>
                            <input type="text" name="vendor_status"  class="form-control form-control-sm">
                        </div> --}}
                        {{-- <div class="col-md-12">
                            <label for="contactDetails" class="form-label">Contact Details:</label>
                            <table class="table table-bordered" id="contactDetailsTables">
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
                                    <tr class="contactRow">
                                        <td><input type="text" name="work_email[]" class="form-control form-control-sm" placeholder="Enter Work Email"></td>
                                        <td><input type="text" name="phone_no[]" class="form-control form-control-sm" placeholder="Enter Phone Number"></td>
                                        <td><input type="text" name="fax_no[]" class="form-control form-control-sm" placeholder="Enter Fax Number"></td>
                                        <td><input type="text" name="alternative_phone[]" class="form-control form-control-sm" placeholder="Enter Alternate Phone Number"></td>
                                        <td><input type="text" name="address[]" class="form-control form-control-sm" placeholder="Enter Address"></td>
                                        <td><input type="text" name="contact_person[]" class="form-control form-control-sm" placeholder="Enter Contact Person"></td>
                                        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRowS(this)">Remove</button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addRow()">Add Row</button>
                        </div>   --}}
                        <div class="col-md-6">
                            <label for="classification_type" class="form-label">Vendor Classification:</label>
                            <select name="classification_type" id="classification_type"  class="form-control js-example-basic-single" style="position: relative; width:100%;">
                                <option value="Minor">Minor</option>
                                <option value="Major">Major</option>
                            </select>
                        </div> 
                        <div class="col-md-6">
                            <label for="subsidiary" class="form-label">Vendor Subsidiary:</label>
                            <select name="subsidiary[]" id="subsidiary"  class="form-control js-example-basic-multiple" style="position: relative; width:100%;" multiple>
                                @foreach ($subsidiaries as $subsidiary)
                                    <option value="{{ $subsidiary->subsidiary_id }}">{{ $subsidiary->subsidiary_name }}</option>
                                @endforeach
                            </select>
                        </div>   
                        {{-- <div class="col-md-6">
                            <label for="tin" class="form-label">TIN:</label>
                            <input type="number" name="tin" id="billing-Tin"  class="form-control form-control-sm">
                        </div>    
                        <div class="col-md-6">
                            <label for="registration_dti_no" class="form-label">Sec Registration or DTI Number:</label>
                            <input type="number" name="registration_dti_no"  class="form-control form-control-sm">
                        </div>         --}}
                        <div class="col-md-6">
                            <label for="date_registered" class="form-label">Date Registered:</label>
                            <input type="date" name="date_registered" class="form-control" style="height: 50%;" id="date_registered">
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
                            <textarea class="form-control" name="remarks" cols="30" rows="10" style="height: 50%;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="saveNewVendor">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>