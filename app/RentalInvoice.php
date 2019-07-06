<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\RentalInvoice
 *
 * @property int $id
 * @property int $renter_id
 * @property int $refinery_id
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Refinery $refinery
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalInvoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalInvoice whereRefineryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalInvoice whereRenterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RentalInvoice extends Model
{
    /**
     * Get the refinery record associated with the invoice.
     */
    public function refinery()
    {
        return $this->hasOne('App\Refinery', 'observer_id', 'refinery_id');
    }
}
