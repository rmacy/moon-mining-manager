<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Payment
 *
 * @property int $id
 * @property int $miner_id
 * @property int|null $ref_id
 * @property int|null $created_by
 * @property float $amount_received
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User|null $createdBy
 * @property-read \App\Miner $miner
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereAmountReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereMinerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereRefId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
