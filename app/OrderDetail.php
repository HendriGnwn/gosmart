<?php

namespace App;

use App\Helpers\FormatConverter;

class OrderDetail extends BaseModel
{
	protected $table = 'order_detail';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 
        'teacher_course_id', 
        'on_at', 
        'section', 
        'section_time', 
		'amount', 
		'created_at', 
		'updated_at', 
    ];
	
	protected $with = [
		'teacherCourse',
	];
	
	protected $appends = [
		'on_details'
	];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
	
	public function getOnDetailsAttribute()
	{
		return explode(',', $this->on_at);
	}
	
	public function order() 
	{
		return $this->hasOne('\App\Order', 'id', 'order_id');
	}
	
	public function teacherCourse() 
	{
		return $this->hasOne('\App\TeacherCourse', 'id', 'teacher_course_id');
	}
	
	public function getOnAt($replace = '<br/>')
	{
		return str_replace(',', $replace, $this->on_at);
	}
	
	public function getFormattedAmount()
	{
		return FormatConverter::rupiahFormat($this->amount, 2);
	}
}
