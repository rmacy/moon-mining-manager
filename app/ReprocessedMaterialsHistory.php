<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ReprocessedMaterialsHistory
 *
 * @property int $id
 * @property int $type_id
 * @property float $average_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\ReprocessedMaterial $reprocessed_material
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReprocessedMaterialsHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReprocessedMaterialsHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReprocessedMaterialsHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReprocessedMaterialsHistory whereAveragePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReprocessedMaterialsHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReprocessedMaterialsHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReprocessedMaterialsHistory whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ReprocessedMaterialsHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReprocessedMaterialsHistory extends Model
{
    protected $table = 'reprocessed_materials_history';

    public function reprocessed_material()
    {
        return $this->belongsTo('App\ReprocessedMaterial', 'materialTypeID');
    }
}
