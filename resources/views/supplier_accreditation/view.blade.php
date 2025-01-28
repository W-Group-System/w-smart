@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="col-12 grid-margin stretch-card">
    <div class="card mt-3">
        <div class="card-body">
            <h4 class="card-title d-flex justify-content-between align-items-center">
            View Supplier Accreditation
                <div align="right">
                    <a href="{{ url('procurement/edit_supplier_accreditation/' . $supplier_accreditation->id) }}" class="text-decoration-none">
                        <button class="btn btn-warning text-white">Edit</button>
                    </a>
                    <button type="button" class="btn btn-success text-white" title="Approved Supplier" data-bs-toggle="modal" data-bs-target="#approved{{$supplier_accreditation->id}}">
                        Approved
                    </button>
                    <button type="button" class="btn btn-danger text-white" title="Request for quotation" data-bs-toggle="modal" data-bs-target="#declined{{$supplier_accreditation->id}}">
                        Declined
                    </button>
                    <a href="{{url('procurement/supplier_accreditation')}}" type="button" class="btn btn-secondary text-white">
                        Close   
                    </a>
                </div>
            </h4>
            <p class="h5 mt-4">Data & Classification</p>
            <hr class="mt-0">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Relationship to WGI:</p>
                    @if($supplier_accreditation->relationship == 1)
                        Tenant/ Lease
                    @elseif($supplier_accreditation->relationship == 2)
                        Supplier
                    @elseif($supplier_accreditation->relationship == 3)
                        Service Provider   
                    @elseif($supplier_accreditation->relationship == 4)
                        Others 
                    @else 
                        N/A
                    @endif
                </div>
                <div class="col-md-6 mb-2"></div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Name/ Corporate Name of Applicant:</p>
                    {{ $supplier_accreditation->corporate_name }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Telephone No.:</p>
                    {{ $supplier_accreditation->telephone_no }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Fax No.:</p>
                    {{ $supplier_accreditation->fax_no }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Trade Name (if different from Corporate Name):</p>
                    {{ $supplier_accreditation->trade_name }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Business Address:</p>
                    {{ $supplier_accreditation->business_address }}
                </div>
                <p class="h5 mt-4">Billing Details</p>
                <hr class="mt-0">
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Billing Address (complete if different from business address):</p>
                    {{ $supplier_accreditation->billing_address }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Website:</p>
                    {{ $supplier_accreditation->website }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Office Phone:</p>
                    {{ $supplier_accreditation->office_phone }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Email Address:</p>
                    {{ $supplier_accreditation->billing_email }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Years in Business:</p>
                    {{ $supplier_accreditation->billing_years }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Nature in Business:</p>
                    {{ $supplier_accreditation->nature_business }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">SEC/DTI Registration No:</p>
                    {{ $supplier_accreditation->registration_no }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Date Registered:</p>
                    {{ $supplier_accreditation->date_registered }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">TIN No.:</p>
                    {{ $supplier_accreditation->billing_tin }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Taxpayer Classification:</p>
                    @if($supplier_accreditation->taxpayer_classification == 1)
                        VAT
                    @elseif($supplier_accreditation->taxpayer_classification == 2)
                        Non-VAT
                    @elseif($supplier_accreditation->taxpayer_classification == 3)
                        Exempt   
                    @else 
                        N/A
                    @endif
                </div>
                <div class="col-md-12 mb-2">
                    <table class="table table-striped" width="100%">
                        <thead>
                            <tr>
                                <th width="25%">Name of Official Representatives</th>
                                <th width="25%">Designation</th>
                                <th width="20%">Contact Number</th>
                                <th width="30%">Email Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($supplier_accreditation->representative->count() > 0)
                                @foreach($supplier_accreditation->representative as $representative)
                                <tr>
                                    <td>{{ $representative->name }}</td>
                                    <td>{{ $representative->designation }}</td>
                                    <td>{{ $representative->contact }}</td>
                                    <td>{{ $representative->email }}</td>
                                </tr>
                                @endforeach
                            @else 
                                <tr>
                                    <td colspan="4" class="text-center">No matching records found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 mb-2">
                    <table class="table table-striped" width="100%">
                        <thead>
                            <tr>
                                <th width="25%">Owners/ Officers of the Company</th>
                                <th width="25%">Designation</th>
                                <th width="50%">Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($supplier_accreditation->owners->count() > 0)
                                @foreach($supplier_accreditation->owners as $owner)
                                <tr>
                                    <td>{{ $owner->owners }}</td>
                                    <td>{{ $owner->owners_designation }}</td>
                                    <td>{{ $owner->address }}</td>
                                </tr>
                                @endforeach
                            @else 
                                <tr>
                                    <td colspan="3" class="text-center">No matching records found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <table class="table table-striped" width="100%">
                        <thead>
                            <tr>
                                <th width="25%">Contacts-Finance/ Accounting</th>
                                <th width="25%">Designation</th>
                                <th width="20%">Contact Number</th>
                                <th width="30%">Email Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($supplier_accreditation->contacts->count() > 0)
                                @foreach($supplier_accreditation->contacts as $contact)
                                <tr>
                                    <td>{{ $contact->contacts }}</td>
                                    <td>{{ $contact->contacts_designation }}</td>
                                    <td>{{ $contact->contact_number }}</td>
                                    <td>{{ $contact->contacts_email }}</td>
                                </tr>
                                @endforeach
                            @else 
                                <tr>
                                    <td colspan="4" class="text-center">No matching records found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <p class="h5 mt-4">Tenants</p>
                <hr class="mt-0">
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Lease Commencement Date:</p>
                    {{ date('m/d/Y', strtotime($supplier_accreditation->lease_date)) }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Handover Date:</p>
                    {{ date('m/d/Y', strtotime($supplier_accreditation->handover)) }}
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Corporate Secretary's Certificate certifying to the authorized signatory on the Contract of Lessee:</p>
                    @if(!empty($supplier_accreditation->attachments))
                        <a href="{{ asset('storage/' . $supplier_accreditation->attachments) }}" target="_blank">
                            <i class="bi bi-files"></i> {{ basename($supplier_accreditation->attachments) }}
                        </a>
                    @else
                        <span>No File Available</span>
                    @endif
                </div>
                <p class="h5 mt-4">Suppliers Applying for Accreditation</p>
                <hr class="mt-0">
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Sample Official Receipt and/ or Sales Invoice:</p>
                    @if(!empty($supplier_accreditation->suppliers_attachments))
                        <a href="{{ asset('storage/' . $supplier_accreditation->suppliers_attachments) }}" target="_blank">
                            <i class="bi bi-files"></i> {{ basename($supplier_accreditation->suppliers_attachments) }}
                        </a>
                    @else
                        <span>No File Available</span>
                    @endif
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Terms of Payment Offered:</p>
                    {{ $supplier_accreditation->suppliers_terms ?? 'N/A' }}
                </div>
                <div class="col-md-12 mb-2">
                    <p class="m-0 fw-bold">Products/ Services for Accreditation (please specify):</p>
                    {{ $supplier_accreditation->suppliers_specify ?? 'N/A' }}
                </div>
                <p class="h5 mt-4">Suppliers Reference (List of supplier with whom you transacted in the last six months)</p>
                <hr class="mt-0">
                <div class="col-md-12">
                    <table class="table table-striped" width="100%">
                        <thead>
                            <tr>
                                <th width="30%">Company Name</th>
                                <th width="25%">Contact Person</th>
                                <th width="20%">Telephone Number</th>
                                <th width="25%">Terms</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($supplier_accreditation->references->count() > 0)
                                @foreach($supplier_accreditation->references as $reference)
                                <tr>
                                    <td>{{ $reference->company_name }}</td>
                                    <td>{{ $reference->contact_person }}</td>
                                    <td>{{ $reference->tel_no }}</td>
                                    <td>{{ $reference->terms }}</td>
                                </tr>
                                @endforeach
                            @else 
                                <tr>
                                    <td colspan="4" class="text-center">No matching records found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <p class="h5 mt-4">Customer's Reference (List of customer with whom you transacted in the last six months)</p>
                <hr class="mt-0">
                <div class="col-md-12">
                    <table class="table table-striped" width="100%">
                        <thead>
                            <tr>
                                <th width="30%">Company Name</th>
                                <th width="25%">Contact Person</th>
                                <th width="20%">Telephone Number</th>
                                <th width="25%">Terms</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($supplier_accreditation->customers->count() > 0)
                                @foreach($supplier_accreditation->customers as $customer)
                                <tr>
                                    <td>{{ $customer->customer_company_name }}</td>
                                    <td>{{ $customer->customer_contact_person }}</td>
                                    <td>{{ $customer->customer_tel_no }}</td>
                                    <td>{{ $customer->customer_terms }}</td>
                                </tr>
                                @endforeach
                            @else 
                                <tr>
                                    <td colspan="4" class="text-center">No matching records found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <p class="h5 mt-4">Required Attachments</p>
                <hr class="mt-0">
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Company Profile:</p>
                    @if(!empty($supplier_accreditation->company_profile))
                        <a href="{{ asset('storage/' . $supplier_accreditation->company_profile) }}" target="_blank">
                            <i class="bi bi-files"></i> {{ basename($supplier_accreditation->company_profile) }}
                        </a>
                    @else
                        <span>No File Available</span>
                    @endif
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Latest (3 years) Audited Financial Statement w/ BIR Receipt:</p>
                    @if(!empty($supplier_accreditation->audited_financial))
                        <a href="{{ asset('storage/' . $supplier_accreditation->audited_financial) }}" target="_blank">
                            <i class="bi bi-files"></i> {{ basename($supplier_accreditation->audited_financial) }}
                        </a>
                    @else
                        <span>No File Available</span>
                    @endif
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Office Location Map:</p>
                    @if(!empty($supplier_accreditation->office_location))
                        <a href="{{ asset('storage/' . $supplier_accreditation->office_location) }}" target="_blank">
                            <i class="bi bi-files"></i> {{ basename($supplier_accreditation->office_location) }}
                        </a>
                    @else
                        <span>No File Available</span>
                    @endif
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Business Permit:</p>
                    @if(!empty($supplier_accreditation->business_permit))
                        <a href="{{ asset('storage/' . $supplier_accreditation->business_permit) }}" target="_blank">
                            <i class="bi bi-files"></i> {{ basename($supplier_accreditation->business_permit) }}
                        </a>
                    @else
                        <span>No File Available</span>
                    @endif
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">SEC Registration or DTI Registration for Sole Proprietorship:</p>
                    @if(!empty($supplier_accreditation->sec_registration))
                        <a href="{{ asset('storage/' . $supplier_accreditation->sec_registration) }}" target="_blank">
                            <i class="bi bi-files"></i> {{ basename($supplier_accreditation->sec_registration) }}
                        </a>
                    @else
                        <span>No File Available</span>
                    @endif
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Tax Incentive Certificate/ Top 20,000 or Large Taxpayer Notice:</p>
                    @if(!empty($supplier_accreditation->tax_incentive))
                        <a href="{{ asset('storage/' . $supplier_accreditation->tax_incentive) }}" target="_blank">
                            <i class="bi bi-files"></i> {{ basename($supplier_accreditation->tax_incentive) }}
                        </a>
                    @else
                        <span>No File Available</span>
                    @endif
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Articles of Incoporation:</p>
                    @if(!empty($supplier_accreditation->articles))
                        <a href="{{ asset('storage/' . $supplier_accreditation->articles) }}" target="_blank">
                            <i class="bi bi-files"></i> {{ basename($supplier_accreditation->articles) }}
                        </a>
                    @else
                        <span>No File Available</span>
                    @endif
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">BIR Documents - BIR Form 2303:</p>
                    @if(!empty($supplier_accreditation->bir_documents))
                        <a href="{{ asset('storage/' . $supplier_accreditation->bir_documents) }}" target="_blank">
                            <i class="bi bi-files"></i> {{ basename($supplier_accreditation->bir_documents) }}
                        </a>
                    @else
                        <span>No File Available</span>
                    @endif
                </div>
                <div class="col-md-6 mb-2">
                    <p class="m-0 fw-bold">Latest General Information Sheet (GIS):</p>
                    @if(!empty($supplier_accreditation->information_sheet))
                        <a href="{{ asset('storage/' . $supplier_accreditation->information_sheet) }}" target="_blank">
                            <i class="bi bi-files"></i> {{ basename($supplier_accreditation->information_sheet) }}
                        </a>
                    @else
                        <span>No File Available</span>
                    @endif
                </div>
                <div class="col-lg-12" align="right">
                    <a href="{{ url('procurement/supplier_accreditation') }}" class="btn btn-secondary">Close</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="approved{{ $supplier_accreditation->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approved Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('procurement/approved_supplier_accreditation/' . $supplier_accreditation->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="approved_remarks_{{ $supplier_accreditation->id }}" class="form-label">Remarks:</label>
                            <textarea class="form-control" id="approved_remarks_{{ $supplier_accreditation->id }}" rows="2" name="approved_remarks" placeholder="Enter Remarks"></textarea>
                        </div>
                    </div>
                    <hr>
                    <div align="right">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="declined{{ $supplier_accreditation->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Declined Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('procurement/declined_supplier_accreditation/' . $supplier_accreditation->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="declined_remarks{{ $supplier_accreditation->id }}" class="form-label">Remarks:</label>
                            <textarea class="form-control" id="declined_remarks{{ $supplier_accreditation->id }}" rows="2" name="declined_remarks" placeholder="Enter Remarks"></textarea>
                        </div>
                    </div>
                    <hr>
                    <div align="right">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection