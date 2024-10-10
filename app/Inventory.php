<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $primaryKey = 'inventory_id';

    protected $fillable = [
        'item_code',
        'item_description',
        'item_category',
        'uomp',
        'uoms',
        'uomt',
        'qty',
        'cost',
        'usage',
        'subsidiaryid',
        'subsidiary',
        'date',
        'remarks',
    ];
}
