<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierAccreditation extends Model
{
    use SoftDeletes;
    protected $table = "supplier_accreditation";
    protected $fillable = [
        'relationship', 'corporate_name', 'telephone_no', 'fax_no', 'trade_name', 'business_address', 'billing_address', 'billing_telephone', 'billing_fax', 'billing_email', 'billing_years', 'nature_business', 'registration_no', 'date_registered', 'billing_tin', 'taxpayer_classification', 'lease_date', 'handover', 'attachments', 'suppliers_attachments', 'suppliers_terms', 'suppliers_specify', 'company_profile', 'audited_financial', 'office_location', 'business_permit', 'sec_registration', 'tax_incentive', 'articles', 'bir_documents', 'information_sheet'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function representative()
    {
        return $this->hasMany(SupplierAccreditationRep::class, 'accreditation_id', 'id');
    }

    public function owners()
    {
        return $this->hasMany(SupplierAccreditationOwner::class, 'accreditation_id', 'id');
    }

    public function contacts()
    {
        return $this->hasMany(SupplierAccreditationContact::class, 'accreditation_id', 'id');
    }

    public function references()
    {
        return $this->hasMany(SupplierAccreditationReference::class, 'accreditation_id', 'id');
    }

    public function customers()
    {
        return $this->hasMany(SupplierAccreditationCustomer::class, 'accreditation_id', 'id');
    }
}
