<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TaxRate
 *
 * @property int $id
 * @property int $type_id
 * @property int $check_materials
 * @property float $value
 * @property float $tax_rate
 * @property int $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TypeMaterial[] $reprocessed_materials
 * @property-read \App\Type $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaxRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaxRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaxRate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaxRate whereCheckMaterials($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaxRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaxRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaxRate whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaxRate whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaxRate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaxRate whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaxRate whereValue($value)
 * @mixin \Eloquent
 */
class TaxRate extends Model
{
    protected $table = 'taxes';

    /**
     * Get the type record associated with the tax rate.
     */
    public function type()
    {
        return $this->belongsTo('App\Type', 'type_id');
    }

    /**
     * Get the reprocessed material records associated with the tax rate.
     */
    public function reprocessed_materials()
    {
        return $this->hasMany('App\TypeMaterial', 'typeID', 'type_id');
    }

}
