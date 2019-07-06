<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use jdavidbakr\ReplaceableModel\ReplaceableModel;

/**
 * App\MiningActivity
 *
 * @property int $id
 * @property string $hash
 * @property int $miner_id
 * @property int $refinery_id
 * @property int $type_id
 * @property int $quantity
 * @property float|null $tax_amount
 * @property int $processed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Miner $miner
 * @property-read \App\Refinery $refinery
 * @property-read \App\Type $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MiningActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MiningActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MiningActivity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MiningActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MiningActivity whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MiningActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MiningActivity whereMinerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MiningActivity whereProcessed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MiningActivity whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MiningActivity whereRefineryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MiningActivity whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MiningActivity whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MiningActivity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MiningActivity extends Model
{

    // Allow for using insertIgnore calls on this model.
    use ReplaceableModel;
    
    protected $table = 'mining_activities';

    /**
     * Get the miner record associated with the activity.
     */
    public function miner()
    {
        return $this->belongsTo('App\Miner');
    }

    /**
     * Get the refinery record associated with the activity.
     */
    public function refinery()
    {
        return $this->belongsTo('App\Refinery', 'refinery_id', 'observer_id');
    }

    /**
     * Get the type record associated with the activity.
     */
    public function type()
    {
        return $this->belongsTo('App\Type', 'type_id', 'typeID');
    }

}
