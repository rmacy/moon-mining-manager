<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Renter
 *
 * @property int $id
 * @property string $type
 * @property int $character_id
 * @property int|null $refinery_id
 * @property int|null $moon_id
 * @property string|null $notes
 * @property float $monthly_rental_fee
 * @property float $amount_owed
 * @property string|null $generate_invoices_job_run
 * @property string $start_date
 * @property string|null $end_date
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Moon $moon
 * @property-read \App\Refinery $refinery
 * @property-read \App\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter whereAmountOwed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter whereGenerateInvoicesJobRun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter whereMonthlyRentalFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter whereMoonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter whereRefineryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Renter whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Renter extends Model
{
    protected $table = 'renters';

    /**
     * Get the refinery being rented.
     */
    public function refinery()
    {
        return $this->hasOne('App\Refinery', 'observer_id', 'refinery_id');
    }

    /**
     * Get the moon where this refinery is located.
     */
    public function moon()
    {
        return $this->hasOne('App\Moon', 'id', 'moon_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'updated_by', 'eve_id');
    }
}
