<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Whitelist
 *
 * @property int $id
 * @property int $eve_id
 * @property int $is_admin
 * @property int $form_mail
 * @property int $added_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @property-read \App\User $whitelister
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Whitelist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Whitelist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Whitelist query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Whitelist whereAddedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Whitelist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Whitelist whereEveId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Whitelist whereFormMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Whitelist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Whitelist whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Whitelist whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Whitelist extends Model
{
    
    protected $table = 'whitelist';

    /**
     * Get the user record associated with the user.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'eve_id', 'eve_id');
    }

    /**
     * Get the user record associated with the user who added this user.
     */
    public function whitelister()
    {
        return $this->belongsTo('App\User', 'added_by', 'eve_id');
    }

}
