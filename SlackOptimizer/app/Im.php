<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Im extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ims';

    /**
     * Set timestamps off.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'slack_user_id', 'chat_id', 'username', 'name'];

}
