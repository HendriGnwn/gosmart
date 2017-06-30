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
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
	
	public function banks()
	{
		return $this->hasMany('\App\Bank', 'bank_id', 'id');
	}
}
