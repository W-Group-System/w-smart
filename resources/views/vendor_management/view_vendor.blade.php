@extends('layouts.dashboard_layout')

@section('dashboard_content')
<div class="container-fluid">

    <div class="card p-4 mt-3" style="border: 1px solid #ddd; border-radius: 20px; margin-top: -25px;">

        <p class="h5 mt-4">Primary Information</p>
        <hr class="mt-0">
        <div class="row">
            <div class="col-md-6 mb-2">
                <p class="m-0 fw-bold">Vendor Name:</p>
                {{$vendors->vendor_name}}
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
                                <th style="padding:5px 10px;">FAX Number</th>
                                <th style="padding:5px 10px;">Alternative Phone Number</th>
                                <th style="padding:5px 10px;">Address</th>
                                <th style="padding:5px 10px;">Contact Person</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($vendors->vendorContact->isNotEmpty())
                                @foreach ($vendors->vendorContact as $contact)
                                    <tr>
                                        <td style="padding: 5px 10px;">{{$contact->work_email}}</td>
                                        <td style="padding: 5px 10px;">{{$contact->phone_no}}</td>
                                        <td style="padding: 5px 10px;">{{$contact->fax_no}}</td>
                                        <td style="padding: 5px 10px;">{{$contact->alternative_phone}}</td>
                                        <td style="padding: 5px 10px;">{{$contact->address}}</td>
                                        <td style="padding: 5px 10px;">{{$contact->contact_person}}</td>
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
                            @if($vendors->companyProfile->isNotEmpty())
                                @foreach ($vendors->companyProfile as $file)
                                    <tr>
                                        <td style="padding: 5px 10px;">
                                            <a href="{{url($file->file_path)}}" target="_blank">
                                                <i class="bi bi-files"></i>
                                            </a>
                                        </td>
                                        <td style="padding: 5px 10px;">{{$file->file_name}}</td>
                                        
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
                            @if($vendors->officeLocation->isNotEmpty())
                                @foreach ($vendors->officeLocation as $file)
                                    <tr>
                                        <td style="padding: 5px 10px;">
                                            <a href="{{url($file->file_path)}}" target="_blank">
                                                <i class="bi bi-files"></i>
                                            </a>
                                        </td>
                                        <td style="padding: 5px 10px;">{{$file->file_name}}</td>
                                        
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
                            @if($vendors->dtiReg->isNotEmpty())
                                @foreach ($vendors->dtiReg as $file)
                                    <tr>
                                        <td style="padding: 5px 10px;">
                                            <a href="{{url($file->file_path)}}" target="_blank">
                                                <i class="bi bi-files"></i>
                                            </a>
                                        </td>
                                        <td style="padding: 5px 10px;">{{$file->file_name}}</td>
                                        
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
                            @if($vendors->articles->isNotEmpty())
                                @foreach ($vendors->articles as $file)
                                    <tr>
                                        <td style="padding: 5px 10px;">
                                            <a href="{{url($file->file_path)}}" target="_blank">
                                                <i class="bi bi-files"></i>
                                            </a>
                                        </td>
                                        <td style="padding: 5px 10px;">{{$file->file_name}}</td>
                                        
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
                            @if($vendors->birDoc->isNotEmpty())
                                @foreach ($vendors->birDoc as $file)
                                    <tr>
                                        <td style="padding: 5px 10px;">
                                            <a href="{{url($file->file_path)}}" target="_blank">
                                                <i class="bi bi-files"></i>
                                            </a>
                                        </td>
                                        <td style="padding: 5px 10px;">{{$file->file_name}}</td>
                                        
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
                            @if($vendors->genInfo->isNotEmpty())
                                @foreach ($vendors->genInfo as $file)
                                    <tr>
                                        <td style="padding: 5px 10px;">
                                            <a href="{{url($file->file_path)}}" target="_blank">
                                                <i class="bi bi-files"></i>
                                            </a>
                                        </td>
                                        <td style="padding: 5px 10px;">{{$file->file_name}}</td>
                                        
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
            <div class="col-md-6 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="padding:5px 10px;">Corporate Secretary's Certificate</th>
                                <th style="padding:5px 10px;">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($vendors->corpCert->isNotEmpty())
                                @foreach ($vendors->corpCert as $file)
                                    <tr>
                                        <td style="padding: 5px 10px;">
                                            <a href="{{url($file->file_path)}}" target="_blank">
                                                <i class="bi bi-files"></i>
                                            </a>
                                        </td>
                                        <td style="padding: 5px 10px;">{{$file->file_name}}</td>
                                        
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
                            @if($vendors->auditBir->isNotEmpty())
                                @foreach ($vendors->auditBir as $file)
                                    <tr>
                                        <td style="padding: 5px 10px;">
                                            <a href="{{url($file->file_path)}}" target="_blank">
                                                <i class="bi bi-files"></i>
                                            </a>
                                        </td>
                                        <td style="padding: 5px 10px;">{{$file->file_name}}</td>
                                        
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
                            @if($vendors->busPermit->isNotEmpty())
                                @foreach ($vendors->busPermit as $file)
                                    <tr>
                                        <td style="padding: 5px 10px;">
                                            <a href="{{url($file->file_path)}}" target="_blank">
                                                <i class="bi bi-files"></i>
                                            </a>
                                        </td>
                                        <td style="padding: 5px 10px;">{{$file->file_name}}</td>
                                        
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
                            @if($vendors->taxIncentive->isNotEmpty())
                                @foreach ($vendors->taxIncentive as $file)
                                    <tr>
                                        <td style="padding: 5px 10px;">
                                            <a href="{{url($file->file_path)}}" target="_blank">
                                                <i class="bi bi-files"></i>
                                            </a>
                                        </td>
                                        <td style="padding: 5px 10px;">{{$file->file_name}}</td>
                                        
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
            <div class="col-md-6 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="padding:5px 10px;">Sample Sales / Sales Invoice</th>
                                <th style="padding:5px 10px;">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($vendors->sampleInvoice->isNotEmpty())
                                @foreach ($vendors->sampleInvoice as $file)
                                    <tr>
                                        <td style="padding: 5px 10px;">
                                            <a href="{{url($file->file_path)}}" target="_blank">
                                                <i class="bi bi-files"></i>
                                            </a>
                                        </td>
                                        <td style="padding: 5px 10px;">{{$file->file_name}}</td>
                                        
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
    </div>
</div>

@endsection
