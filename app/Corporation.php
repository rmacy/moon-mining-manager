<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Corporation
 *
 * @property int $id
 * @property int $corporation_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Refinery[] $refinery
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Corporation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Corporation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Corporation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Corporation whereCorporationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Corporation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Corporation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Corporation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Corporation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Corporation extends Model
{
    public function refinery()
    {
        return $this->hasMany('App\Refinery');
    }
}
