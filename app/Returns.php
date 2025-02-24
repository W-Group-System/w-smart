<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    public function requestor()
    {
        return $this->belongsTo(User::class,'requestor_id');
    }
    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class,'subsidiaryid');
    }
    public function uom()
    {
        return $this->belongsTo(Uoms::class,'uom_id');
    }
}
