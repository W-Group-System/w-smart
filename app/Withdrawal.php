<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    public function requestor()
    {
        return $this->belongsTo(User::class,'requestor_id');
    }
    public function withdrawalItem()
    {
        return $this->hasOne(WithdrawalItems::class);
    }
}
