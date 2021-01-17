<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Bio extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bio';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'date_log', 'time_in_am', 'time_out_am',
        'time_in_pm', 'time_out_pm', 'remarks'
    ];

    public static function boot()
    {
         parent::boot();
         self::creating(function($model){
             $model->id = self::generateUuid();
         });
    }

    public static function generateUuid()
    {
         return Uuid::generate();
    }
}
