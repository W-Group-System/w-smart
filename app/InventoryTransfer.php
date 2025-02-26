<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryTransfer extends Model
{
    public function inventory()
    {
        return $this->belongsTo(Inventory::class,'inventory_id');
    }
    public function uom()
    {
        return $this->belongsTo(Uoms::class);
    }
}
