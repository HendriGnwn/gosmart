<?php

namespace App;

class Course extends BaseModel
{
	protected $table = 'course';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'course_level_id',
        'name', 
        'description', 
        'section', 
        'section_time', 
		'status', 
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
		'status'
    ];
	
	public function courseLevel()
	{
		return $this->hasOne('\App\CourseLevel', 'id', 'course_level_id');
	}
	
	public function teacherCourses()
	{
		return $this->hasMany('\App\TeacherCourse', 'course_id', 'id')->actived();
	}
}
