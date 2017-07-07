<?php

namespace App;

class Payment extends BaseModel
{
	protected $table = 'payment';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'name',
		'status',
		'order',
		'created_at', 
		'updated_at'
    ];
	
	protected $with = [
		'banks'
	];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
		'status',
		'created_at',
		'updated_at'
    ];
	
	public function banks()
	{
		return $this->hasMany('\App\Bank', 'payment_id', 'id')->orderBy('name', 'asc');
	}
}
