<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'emp_id', 'bio_id', 'office_id', 'division_id',
        'unit_id', 'first_name', 'mid_name', 'last_name',
        'position', 'birthday', 'gender', 'user_name',
        'mobile_no', 'email', 'emp_status', 'email_verified_at',
        'password', 'avatar', 'e_signature', 'status', 'user_role',
        'approved_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'user_role' => '4',
    ];
}
