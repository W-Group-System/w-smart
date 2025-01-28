@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="col-12 grid-margin stretch-card">
    <div class="card mt-3">
        <div class="card-body">
            <h4 class="card-title d-flex justify-content-between align-items-center">
            New Supplier Accreditation
            <a href="{{ url('procurement/supplier_accreditation') }}" class="btn  btn-secondary"><i class="icon-arrow-left"></i>&nbsp;Back</a> 
            </h4>
            <form id="form_supplier_accreditation" action="{{ route('supplier_accreditation.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" id="status" name="status" value="Pending">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Vendor Code:</label>
                            <input type="text" class="form-control" id="vendor_code" name="vendor_code" placeholder="Enter Vendor Code" style="padding: 0.495rem 1.175rem" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Relationship to WGI:</label>
                            <select data-placeholder="Select Relationship to WGI" class="form-select chosen-select" id="relationship" name="relationship">
                                <option value=""></option>
                                <option value="1">Tenant/ Lease</option>
                                <option value="2">Supplier</option>
                                <option value="3">Service Provider</option>
                                <option value="4">Others (specify)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Name/ Corporate Name of Applicant:</label>
                            <input type="text" class="form-control" id="corporate_name" name="corporate_name" placeholder="Enter Name/ Corporate Name" style="padding: 0.495rem 1.175rem" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Telephone No.:</label>
                            <input type="text" class="form-control" id="telephone_no" name="telephone_no" placeholder="Enter Telephone No." style="padding: 0.495rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Fax No.:</label>
                            <input type="text" class="form-control" id="fax_no" name="fax_no" placeholder="Enter Fax No." style="padding: 0.495rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Trade Name (if different from Corporate Name):</label>
                            <input type="text" class="form-control" id="trade_name" name="trade_name" placeholder="Enter Trade Name" style="padding: 0.495rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Business Address:</label>
                            <textarea type="text" class="form-control" id="business_address" rows="2" name="business_address" placeholder="Enter Business Address"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <h5 class="card-title d-flex justify-content-between align-items-center">Billing Details</h5>
                        <hr>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Billing Address (complete if different from business address):</label>
                            <textarea type="text" class="form-control" id="billing_address" rows="2" name="billing_address" placeholder="Enter Billing Address"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Website:</label>
                            <input type="text" class="form-control" id="website" name="website" placeholder="Enter Website" style="padding: 0.495rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Office Phone:</label>
                            <input type="text" class="form-control" id="office_phone" name="office_phone" placeholder="Enter Office Phone" style="padding: 0.495rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Email Address:</label>
                            <input type="email" class="form-control" id="billing_email" name="billing_email" placeholder="Enter Email Address" style="padding: 0.495rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Years in Business:</label>
                            <input type="text" class="form-control" id="billing_years" name="billing_years" placeholder="Enter Years in Business" style="padding: 0.495rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Nature in Business:</label>
                            <input type="text" class="form-control" id="nature_business" name="nature_business" placeholder="Enter Nature in Business" style="padding: 0.495rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">SEC/DTI Registration No:</label>
                            <input type="text" class="form-control" id="registration_no" name="registration_no" placeholder="SEC/DTI Registration No" style="padding: 0.495rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Date Registered:</label>
                            <input type="date" class="form-control" id="date_registered" name="date_registered" placeholder="Enter Date Registered" style="padding: 0.495rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">TIN No.:</label>
                            <input type="text" class="form-control" id="billing_tin" name="billing_tin" placeholder="Enter TIN No." style="padding: 0.495rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Taxpayer Classification:</label>
                            <select data-placeholder="Select Taxpayer Classification" class="form-select chosen-select" id="taxpayer_classification" name="taxpayer_classification">
                                <option value=""></option>
                                <option value="1">VAT</option>
                                <option value="2">Non-VAT</option>
                                <option value="3">Exempt</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th width="25%">Name of Official Representatives</th>
                                    <th width="25%">Designation</th>
                                    <th width="20%">Contact Number</th>
                                    <th width="30%">Email Address</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyAddRow">
                                <tr>
                                    <td>
                                        <input type="text" name="name[]" placeholder="Enter Name of Official Representatives" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="designation[]" placeholder="Enter Designation" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="contact[]" placeholder="Enter Contact Number" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="email" name="email[]" placeholder="Enter Email Address" class="form-control form-control-sm">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success mt-2 mb-2" id="addRowBtnSupp">
                            Add Row
                        </button>
                        <button type="button" class="btn btn-danger mt-2 mb-2" id="deleteRowBtnSupp">
                            Delete Row
                        </button>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th width="30%">Owners/ Officers of the Company</th>
                                    <th width="30%">Designation</th>
                                    <th width="40%">Address</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyAddRow1">
                                <tr>
                                    <td>
                                        <input type="text" name="owners[]" placeholder="Enter Owners/ Officers of the Company" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="owners_designation[]" placeholder="Enter Designation" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="address[]" placeholder="Enter Address" class="form-control form-control-sm">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success mt-2 mb-2" id="addRowBtnSupp1">
                            Add Row
                        </button>
                        <button type="button" class="btn btn-danger mt-2 mb-2" id="deleteRowBtnSupp1">
                            Delete Row
                        </button>
                    </div>
                    <div class="col-md-12 mb-3">
                        <table class="table table-bordered " width="100%">
                            <thead>
                                <tr>
                                    <th width="25%">Contacts-Finance/ Accounting</th>
                                    <th width="25%">Designation</th>
                                    <th width="25%">Contact Number</th>
                                    <th width="25%">Email Address</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyAddRow2">
                                <tr>
                                    <td>
                                        <input type="text" name="contacts[]" placeholder="Enter Contacts-Finance/ Accounting" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="contacts_designation[]" placeholder="Enter Designation" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="contact_number[]" placeholder="Enter Contact Number" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="email" name="contacts_email[]" placeholder="Enter Email Address" class="form-control form-control-sm">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success mt-2 mb-2" id="addRowBtnSupp2">
                            Add Row
                        </button>
                        <button type="button" class="btn btn-danger mt-2 mb-2" id="deleteRowBtnSupp2">
                            Delete Row
                        </button>
                    </div>
                    <h4 class="mb-3">Tenants</h4>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Lease Commencement Date:</label>
                            <input type="date" class="form-control" id="lease_date" name="lease_date" placeholder="Enter Date Registered" style="padding: 0.495rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Handover Date:</label>
                            <input type="date" class="form-control" id="handover" name="handover" style="padding: 0.495rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Corporate Secretary's Certificate certifying to the authorized signatory on the Contract of Lessee:</label>
                            <input type="file" class="form-control" id="attachments" name="attachments" style="padding: 0.650rem 1.175rem">
                        </div>
                    </div>
                    <h4 class="mb-3">Suppliers Applying for Accreditation</h4>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Sample Official Receipt and/ or Sales Invoice:</label>
                            <input type="file" class="form-control" id="suppliers_attachments" name="suppliers_attachments" style="padding: 0.650rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Terms of Payment Offered:</label>
                            <input type="text" class="form-control" id="suppliers_terms" name="suppliers_terms" placeholder="Enter Terms of Payment Offered" style="padding: 0.495rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Products/ Services for Accreditation (please specify):</label>
                            <textarea type="text" class="form-control" id="suppliers_specify" name="suppliers_specify" placeholder="Enter Products/ Services for Accreditation"></textarea>
                        </div>
                    </div>
                    <h4 class="mb-3">Suppliers Reference (List of suppliers with whom you transacted in the last six months)</h4>
                    <div class="mb-3">
                        <table class="table table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th width="30%">Company Name</th>
                                    <th width="25%">Contact Person</th>
                                    <th width="20%">Telephone Number</th>
                                    <th width="25%">Terms</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyAddRow3">
                                <tr>
                                    <td>
                                        <input type="text" name="company_name[]" placeholder="Enter Company Name" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="contact_person[]" placeholder="Enter Contact Person" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="tel_no[]" placeholder="Enter Telephone No." class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="terms[]" placeholder="Enter Terms" class="form-control form-control-sm">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success mt-2 mb-2" id="addRowBtnSupp3">
                            Add Row
                        </button>
                        <button type="button" class="btn btn-danger mt-2 mb-2" id="deleteRowBtnSupp3">
                            Delete Row
                        </button>
                    </div>
                    <h4 class="mb-3">Customer's Reference (List of customers with whom you transacted in the last six months)</h4>
                    <div class="mb-3">
                        <table class="table table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th width="30%">Company Name</th>
                                    <th width="25%">Contact Person</th>
                                    <th width="20%">Telephone Number</th>
                                    <th width="25%">Terms</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyAddRow4">
                                <tr>
                                    <td>
                                        <input type="text" name="customer_company_name[]" placeholder="Enter Company Name" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="customer_contact_person[]" placeholder="Enter Contact Person" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="customer_tel_no[]" placeholder="Enter Telephone No." class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="customer_terms[]" placeholder="Enter Terms" class="form-control form-control-sm">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success mt-2 mb-2" id="addRowBtnSupp4">
                            Add Row
                        </button>
                        <button type="button" class="btn btn-danger mt-2 mb-2" id="deleteRowBtnSupp4">
                            Delete Row
                        </button>
                    </div>
                    <h4 class="mb-3">Applicants (Required Attachments)</h4>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Company Profile:</label>
                            <input type="file" class="form-control" id="company_profile" name="company_profile" style="padding: 0.650rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Latest (3 years) Audited Financial Statement w/ BIR Receipt:</label>
                            <input type="file" class="form-control" id="audited_financial" name="audited_financial" style="padding: 0.650rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Office Location Map:</label>
                            <input type="file" class="form-control" id="office_location" name="office_location" style="padding: 0.650rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Business Permit:</label>
                            <input type="file" class="form-control" id="business_permit" name="business_permit" style="padding: 0.650rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">SEC Registration or DTI Registration for Sole Proprietorship:</label>
                            <input type="file" class="form-control" id="sec_registration" name="sec_registration" style="padding: 0.650rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Tax Incentive Certificate/ Top 20,000 or Large Taxpayer Notice:</label>
                            <input type="file" class="form-control" id="tax_incentive" name="tax_incentive" style="padding: 0.650rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Articles of Incoporation:</label>
                            <input type="file" class="form-control" id="articles" name="articles" style="padding: 0.650rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">BIR Documents - BIR Form 2303:</label>
                            <input type="file" class="form-control" id="bir_documents" name="bir_documents" style="padding: 0.650rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Latest General Information Sheet (GIS):</label>
                            <input type="file" class="form-control" id="information_sheet" name="information_sheet" style="padding: 0.650rem 1.175rem">
                        </div>
                    </div>
                    <div class="col-lg-12" align="right">
                        <a href="{{ url('procurement/supplier_accreditation') }}" class="btn btn-danger">Close</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/supplierAccreditation.js') }}"></script>
@endpush