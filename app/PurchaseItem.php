<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    public function inventory()
    {
        return $this->belongsTo(Inventory::class,'inventory_id');
    }
}
