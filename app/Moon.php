<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Moon
 *
 * @property int $id
 * @property int $region_id
 * @property int $solar_system_id
 * @property int $planet
 * @property int $moon
 * @property int $mineral_1_type_id
 * @property float $mineral_1_percent
 * @property int $mineral_2_type_id
 * @property float $mineral_2_percent
 * @property int|null $mineral_3_type_id
 * @property float|null $mineral_3_percent
 * @property int|null $mineral_4_type_id
 * @property float|null $mineral_4_percent
 * @property float $monthly_rental_fee
 * @property float $previous_monthly_rental_fee
 * @property int|null $renter_id
 * @property int $alliance_owned
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $active_renter
 * @property-read \App\Type $mineral_1
 * @property-read \App\Type $mineral_2
 * @property-read \App\Type|null $mineral_3
 * @property-read \App\Type|null $mineral_4
 * @property-read \App\Region $region
 * @property-read \App\SolarSystem $system
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereAllianceOwned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereMineral1Percent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereMineral1TypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereMineral2Percent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereMineral2TypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereMineral3Percent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereMineral3TypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereMineral4Percent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereMineral4TypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereMonthlyRentalFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereMoon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon wherePlanet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon wherePreviousMonthlyRentalFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereRenterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereSolarSystemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moon whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Moon extends Model
{
    
    /**
     * Get the solar system where this moon is located.
     */
    public function system()
    {
        return $this->belongsTo('App\SolarSystem', 'solar_system_id');
    }

    /**
     * Get the region this moon is part of.
     */
    public function region()
    {
        return $this->belongsTo('App\Region', 'region_id');
    }

    /**
     * Find any active renter.
     */
    public function getActiveRenterAttribute() {
        $active_renter = Renter::whereRaw(
            'moon_id = ' . $this->id .
            ' AND refinery_id IS NOT NULL AND start_date <= CURDATE() ' .
            'AND (end_date IS NULL OR end_date >= CURDATE())'
        )->first();
        return (isset($active_renter)) ? $active_renter : NULL;
    }

    /**
     * Get the mineral type object for each of the possible mineral types.
     */
    public function mineral_1()
    {
        return $this->belongsTo('App\Type', 'mineral_1_type_id');
    }

    public function mineral_2()
    {
        return $this->belongsTo('App\Type', 'mineral_2_type_id');
    }

    public function mineral_3()
    {
        return $this->belongsTo('App\Type', 'mineral_3_type_id');
    }

    public function mineral_4()
    {
        return $this->belongsTo('App\Type', 'mineral_4_type_id');
    }

}
