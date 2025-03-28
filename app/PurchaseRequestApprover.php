<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestApprover extends Model
{
    public function purchase_request()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
