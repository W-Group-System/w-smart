<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierEvaluation extends Model
{
    use SoftDeletes;
    protected $table = "supplier_evaluation";

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function results()
    {
        return $this->hasMany(SupplierEvaluationResult::class, 'evaluation_id', 'id');
    }
    
    public function code()
    {
        return $this->hasMany(SupplierAccreditation::class, 'id', 'vendor_id');
    }

}
