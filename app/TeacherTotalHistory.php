<?php

namespace App;

use App\Helpers\FormatConverter;

class TeacherTotalHistory extends BaseModel
{
	protected $table = 'teacher_total_history';
	
	const OPERATION_PLUS = '+';
	const OPERATION_MINUS = '-';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
        'private_id', 
        'operation', 
        'total', 
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
    ];
	
	public function user() 
	{
		return $this->hasOne('\App\User', 'id', 'user_id');
	}
	
	public function privateModel()
	{
		return $this->hasOne('\App\PrivateModel', 'id', 'private_id');
	}
	
	public function getFormattedTotal()
	{
		return FormatConverter::rupiahFormat($this->total, 2);
	}
}
