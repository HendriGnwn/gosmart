<?php

namespace App;

class PrivateDetail extends BaseModel
{
	protected $table = 'private_detail';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'private_id', 
        'course_id', 
        'on_at', 
        'section', 
        'section_time', 
		'student_details',
		'teacher_details',
		'checklist', 
		'checklist_at', 
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
	
	public function course() 
	{
		return $this->hasOne('\App\Course', 'course_id', 'id');
	}
	
	public function privateModel()
	{
		return $this->hasOne('\App\PrivateModel', 'private_id', 'id');
	}
}
