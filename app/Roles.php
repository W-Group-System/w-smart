<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    public function user_access_module()
    {
        return $this->hasMany(UserAccessModule::class,'role_id');
    }
}
