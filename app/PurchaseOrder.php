<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }
    public function rfqEmail()
    {
        return $this->belongsTo(RfqEmail::class);
    }
}
