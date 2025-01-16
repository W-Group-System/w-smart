<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierAccreditationOwner extends Model
{
    use SoftDeletes;
    protected $table = "supplier_accreditation_owner";
    protected $fillable = [
        'accreditation_id', 'owners', 'owners_designation', 'address'
    ];
}
