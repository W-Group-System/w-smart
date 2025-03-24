<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    public function subfeature()
    {
        return $this->hasMany(Subfeatures::class,'feature_id');
    }
}
