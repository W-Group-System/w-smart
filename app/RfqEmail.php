<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RfqEmail extends Model
{
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
