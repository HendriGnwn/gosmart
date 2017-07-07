<?php

namespace App;

class TeacherProfile extends BaseModel
{
	const DESTINATION_PATH = 'files/teacher-profile/';
	
	protected $table = 'teacher_profile';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
        'title', 
        'ijazah_number', 
        'graduated', 
        'photo', 
        'upload_ijazah', 
        'formal_photo', 
		'total', 
		'total_updated_at', 
		'updated_at', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
		'id',
        'user_id', 
    ];
	
	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		
		$this->setPath(public_path(self::DESTINATION_PATH));
		if (!is_dir($this->getPath())) {
			\File::makeDirectory($this->getPath(), '0755');
		}
	}
	
	public function user() 
	{
		return $this->hasOne('\App\User', 'id', 'user_id');
	}
	
	public function getPhotoUrl()
	{
		return url(self::DESTINATION_PATH . $this->photo);
	}
	
	public function teacherCourses()
	{
		return $this->hasMany('\App\TeacherCourse', 'user_id', 'user_id');
	}
	
	public function teacherTotalHistories()
	{
		return $this->hasMany('\App\TeacherTotalHistory', 'user_id', 'user_id');
	}
}
