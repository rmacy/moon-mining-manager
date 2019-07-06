<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\RentalPayment
 *
 * @property int $id
 * @property int $renter_id
 * @property int $refinery_id
 * @property int|null $ref_id
 * @property int|null $created_by
 * @property float $amount_received
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User|null $createdBy
 * @property-read \App\Refinery $refinery
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalPayment whereAmountReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalPayment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalPayment whereRefId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalPayment whereRefineryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalPayment whereRenterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalPayment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RentalPayment extends Model
{
    /**
     * Get the refinery record associated with the invoice.
     */
    public function refinery()
    {
        return $this->hasOne('App\Refinery', 'observer_id', 'refinery_id');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by', 'eve_id');
    }
}
