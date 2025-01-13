<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierAccreditationRep extends Model
{
    use SoftDeletes;
    protected $table = "supplier_accreditation_rep";
    protected $fillable = [
        'accreditation_id', 'name', 'designation', 'contact', 'email'
    ];
}
