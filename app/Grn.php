<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grn extends Model
{
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class,'purchase_order_id');
    }
    public function grnItemHistory()
    {
        return $this->hasMany(GrnItemHistory::class);
    }
}
