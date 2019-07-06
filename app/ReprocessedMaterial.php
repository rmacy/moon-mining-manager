<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ReprocessedMaterial
 *
 * @property int $id
 * @property int $materialTypeID
 * @property float $average_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ReprocessedMaterialsHistory[] $history
 * @property-read \App\Type $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReprocessedMaterial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReprocessedMaterial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReprocessedMaterial query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReprocessedMaterial whereAveragePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReprocessedMaterial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReprocessedMaterial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReprocessedMaterial whereMaterialTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReprocessedMaterial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReprocessedMaterial extends Model
{
    protected $table = 'reprocessed_materials';
    protected $primaryKey = 'materialTypeID';

    public function type()
    {
        return $this->hasOne('App\Type', 'typeID', 'materialTypeID');
    }

    public function history()
    {
        return $this->hasMany('App\ReprocessedMaterialsHistory', 'type_id', 'materialTypeID');
    }
}
