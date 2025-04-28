<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }
    public function purchaseOrderItem()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
    public function supplier()
    {
        return $this->belongsTo(SupplierAccreditation::class,'supplier_id');
    }
    public function purchaseOrderApprovers()
    {
        return $this->hasMany(PurchaseOrderApprover::class);
    }
    public function grn()
    {
        return $this->hasMany(Grn::class);
    }
}
