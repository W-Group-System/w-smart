<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierAccreditationContact extends Model
{
    use SoftDeletes;
    protected $table = "supplier_accreditation_contact";
    protected $fillable = [
        'accreditation_id', 'contacts', 'contacts_designation', 'contact_number', 'contacts_email'
    ];
}
