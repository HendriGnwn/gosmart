<?php

namespace App;

class TeacherBank extends BaseModel
{
	protected $table = 'teacher_bank';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
        'name', 
        'number', 
        'branch', 
        'behalf_of', 
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
        'user_id', 
		'deleted_at', 
		'created_at', 
		'updated_at', 
    ];
	
	public function user() 
	{
		return $this->hasOne('\App\User', 'id', 'user_id');
	}
}
