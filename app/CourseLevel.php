<?php

namespace App;

class CourseLevel extends BaseModel
{
	protected $table = 'course_level';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'status', 
        'order', 
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
		'updated_at',
		'order',
		'status'
    ];
	
	protected $with = [
		'courses'
	];

	public function courses() 
	{
		return $this->hasMany('\App\Course', 'course_level_id', 'id')->actived()->orderBy('name', 'asc');
	}
}
