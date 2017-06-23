<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
	
	protected $table = 'user';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'unique_number',
        'first_name', 
        'last_name', 
        'phone_number', 
        'latitude', 
        'longitude', 
        'address', 
		'email', 
		'password',
		'remember_token',
		'status',
		'role',
		'deleted_at',
		'created_at',
		'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 
        'password', 
		'remember_token',
		'deleted_at',
		'role',
    ];
}
