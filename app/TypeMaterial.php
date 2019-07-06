<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TypeMaterial
 *
 * @property int $typeID
 * @property int $materialTypeID
 * @property int $quantity
 * @property-read \App\Type $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeMaterial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeMaterial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeMaterial query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeMaterial whereMaterialTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeMaterial whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeMaterial whereTypeID($value)
 * @mixin \Eloquent
 */
class TypeMaterial extends Model
{
    protected $table = 'invTypeMaterials';
    public $incrementing = false;
    public $timestamps = false;

    public function type()
    {
        return $this->belongsTo('App\Type', 'typeID', 'typeID');
    }

}
