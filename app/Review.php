<?php

namespace App;

class Review extends BaseModel
{
	protected $table = 'review';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
        'teacher_id', 
        'private_id', 
        'rate', 
        'description', 
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
		'updated_at',
		'user_id',
		'teacher_id',
    ];
	
	public function privateModel()
	{
		return $this->hasOne('\App\PrivateModel', 'id', 'private_id');
	}
	
	public function user()
	{
		return $this->hasOne('\App\User', 'id', 'user_id');
	}
	
	public function teacher()
	{
		return $this->hasOne('\App\User', 'id', 'user_id');
	}
}
