<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corporation extends Model
{
    public function refinery()
    {
        return $this->hasMany('App\Refinery');
    }
}
