<?php

namespace App;

class Bank extends BaseModel
{
	protected $table = 'bank';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'payment_id',
        'name', 
        'image', 
        'description', 
        'branch', 
        'behalf_of', 
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
		'deleted_at',
		'created_at',
		'updated_at'
    ];
	
	public function payment()
	{
		return $this->hasOne('\App\Payment', 'id', 'payment_id');
	}
}
