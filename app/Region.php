<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Region
 *
 * @property int $regionID
 * @property string|null $regionName
 * @property float|null $x
 * @property float|null $y
 * @property float|null $z
 * @property float|null $xMin
 * @property float|null $xMax
 * @property float|null $yMin
 * @property float|null $yMax
 * @property float|null $zMin
 * @property float|null $zMax
 * @property int|null $factionID
 * @property float|null $radius
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Moon[] $moons
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SolarSystem[] $systems
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereFactionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereRadius($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereRegionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereXMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereXMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereYMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereYMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereZ($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereZMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereZMin($value)
 * @mixin \Eloquent
 */
class Region extends Model
{

    protected $table = 'mapRegions';
    protected $primaryKey = 'regionID';
    public $incrementing = false;
    public $timestamps = false;

    public function systems()
    {
        return $this->hasMany('App\SolarSystem', 'regionID');
    }

    public function moons()
    {
        return $this->hasMany('App\Moon');
    }

}
