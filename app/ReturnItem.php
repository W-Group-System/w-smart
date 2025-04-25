<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    public function inventory()
    {
        return $this->belongsTo(Inventory::class,'inventory_id', 'inventory_id');
    }
    public function uom()
    {
        return $this->belongsTo(Uoms::class,'uom_id');
    }
}
