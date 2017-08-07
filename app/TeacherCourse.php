<?php

namespace App;

use App\Helpers\FormatConverter;

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
		'module', 
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
		'created_at', 
		'updated_at', 
    ];
	
	protected $with = [
		'course',
		'course.courseLevel',
	];

	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
		$this->setPath(public_path(self::DESTINATION_PATH));
		if(!is_dir($this->getPath())) {
			\File::makeDirectory($this->getPath());
		}
	}
	
	public function deleteFile()
	{
		@unlink($this->getPath()  . $this->module);
	}
	
	public function user() 
	{
		return $this->hasOne('\App\User', 'id', 'user_id')->actived();
	}
	
	public function approvedBy() 
	{
		return $this->hasOne('\App\User', 'id', 'approved_by');
	}
	
	public function course()
	{
		return $this->hasOne('\App\Course', 'id', 'course_id');
	}
	
	public function getFormattedExpectedCost()
	{
		return FormatConverter::rupiahFormat($this->expected_cost, 2);
	}
	
	public function getFormattedAdditionalCost()
	{
		return FormatConverter::rupiahFormat($this->additional_cost, 2);
	}
	
	public function getFormattedAdminFee()
	{
		return FormatConverter::rupiahFormat($this->admin_fee, 2);
	}
	
	public function getFormattedFinalCost()
	{
		return FormatConverter::rupiahFormat($this->final_cost, 2);
	}
	
	public function getModuleUrl()
	{
		return url(self::DESTINATION_PATH . $this->module);
	}
	
	public function getModuleHtml($label = null)
	{
		$label = $label == null ? isset($this->course) ? $this->course->name : '' : $label;
		if ($this->module != '') {
			return "<a href='{$this->getModuleUrl()}' target='_blank'>{$label}</a>";
		}
		return '-';
	}
	
	public function getUserDetailHtml()
	{
		return isset($this->user) ? $this->user->getUserDetailHtml() : null;
	}
	
	public function getCourseName()
	{
		return isset($this->course) ? $this->course->name : null;
	}
}
