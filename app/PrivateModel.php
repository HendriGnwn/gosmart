<?php

namespace App;

class PrivateModel extends BaseModel
{
	const STATUS_NOT_YET_GOING = 1;
	const STATUS_ON_GOING = 5;
	const STATUS_DONE = 10;
	
	protected $table = 'private';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'teacher_id', 
        'order_id', 
        'section', 
        'section_time', 
		'code', 
		'start_date', 
		'end_date', 
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
		'teacher_id',
    ];
	
	public function order() 
	{
		return $this->hasOne('\App\Order', 'id', 'order_id');
	}
	
	public function student()
	{
		return $this->hasOne('\App\User', 'id', 'user_id');
	}
	
	public function teacher()
	{
		return $this->hasOne('\App\User', 'id', 'teacher_id');
	}
	
	public function privateDetails()
	{
		return $this->hasMany('\App\PrivateDetail', 'private_id', 'id');
	}
	
    public static function generateCode($prefix = 'PRI', $padLength = 4, $separator = '-') 
    {
        $left = strtoupper($prefix) . $separator . date('Ym') . $separator;
        $leftLen = strlen($left);
        $increment = 1;

        $last = self::where('code', 'LIKE', "'%$left%'")
                ->orderBy('id', 'desc')
                ->limit(1)
                ->first();

        if ($last) {
            $increment = (int) substr($last->code, $leftLen, $padLength);
            $increment++;
        }

        $number = str_pad($increment, $padLength, '0', STR_PAD_LEFT);

        return $left . $number;
    }
	
	public static function statusLabels()
	{
		return [
			self::STATUS_NOT_YET_GOING => 'Not yet Going',
			self::STATUS_ON_GOING => 'On Going',
			self::STATUS_DONE => 'Done',
		];
	}
	
	public function scopeStatusDone($query)
	{
		return $this->where($this->table . '.status', '=', self::STATUS_DONE);
	}
	
	public function getStatusLabel()
	{
		$list = self::statusLabels();
		return isset($list[$this->status]) ? $list[$this->status] : '';
	}
	
	public function getDetailUrl()
	{
		return url('/admin/private/' . $this->order_id);
	}
	
	public function getDetailHtml($label = null)
	{
		$label = $label == null ? $this->getDetailUrl() : $label;
		return "<a href='{$this->getDetailUrl()}' target='_blank'>{$label}</a>";
	}
}
