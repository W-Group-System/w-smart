<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RfqEmail extends Model
{
    public function supplier()
    {
        return $this->belongsTo(SupplierAccreditation::class,'supplier_id');
    }
}
