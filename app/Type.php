<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Type
 *
 * @property int $typeID
 * @property int|null $groupID
 * @property string|null $typeName
 * @property string|null $description
 * @property float|null $mass
 * @property float|null $volume
 * @property float|null $capacity
 * @property int|null $portionSize
 * @property int|null $raceID
 * @property float|null $basePrice
 * @property int|null $published
 * @property int|null $marketGroupID
 * @property int|null $iconID
 * @property int|null $soundID
 * @property int|null $graphicID
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TypeMaterial[] $type_materials
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereBasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereGraphicID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereIconID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereMarketGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereMass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type wherePortionSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereRaceID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereSoundID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereVolume($value)
 * @mixin \Eloquent
 */
class Type extends Model
{
    
    protected $table = 'invTypes';
    protected $primaryKey = 'typeID';
    public $incrementing = false;
    public $timestamps = false;

    public function type_materials()
    {
        return $this->hasMany('App\TypeMaterial', 'typeID', 'typeID');
    }

}
