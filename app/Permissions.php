<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    public function feature()
    {
        return $this->belongsTo(Features::class,'featureid');
    }
}
