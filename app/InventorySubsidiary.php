<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventorySubsidiary extends Model
{
    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class,'subsidiary_id');
    }
}
