<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgencyProfile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agency_profile';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agency_id', 'agency_logo', 'address', 'zip_code',
        'telephone_no', 'email', 'website', 'mobile_no',
        'agency_head'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
