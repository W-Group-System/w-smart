<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    public function transferFrom()
    {
        return $this->belongsTo(Subsidiary::class,'transfer_from','subsidiary_id');
    }
    public function transferTo()
    {
        return $this->belongsTo(Subsidiary::class,'transfer_to','subsidiary_id');
    }
    public function inventoryTransfer()
    {
        return $this->hasMany(InventoryTransfer::class);
    }
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
