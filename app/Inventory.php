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

    public function uom()
    {
        return $this->belongsTo(Uoms::class,'uom_id');
    }
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategories::class);
    }
    public function inventory_subsidiary()
    {
        return $this->hasMany(InventorySubsidiary::class,'inventory_id');
    }
    public function subsidiaryId()
    {
        return $this->belongsTo(Subsidiary::class,'subsidiary','subsidiary_id');
    }
}
