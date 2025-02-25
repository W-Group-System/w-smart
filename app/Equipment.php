<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';

    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class,'subsidiary_id','subsidiary_id');
    }
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
