<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrnItemHistory extends Model
{
    protected $table = 'grn_item_history';

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'inventory_id');
    }
}
