<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subsidiary extends Model
{
    protected $primaryKey = 'subsidiary_id';

    public function approvers()
    {
        return $this->hasMany(Approver::class,'subsidiary_id','subsidiary_id');
    }
}
