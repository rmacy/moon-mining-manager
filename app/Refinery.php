<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Refinery
 *
 * @property int $id
 * @property int $observer_id
 * @property int|null $corporation_id
 * @property string|null $extraction_start_time
 * @property string|null $chunk_arrival_time
 * @property string|null $natural_decay_time
 * @property int|null $claimed_by_primary
 * @property int|null $claimed_by_secondary
 * @property string|null $custom_detonation_time
 * @property string $observer_type
 * @property string|null $name
 * @property int|null $solar_system_id
 * @property float $income
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Corporation|null $corporation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\MiningActivity[] $mining_activity
 * @property-read \App\User|null $primary
 * @property-read \App\User|null $secondary
 * @property-read \App\SolarSystem|null $system
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery whereChunkArrivalTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery whereClaimedByPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery whereClaimedBySecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery whereCorporationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery whereCustomDetonationTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery whereExtractionStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery whereIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery whereNaturalDecayTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery whereObserverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery whereObserverType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery whereSolarSystemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refinery whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Refinery extends Model
{

    protected $table = 'refineries';

    /**
     * Get the mining activity for the refinery.
     */
    public function mining_activity()
    {
        return $this->hasMany('App\MiningActivity', 'refinery_id', 'observer_id');
    }

    /**
     * Get the solar system record associated with the activity.
     */
    public function system()
    {
        return $this->belongsTo('App\SolarSystem', 'solar_system_id');
    }

    /**
     * Get the user record for the primary detonation character.
     */
    public function primary()
    {
        return $this->belongsTo('App\User', 'claimed_by_primary', 'eve_id');
    }

    /**
     * Get the user record for the secondary detonation character.
     */
    public function secondary()
    {
        return $this->belongsTo('App\User', 'claimed_by_secondary', 'eve_id');
    }

    public function corporation()
    {
        return $this->belongsTo('App\Corporation', 'corporation_id', 'corporation_id');
    }
}
