<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccessModule extends Model
{
    public function feature()
    {
        return $this->belongsTo(Features::class);
    }
    public function subfeature()
    {
        return $this->belongsTo(Subfeatures::class);
    }
}
