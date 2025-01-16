<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierAccreditationReference extends Model
{
    use SoftDeletes;
    protected $table = "supplier_accreditation_reference";
    protected $fillable = [
        'accreditation_id', 'company_name', 'contact_person', 'tel_no', 'terms'
    ];
}
