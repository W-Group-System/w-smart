<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;
    public function user()
    {
        return $this->belongsTo(User::class, 'requestor_name', 'id');
    }

    public function vendorContact()
    {
        return $this->hasMany(VendorContact::class);
    }
    public function vendorCategory()
    {
        return $this->belongsTo(VendorCategory::class, 'category', 'id');
    }
    public function companyProfile()
    {
        return $this->hasMany(VendorAttachment::class, 'vendor_id', 'id')
        ->where('document_type', 'company_profile');
    }
    public function officeLocation()
    {
        return $this->hasMany(VendorAttachment::class, 'vendor_id', 'id')
        ->where('document_type', 'office_location_map');
    }
    public function dtiReg()
    {
        return $this->hasMany(VendorAttachment::class, 'vendor_id', 'id')
        ->where('document_type', 'sec_dti_reg');
    }
    public function articles()
    {
        return $this->hasMany(VendorAttachment::class, 'vendor_id', 'id')
        ->where('document_type', 'articles_of_inc');
    }
    public function birDoc()
    {
        return $this->hasMany(VendorAttachment::class, 'vendor_id', 'id')
        ->where('document_type', 'bir_form');
    }
    public function genInfo()
    {
        return $this->hasMany(VendorAttachment::class, 'vendor_id', 'id')
        ->where('document_type', 'latest_general_info');
    }
    public function corpCert()
    {
        return $this->hasMany(VendorAttachment::class, 'vendor_id', 'id')
        ->where('document_type', 'corporate_sec_cert');
    }
    public function auditBir()
    {
        return $this->hasMany(VendorAttachment::class, 'vendor_id', 'id')
        ->where('document_type', 'audited_fs_bir');
    }
    public function busPermit()
    {
        return $this->hasMany(VendorAttachment::class, 'vendor_id', 'id')
        ->where('document_type', 'business_permit');
    }
    public function taxIncentive()
    {
        return $this->hasMany(VendorAttachment::class, 'vendor_id', 'id')
        ->where('document_type', 'tax_incentive');
    }
    public function sampleInvoice()
    {
        return $this->hasMany(VendorAttachment::class, 'vendor_id', 'id')
        ->where('document_type', 'tax_incentive');
    }
    
}
