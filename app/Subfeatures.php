<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subfeatures extends Model
{
    public function feature()
    {
        return $this->belongsTo(Features::class, 'feature_id');
    }
}
