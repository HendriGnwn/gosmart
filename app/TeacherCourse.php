<?php

namespace App;

class TeacherCourse extends BaseModel
{
	const DESTINATION_PATH = 'files/teacher-course/';
	
	protected $table = 'teacher_course';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
        'course_id', 
        'description', 
        'expected_cost', 
        'expected_cost_updated_at', 
		'additional_cost',
		'admin_fee',
		'final_cost',
        'approved_by', 
		'approved_at', 
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
		'approved_by', 
		'approved_at', 
		'status', 
		'created_at', 
		'updated_at', 
    ];
	
	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
		$this->setPath(public_path(self::DESTINATION_PATH));
		if(!is_dir($this->getPath())) {
			\File::makeDirectory($this->getPath());
		}
	}
	
	public function user() 
	{
		return $this->hasOne('\App\User', 'id', 'user_id')->actived();
	}
	
	public function course()
	{
		return $this->hasOne('\App\Course', 'id', 'course_id');
	}
}
