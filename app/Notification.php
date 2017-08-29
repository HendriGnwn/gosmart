<?php

namespace App;

class Notification extends BaseModel
{
	const CATEGORY_GENERAL = 1;
	const CATEGORY_ORDER_CONFIRMATION = 5;
	const CATEGORY_PRIVATE_CONFIRMATION = 10;
	const CATEGORY_HONOR_CONFIRMATION = 15;
	const CATEGORY_TEACHER_COURSE_CONFIRMATION = 20;
	const CATEGORY_REMINDER = 25;
	const CATEGORY_USER_CONFIRMATION = 30;
	
	
	protected $table = 'notification';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
        'name', 
        'description', 
        'category', 
        'read_at', 
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
    ];
	
	protected $appends = [
		'category_message'
	];
	
	public function user()
	{
		return $this->hasOne('\App\User', 'id', 'user_id');
	}
	
	public function getCategoryMessageAttribute()
	{
		$list = self::categoryLabels();
		return isset($list[$this->category]) ? $list[$this->category] : '';
	}
	
	public static function categoryLabels()
	{
		return [
			self::CATEGORY_GENERAL => 'Umum',
			self::CATEGORY_ORDER_CONFIRMATION => 'Order',
			self::CATEGORY_PRIVATE_CONFIRMATION => 'Les',
			self::CATEGORY_HONOR_CONFIRMATION => 'Honor',
			self::CATEGORY_TEACHER_COURSE_CONFIRMATION => 'Pelajaran',
			self::CATEGORY_REMINDER => 'Pengingat',
		];
	}
	
	public function sendPushNotification() 
	{
		$firebase = new \App\Helpers\Firebase();
		$notifications = [
			'title' => $this->name,
			'body' => strip_tags(substr($this->description, 0, 80)),
			'sound' => 'default',
			'badge' => 0,
			'click_action' => 'com.atc.gosmartlesmagistra.firebase.message.NEW_NOTIFICATION',
		];
	
		$firebase->sendNewMessage($this->user->firebase_token, $this, $notifications);
		
		return true;
	}
}
