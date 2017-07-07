<?php

namespace App;

class PrivateModel extends BaseModel
{
	const STATUS_ON_GOING = 5;
	const STATUS_DONE = 10;
	
	protected $table = 'private';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'teacher_id', 
        'order_id', 
        'section', 
        'section_time', 
		'code', 
		'start_date', 
		'end_date', 
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
	
	public function order() 
	{
		return $this->hasOne('\App\Order', 'order_id', 'id');
	}
	
	public function user()
	{
		return $this->hasOne('\App\User', 'user_id', 'id');
	}
	
	public function teacher()
	{
		return $this->hasOne('\App\User', 'teacher_id', 'id');
	}
	
	public function privateDetails()
	{
		return $this->hasMany('\App\PrivateDetail', 'id', 'private_id');
	}
}
