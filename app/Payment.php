<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    /**
     * Get the miner record associated with the payment.
     */
    public function miner()
    {
        return $this->belongsTo('App\Miner', 'miner_id', 'eve_id');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by', 'eve_id');
    }
}
