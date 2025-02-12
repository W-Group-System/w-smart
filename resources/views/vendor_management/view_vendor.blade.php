{{-- @extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">

    <div class="card p-4 mt-3" style="border: 1px solid #ddd; border-radius: 20px; margin-top: -25px;">

        <p class="h5 mt-4">Primary Information</p>
        <hr class="mt-0">
        <div class="row">
            <div class="col-md-6 mb-2">
                <p class="m-0 fw-bold">Vendor Name:</p>
                {{$vendors->vendorSupplier->corporate_name}}
            </div>
            <div class="col-md-6 mb-2">
                <p class="m-0 fw-bold">Company Name:</p>
                {{$vendors->company_name}}
            </div>
            <div class="col-md-6 mb-2">
                <p class="m-0 fw-bold">Category:</p>
                {{str_pad(optional($vendors)->vendorCategory->name, 6, '0', STR_PAD_LEFT)}}
            </div>
            <div class="col-md-6 mb-2">
                <p class="m-0 fw-bold">Vendor Status:</p>
                {{$vendors->vendor_status}}
            </div>
        </div>
        <p class="h5 mt-4">Contact Information</p>
        <hr class="mt-0">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="padding:5px 10px;">Work Email</th>
                                <th style="padding:5px 10px;">Phone Number</th>
                                <th style="padding:5px 10px;">Contact Person</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($vendors->vendorContact->isNotEmpty())
                                @foreach ($vendors->vendorContact as $contact)
                                    <tr>
                                        <td style="padding: 5px 10px;">{{$contact->email}}</td>
                                        <td style="padding: 5px 10px;">{{$contact->contact}}</td>
                                        <td style="padding: 5px 10px;">{{$contact->name}}</td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <p class="h5 mt-4"> Attachments</p>
        <hr class="mt-0">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="padding:5px 10px;">Company Profile</th>
                                <th style="padding:5px 10px;">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($vendors->vendorSupplier->company_profile)
                                <tr>
                                    <td style="padding: 5px 10px;">
                                        <a href="{{url('storage/' .$vendors->vendorSupplier->company_profile)}}" target="_blank">
                                            <i class="bi bi-files"></i>
                                        </a>
                                    </td>
                                    <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->company_profile}}</td>
                                    
                                </tr>
                            @else
                            <tr>
                                <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="padding:5px 10px;">Office Location Map</th>
                                <th style="padding:5px 10px;">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($vendors->vendorSupplier->office_location)
                                <tr>
                                    <td style="padding: 5px 10px;">
                                        <a href="{{url('storage/' .$vendors->vendorSupplier->office_location)}}" target="_blank">
                                            <i class="bi bi-files"></i>
                                        </a>
                                    </td>
                                    <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->office_location}}</td>
                                    
                                </tr>
                            @else
                            <tr>
                                <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="padding:5px 10px;">Sec Registration or DTI Registration</th>
                                <th style="padding:5px 10px;">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($vendors->vendorSupplier->sec_registration)
                                <tr>
                                    <td style="padding: 5px 10px;">
                                        <a href="{{url('storage/' .$vendors->vendorSupplier->sec_registration)}}" target="_blank">
                                            <i class="bi bi-files"></i>
                                        </a>
                                    </td>
                                    <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->sec_registration}}</td>
                                    
                                </tr>
                            @else
                            <tr>
                                <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="padding:5px 10px;">Articles of Incorporation</th>
                                <th style="padding:5px 10px;">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($vendors->vendorSupplier->articles)
                                <tr>
                                    <td style="padding: 5px 10px;">
                                        <a href="{{url('storage/' . $vendors->vendorSupplier->articles)}}" target="_blank">
                                            <i class="bi bi-files"></i>
                                        </a>
                                    </td>
                                    <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->articles}}</td>
                                    
                                </tr>
                            @else
                            <tr>
                                <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="padding:5px 10px;">BIR Documents - BIR Form 2303</th>
                                <th style="padding:5px 10px;">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($vendors->vendorSupplier->bir_documents)
                                <tr>
                                    <td style="padding: 5px 10px;">
                                        <a href="{{url('storage/' .$vendors->vendorSupplier->bir_documents)}}" target="_blank">
                                            <i class="bi bi-files"></i>
                                        </a>
                                    </td>
                                    <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->bir_documents}}</td>
                                    
                                </tr>
                            @else
                            <tr>
                                <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="padding:5px 10px;">Latest General Information</th>
                                <th style="padding:5px 10px;">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($vendors->vendorSupplier->information_sheet)
                                <tr>
                                    <td style="padding: 5px 10px;">
                                        <a href="{{url('storage/' .$vendors->vendorSupplier->information_sheet)}}" target="_blank">
                                            <i class="bi bi-files"></i>
                                        </a>
                                    </td>
                                    <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->information_sheet}}</td>
                                    
                                </tr>
                            @else
                            <tr>
                                <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="padding:5px 10px;">Latest 3 year Audited FSw/ BIR Receipt</th>
                                <th style="padding:5px 10px;">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($vendors->vendorSupplier->audited_financial)
                                <tr>
                                    <td style="padding: 5px 10px;">
                                        <a href="{{url('storage/' .$vendors->vendorSupplier->audited_financial)}}" target="_blank">
                                            <i class="bi bi-files"></i>
                                        </a>
                                    </td>
                                    <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->audited_financial}}</td>
                                    
                                </tr>
                            @else
                            <tr>
                                <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="padding:5px 10px;">Business Permit</th>
                                <th style="padding:5px 10px;">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($vendors->vendorSupplier->business_permit)
                                <tr>
                                    <td style="padding: 5px 10px;">
                                        <a href="{{url('storage/' .$vendors->vendorSupplier->business_permit)}}" target="_blank">
                                            <i class="bi bi-files"></i>
                                        </a>
                                    </td>
                                    <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->business_permit}}</td>
                                    
                                </tr>
                            @else
                            <tr>
                                <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="padding:5px 10px;">Tax Incentive Cert/Large Taxpayer Notice</th>
                                <th style="padding:5px 10px;">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($vendors->vendorSupplier->tax_incentive)
                                <tr>
                                    <td style="padding: 5px 10px;">
                                        <a href="{{url('storage/' .$vendors->vendorSupplier->tax_incentive)}}" target="_blank">
                                            <i class="bi bi-files"></i>
                                        </a>
                                    </td>
                                    <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->tax_incentive}}</td>
                                    
                                </tr>
                            @else
                            <tr>
                                <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection --}}

