<?php

namespace App;

use App\Helpers\FormatConverter;

class OrderConfirmation extends BaseModel
{
	const DESTINATION_PATH = 'files/order-confirmation/';
	
	protected $table = 'order_confirmation';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'order_id', 
        'bank_id', 
        'bank_number', 
        'bank_behalf_of', 
        'amount', 
        'upload_bukti', 
		'description', 
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
		'teacher_id',
    ];
	
	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		
		$this->setPath(public_path(self::DESTINATION_PATH));
		if (!is_dir($this->getPath())) {
			\File::makeDirectory($this->getPath(), '0775');
		}
	}
	
	public function user() 
	{
		return $this->hasOne('\App\User', 'id', 'user_id');
	}
	
	public function order() 
	{
		return $this->hasOne('\App\Order', 'id', 'order_id');
	}
	
	public function bank() 
	{
		return $this->hasOne('\App\Bank', 'id', 'bank_id');
	}
	
	public function getFormattedAmount()
	{
		return FormatConverter::rupiahFormat($this->amount, 2);
	}
	
	public function getUploadBuktiUrl()
	{
		return url(self::DESTINATION_PATH . $this->upload_bukti);
	}
	
	public function getUploadBuktiHtml()
	{
		return "<a href='".url(self::DESTINATION_PATH . $this->upload_bukti)."' target='_blank'>".$this->upload_bukti."</a>";
	}
}
