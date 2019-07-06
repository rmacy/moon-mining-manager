<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Invoice
 *
 * @property int $id
 * @property int $miner_id
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Miner $miner
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereMinerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    
    /**
     * Get the miner record associated with the invoice.
     */
    public function miner()
    {
        return $this->belongsTo('App\Miner');
    }

}
