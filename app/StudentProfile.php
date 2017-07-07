<?php

namespace App;

class StudentProfile extends BaseModel
{
	const DESTINATION_PATH = 'files/student-profile/';
	
	protected $table = 'student_profile';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
        'school', 
        'degree', 
        'department', 
        'school_address', 
        'photo', 
        'formal_photo', 
		'created_at', 
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
}
