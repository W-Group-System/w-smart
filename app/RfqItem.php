<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RfqItem extends Model
{
    public function purchaseItem()
    {
        return $this->belongsTo(PurchaseItem::class);
    }
    
}
