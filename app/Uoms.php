<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uoms extends Model
{
    protected $fillable = [
        'uomp', 
        'uomp_value', 
        'uoms', 
        'uoms_value', 
        'uomt', 
        'uomt_value',
        'relation_id'
    ];
}
