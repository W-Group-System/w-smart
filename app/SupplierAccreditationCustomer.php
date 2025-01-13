<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierAccreditationCustomer extends Model
{
    use SoftDeletes;
    protected $table = "supplier_accreditation_customer";
    protected $fillable = [
        'accreditation_id', 'customer_company_name', 'customer_contact_person', 'customer_tel_no', 'customer_terms'
    ];
}
