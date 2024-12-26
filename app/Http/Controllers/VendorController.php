<?php

namespace App\Http\Controllers;

use App\Department;
use App\Models\User;
use App\PurchaseItem;
use App\PurchaseRequest;
use App\PurchaseRequestFile;
use App\Subsidiary;
use App\Vendor;
use App\VendorAttachment;
use App\VendorCategory;
use App\VendorContact;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::paginate(10);   
        $categories = VendorCategory::get() ;
        $subsidiaries = Subsidiary::get() ;
        return view('vendor_management', compact('vendors', 'categories', 'subsidiaries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $maxRequestId = Vendor::max('request_id');
        $newRequestId = $maxRequestId ? $maxRequestId + 1 : 1;

        $new_vendor = new Vendor();
        $new_vendor->requestor_name =  $request->request_id;
        $new_vendor->request_id = $newRequestId;
        $new_vendor->category =  $request->vendorCategory;
        $new_vendor->vendor_name =  $request->vendor_name;
        $new_vendor->sole_proprietor =  $request->has('sole_proprietor') ? 1 : 0;
        $new_vendor->company_name =  $request->company_name;
        // $new_vendor->vendor_status =  $request->vendor_status;
        $new_vendor->vendor_status = 'Pending';
        $new_vendor->classification_type =  $request->classification_type;
        $new_vendor->subsidiary = json_encode($request->subsidiary);
        $new_vendor->tin =  $request->tin;
        $new_vendor->registration_dti_no =  $request->registration_dti_no;
        $new_vendor->date_registered =  $request->date_registered;
        $new_vendor->remarks =  $request->remarks;
        $new_vendor->save();

        foreach($request->work_email as $key=>$work_email)
        {
            $vendor_contact = new VendorContact;
            $vendor_contact->vendor_id = $new_vendor->id;
            $vendor_contact->work_email = $work_email;
            $vendor_contact->phone_no = $request->phone_no[$key];
            $vendor_contact->fax_no = $request->fax_no[$key];
            $vendor_contact->alternative_phone = $request->alternative_phone[$key];
            $vendor_contact->address = $request->address[$key];
            $vendor_contact->contact_person = $request->contact_person[$key];
            $vendor_contact->save();
        }

        $vendorId = $new_vendor->id;
        $documentTypes = [
            'company_profile',
            'office_location_map',
            'sec_dti_reg',
            'articles_of_inc',
            'bir_form',
            'latest_general_info',
            'corporate_sec_cert',
            'audited_fs_bir',
            'business_permit',
            'tax_incentive',
            'sample_invoice',
        ];
        foreach ($documentTypes as $documentType) {
            if ($request->hasFile($documentType)) {
                $files = $request->file($documentType);
    
                if (is_array($files)) {
                    foreach ($files as $file) {
                        $this->saveAttachment($file, $vendorId, $documentType);
                    }
                } else {
                    $this->saveAttachment($files, $vendorId, $documentType);
                }
            }
        }

        Alert::success('Successfully Saved')->persistent('Dismiss');
        return back();
    }

    private function saveAttachment($file, $vendorId, $documentType)
    {
        $destinationPath = public_path('vendor_attachments');
    
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move($destinationPath, $fileName);

        $vendorAttachment = new VendorAttachment;
        $vendorAttachment->vendor_id = $vendorId;
        $vendorAttachment->file_name = $fileName;
        $vendorAttachment->file_path = 'vendor_attachments/' . $fileName;
        $vendorAttachment->document_type = $documentType;
        $vendorAttachment->save();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendors = Vendor::with('vendorContact','vendorCategory','companyProfile')->findOrFail($id);
        return view('vendor_management.view_vendor', compact('vendors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        

        $vendor = Vendor::findOrFail($id);
        $vendor->category =  $request->vendorCategory;
        $vendor->vendor_name =  $request->vendor_name;
        $vendor->sole_proprietor =  $request->has('sole_proprietor') ? 1 : 0;
        $vendor->company_name =  $request->company_name;
        $vendor->vendor_status =  $request->vendor_status;
        $vendor->classification_type =  $request->classification_type;
        $vendor->subsidiary = json_encode($request->subsidiary);
        $vendor->tin =  $request->tin;
        $vendor->registration_dti_no =  $request->registration_dti_no;
        $vendor->date_registered =  $request->date_registered;
        $vendor->remarks =  $request->remarks;
        $vendor->save();

        foreach ($request->work_email as $key => $work_email) {
            if (!empty($request->contact_id[$key])) {
                $vendor_contact = VendorContact::find($request->contact_id[$key]);
                if ($vendor_contact) {
                    $vendor_contact->work_email = $work_email;
                    $vendor_contact->phone_no = $request->phone_no[$key];
                    $vendor_contact->fax_no = $request->fax_no[$key];
                    $vendor_contact->alternative_phone = $request->alternative_phone[$key];
                    $vendor_contact->address = $request->address[$key];
                    $vendor_contact->contact_person = $request->contact_person[$key];
                    $vendor_contact->save();
                }
            } else {
                $vendor_contact = new VendorContact;
                $vendor_contact->vendor_id = $vendor->id;
                $vendor_contact->work_email = $work_email;
                $vendor_contact->phone_no = $request->phone_no[$key];
                $vendor_contact->fax_no = $request->fax_no[$key];
                $vendor_contact->alternative_phone = $request->alternative_phone[$key];
                $vendor_contact->address = $request->address[$key];
                $vendor_contact->contact_person = $request->contact_person[$key];
                $vendor_contact->save();
            }
        }
        

        $vendorId = $vendor->id;
        $documentTypes = [
            'company_profile',
            'office_location_map',
            'sec_dti_reg',
            'articles_of_inc',
            'bir_form',
            'latest_general_info',
            'corporate_sec_cert',
            'audited_fs_bir',
            'business_permit',
            'tax_incentive',
            'sample_invoice',
        ];
        foreach ($documentTypes as $documentType) {
            if ($request->hasFile($documentType)) {
                $files = $request->file($documentType);
    
                if (is_array($files)) {
                    foreach ($files as $file) {
                        $this->saveAttachment($file, $vendorId, $documentType);
                    }
                } else {
                    $this->saveAttachment($files, $vendorId, $documentType);
                }
            }
        }

        Alert::success('Successfully Saved')->persistent('Dismiss');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
