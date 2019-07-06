<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SolarSystem
 *
 * @property int|null $regionID
 * @property int|null $constellationID
 * @property int $solarSystemID
 * @property string|null $solarSystemName
 * @property float|null $x
 * @property float|null $y
 * @property float|null $z
 * @property float|null $xMin
 * @property float|null $xMax
 * @property float|null $yMin
 * @property float|null $yMax
 * @property float|null $zMin
 * @property float|null $zMax
 * @property float|null $luminosity
 * @property int|null $border
 * @property int|null $fringe
 * @property int|null $corridor
 * @property int|null $hub
 * @property int|null $international
 * @property int|null $regional
 * @property int|null $constellation
 * @property float|null $security
 * @property int|null $factionID
 * @property float|null $radius
 * @property int|null $sunTypeID
 * @property string|null $securityClass
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Moon[] $moons
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Refinery[] $refinery
 * @property-read \App\Region|null $region
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereBorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereConstellation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereConstellationID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereCorridor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereFactionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereFringe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereHub($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereInternational($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereLuminosity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereRadius($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereRegional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereSecurity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereSecurityClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereSolarSystemID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereSolarSystemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereSunTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereXMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereXMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereYMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereYMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereZ($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereZMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolarSystem whereZMin($value)
 * @mixin \Eloquent
 */
class SolarSystem extends Model
{
    
    protected $table = 'mapSolarSystems';
    protected $primaryKey = 'solarSystemID';
    public $incrementing = false;
    public $timestamps = false;

    /**
     * Get the mining activity for the refinery.
     */
    public function refinery()
    {
        return $this->hasMany('App\Refinery');
    }

    /**
     * Get the region this system is part of.
     */
    public function region()
    {
        return $this->belongsTo('App\Region', 'regionID');
    }

    /**
     * Get the moons that are in this solar system.
     */
    public function moons()
    {
        return $this->hasMany('App\Moon');
    }

}
