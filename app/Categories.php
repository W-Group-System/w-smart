<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    public function subCategory()
    {
        return $this->hasMany(Subcategories::class,'category_id');
    }
}
