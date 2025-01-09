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
}
