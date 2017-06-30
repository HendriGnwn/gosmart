<?php

namespace App;

class OrderConfirmation extends BaseModel
{
	protected $table = 'order_confirmation';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'order_id', 
        'bank_id', 
        'bank_behalf_of', 
        'amount', 
        'upload_bukti', 
		'description', 
		'created_at', 
		'updated_at', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
		'user_id',
		'teacher_id',
    ];
	
	public function user() 
	{
		return $this->hasOne('\App\User', 'user_id', 'id');
	}
	
	public function order() 
	{
		return $this->hasOne('\App\Order', 'order_id', 'id');
	}
	
	public function bank() 
	{
		return $this->hasOne('\App\Bank', 'bank_id', 'id');
	}
}
