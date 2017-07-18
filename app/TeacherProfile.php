<?php

namespace App;

use App\Helpers\FormatConverter;

class TeacherProfile extends BaseModel
{
	const TITLE_D3 = 1;
	const TITLE_S1 = 2;
	const TITLE_S2 = 3;
	const TITLE_S3 = 4;
	
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
	
	protected $with = [
		'teacherBank'
	];


	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		
		$this->setPath(public_path(self::DESTINATION_PATH));
		if (!is_dir($this->getPath())) {
			\File::makeDirectory($this->getPath(), '0755');
		}
	}
	
	public function deleteFile()
	{
		if ($this->upload_ijazah != null) {
			@unlink($this->getPath() . $this->upload_ijazah);
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
	
	public function teacherBank()
	{
		return $this->hasOne('\App\TeacherBank', 'user_id', 'user_id');
	}
	
	public function teacherTotalHistories()
	{
		return $this->hasMany('\App\TeacherTotalHistory', 'user_id', 'user_id');
	}
	
	public function privateModels()
	{
		return $this->hasMany('\App\PrivateModel', 'user_id', 'id')->orderBy('private.created_at', 'desc');
	}
	
	public static function titleLabels()
	{
		return [
			self::TITLE_D3 => 'D3',
			self::TITLE_S1 => 'Sarjana',
			self::TITLE_S2 => 'Master',
			self::TITLE_S3 => 'Doctor',
		];
	}
	
	public function getTitleLabel()
	{
		$list = self::titleLabels();
		return isset($list[$this->title]) ? $list[$this->title] : '';
	}
	
	public function getUploadIzajahUrl()
	{
		return url(self::DESTINATION_PATH . $this->upload_izajah);
	}
	
	public function getUploadIzajahHtml()
	{
		if ($this->upload_izajah != '') {
			return "<a href='{$this->getUploadIzajahUrl()}' target='_blank'>{$this->getUploadIzajahUrl()}</a>";
		}
		return '-';
	}
	
	public function getFormattedTotal()
	{
		return FormatConverter::rupiahFormat($this->total, 2);
	}
}
