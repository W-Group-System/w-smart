<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    public function inventory()
    {
        return $this->belongsTo(Inventory::class,'inventory_id','inventory_id');
    }
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
