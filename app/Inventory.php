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
        'category_id',
        'subcategory_name',
        'subcategory_id',
        'uom_id',
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
