<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends BaseModel
{
	use SoftDeletes;
	
	const DESTINATION_PATH = 'files/banks/';
	
	protected $table = 'bank';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'payment_id',
        'name', 
        'image', 
        'description', 
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
		'deleted_at',
		'created_at',
		'updated_at'
    ];
	
	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		
		$this->setPath(public_path(self::DESTINATION_PATH));
		if (!is_dir($this->getPath())) {
			\File::makeDirectory($this->getPath(), '0775');
		}
	}
	
	public function deleteFile()
	{
		@unlink($this->getPath()  . $this->image);
	}
	
	public function payment()
	{
		return $this->hasOne('\App\Payment', 'id', 'payment_id');
	}
	
	public function getImageUrl()
	{
		return url(self::DESTINATION_PATH . $this->image);
	}
}
