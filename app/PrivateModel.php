<?php

namespace App;

class PrivateModel extends BaseModel
{
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
		'created_at', 
		'updated_at', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
	
	public function order() 
	{
		return $this->hasOne('\App\Order', 'order_id', 'id');
	}
	
	public function course() 
	{
		return $this->hasOne('\App\Course', 'course_id', 'id');
	}
}
