<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRequest extends Model
{
    use SoftDeletes;
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function assignedTo()
    {
        return $this->belongsTo(User::class,'assigned_to');
    }
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }
    public function purchaseRequestFiles()
    {
        return $this->hasMany(PurchaseRequestFile::class);
    }
    public function rfqEmail()
    {
        return $this->hasMany(RfqEmail::class);
    }
    public function rfqItem()
    {
        return $this->hasMany(RfqItem::class);
    }
    public function rfqFile()
    {
        return $this->hasMany(RfqFile::class);
    }
    public function purchaseOrder()
    {
        return $this->hasOne(PurchaseOrder::class);
    }
    public function company()
    {
        return $this->belongsTo(Subsidiary::class,'subsidiary','subsidiary_name');
    }
    public function classification()
    {
        return $this->belongsTo(Classification::class);
    }
    public function purchaseRequestApprovers()
    {
        return $this->hasMany(PurchaseRequestApprover::class);
    }
    public function estimateAmount()
    {
        return $this->hasOne(EstimatedTotalAmount::class);
    }
}
