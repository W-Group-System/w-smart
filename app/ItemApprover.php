<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemApprover extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class,'subsidiary_id');
    }
}