@extends('layouts.header')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Primary Information</h4>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right">
                                Vendor Name :
                            </dt>
                            <dd class="col-sm-9">
                                {{$vendors->vendorSupplier->corporate_name}}
                            </dd>
                            <dt class="col-sm-3 text-right">
                                Category :
                            </dt>
                            <dd class="col-sm-9">
                                {{optional($vendors)->vendorCategory->name}}
                            </dd>
                        </dl>
                    </div>
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right mb-2">
                                Company Name :
                            </dt>
                            <dd class="col-sm-9">
                                {{$vendors->company_name}}
                            </dd>
                            <dt class="col-sm-3 text-right">
                                Vendor Status :
                            </dt>
                            <dd class="col-sm-9">
                                {{$vendors->vendor_status}}
                            </dd>
                        </dl>
                    </div>
                </div>
                
                <h4 class="card-title">Contact Information</h4>
                <hr>

                <div class="row">
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right">
                                Work Email :
                            </dt>
                            <dd class="col-sm-9">
                                @foreach ($vendors->vendorContact as $contact)
                                    {{$contact->email}} <br>
                                @endforeach
                            </dd>
                            <dt class="col-sm-3 text-right">
                                Phone Number :
                            </dt>
                            <dd class="col-sm-9">
                                @foreach ($vendors->vendorContact as $contact)
                                    {{$contact->contact}} <br>
                                @endforeach
                            </dd>
                            <dt class="col-sm-3 text-right">
                                Contact Person :
                            </dt>
                            <dd class="col-sm-9">
                                @foreach ($vendors->vendorContact as $contact)
                                    {{$contact->name}} <br>
                                @endforeach
                            </dd>
                        </dl>
                    </div>
                </div>

                <h4 class="card-title">Attachments</h4>
                <hr>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="padding:5px 10px;">Company Profile</th>
                                        <th style="padding:5px 10px;">Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($vendors->vendorSupplier->company_profile)
                                        <tr>
                                            <td style="padding: 5px 10px;">
                                                <a href="{{url('storage/' .$vendors->vendorSupplier->company_profile)}}" target="_blank">
                                                    <i class="bi bi-files"></i>
                                                </a>
                                            </td>
                                            <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->company_profile}}</td>
                                            
                                        </tr>
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="padding:5px 10px;">Office Location Map</th>
                                        <th style="padding:5px 10px;">Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($vendors->vendorSupplier->office_location)
                                        <tr>
                                            <td style="padding: 5px 10px;">
                                                <a href="{{url('storage/' .$vendors->vendorSupplier->office_location)}}" target="_blank">
                                                    <i class="bi bi-files"></i>
                                                </a>
                                            </td>
                                            <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->office_location}}</td>
                                            
                                        </tr>
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="padding:5px 10px;">Sec Registration or DTI Registration</th>
                                        <th style="padding:5px 10px;">Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($vendors->vendorSupplier->sec_registration)
                                        <tr>
                                            <td style="padding: 5px 10px;">
                                                <a href="{{url('storage/' .$vendors->vendorSupplier->sec_registration)}}" target="_blank">
                                                    <i class="bi bi-files"></i>
                                                </a>
                                            </td>
                                            <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->sec_registration}}</td>
                                            
                                        </tr>
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="padding:5px 10px;">Articles of Incorporation</th>
                                        <th style="padding:5px 10px;">Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($vendors->vendorSupplier->articles)
                                        <tr>
                                            <td style="padding: 5px 10px;">
                                                <a href="{{url('storage/' . $vendors->vendorSupplier->articles)}}" target="_blank">
                                                    <i class="bi bi-files"></i>
                                                </a>
                                            </td>
                                            <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->articles}}</td>
                                            
                                        </tr>
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="padding:5px 10px;">BIR Documents - BIR Form 2303</th>
                                        <th style="padding:5px 10px;">Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($vendors->vendorSupplier->bir_documents)
                                        <tr>
                                            <td style="padding: 5px 10px;">
                                                <a href="{{url('storage/' .$vendors->vendorSupplier->bir_documents)}}" target="_blank">
                                                    <i class="bi bi-files"></i>
                                                </a>
                                            </td>
                                            <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->bir_documents}}</td>
                                            
                                        </tr>
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="padding:5px 10px;">Latest General Information</th>
                                        <th style="padding:5px 10px;">Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($vendors->vendorSupplier->information_sheet)
                                        <tr>
                                            <td style="padding: 5px 10px;">
                                                <a href="{{url('storage/' .$vendors->vendorSupplier->information_sheet)}}" target="_blank">
                                                    <i class="bi bi-files"></i>
                                                </a>
                                            </td>
                                            <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->information_sheet}}</td>
                                            
                                        </tr>
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="padding:5px 10px;">Latest 3 year Audited FSw/ BIR Receipt</th>
                                        <th style="padding:5px 10px;">Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($vendors->vendorSupplier->audited_financial)
                                        <tr>
                                            <td style="padding: 5px 10px;">
                                                <a href="{{url('storage/' .$vendors->vendorSupplier->audited_financial)}}" target="_blank">
                                                    <i class="bi bi-files"></i>
                                                </a>
                                            </td>
                                            <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->audited_financial}}</td>
                                            
                                        </tr>
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="padding:5px 10px;">Business Permit</th>
                                        <th style="padding:5px 10px;">Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($vendors->vendorSupplier->business_permit)
                                        <tr>
                                            <td style="padding: 5px 10px;">
                                                <a href="{{url('storage/' .$vendors->vendorSupplier->business_permit)}}" target="_blank">
                                                    <i class="bi bi-files"></i>
                                                </a>
                                            </td>
                                            <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->business_permit}}</td>
                                            
                                        </tr>
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="padding:5px 10px;">Tax Incentive Cert/Large Taxpayer Notice</th>
                                        <th style="padding:5px 10px;">Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($vendors->vendorSupplier->tax_incentive)
                                        <tr>
                                            <td style="padding: 5px 10px;">
                                                <a href="{{url('storage/' .$vendors->vendorSupplier->tax_incentive)}}" target="_blank">
                                                    <i class="bi bi-files"></i>
                                                </a>
                                            </td>
                                            <td style="padding: 5px 10px;">{{$vendors->vendorSupplier->tax_incentive}}</td>
                                            
                                        </tr>
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="5" style="padding:5px 10px;">No data available.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
