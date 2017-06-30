<?php

namespace App;

class Order extends BaseModel
{
	const STATUS_CANCELED = 0;
	const STATUS_WAITING_PAYMENT = 1;
	const STATUS_CONFIRMED = 5;
	const STATUS_PAID = 10;
	
	protected $table = 'order';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'teacher_id', 
        'code', 
        'section', 
        'section_time', 
        'admin_fee', 
		'final_amount', 
		'payment_id', 
		'status', 
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
	
	public function student() 
	{
		return $this->hasOne('\App\User', 'user_id', 'id');
	}
	
	public function teacher() 
	{
		return $this->hasOne('\App\User', 'teacher_id', 'id');
	}
	
	public function payment()
	{
		return $this->hasOne('\App\Payment', 'payment_id', 'id');
	}
	
	public function orderDetails()
	{
		return $this->hasMany('\App\OrderDetail', 'id', 'order_id')->orderBy('on_at', 'ASC');
	}
	
	public function orderConfirmation()
	{
		return $this->hasOne('\App\OrderConfirmation', 'order_id', 'id');
	}
}
