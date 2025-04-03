<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderApprover extends Model
{
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
