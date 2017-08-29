<?php

namespace App;

use App\Helpers\FormatConverter;

class TeacherTotalHistory extends BaseModel
{
	const DESTINATION_PATH = 'files/teacher-total-histories/';
	
	protected $table = 'teacher_total_history';
	
	const STATUS_REJECTED = 0;
	const STATUS_WAITING_FOR_APPROVE = 5;
	const STATUS_APPROVED = 1;
	const STATUS_DONE = 10;
	
	const OPERATION_PLUS = 1;
	const OPERATION_MINUS = 0;

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
        'evidence', 
        'status', 
        'approved_by', 
        'approved_at', 
        'done_by', 
        'done_at', 
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
		'approved_by',
		'done_by',
    ];
	
	protected $with = [
		'privateModel'
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
		@unlink($this->getPath()  . $this->evidence);
	}
	
	public function user() 
	{
		return $this->hasOne('\App\User', 'id', 'user_id');
	}
	
	public function approvedBy() 
	{
		return $this->hasOne('\App\User', 'id', 'approved_by');
	}
	
	public function doneBy() 
	{
		return $this->hasOne('\App\User', 'id', 'done_by');
	}
	
	public function privateModel()
	{
		return $this->hasOne('\App\PrivateModel', 'id', 'private_id');
	}
	
	public function getFormattedTotal()
	{
		return FormatConverter::rupiahFormat($this->total, 2);
	}
	
	public function getOperationLabel()
	{
		return $this->operation == 0 ? '(-)' : '(+)';
	}
	
	public static function statusLabels()
	{
		return [
			self::STATUS_REJECTED => 'Rejected',
			self::STATUS_WAITING_FOR_APPROVE => 'Waiting for Approve',
			self::STATUS_APPROVED => 'Approved',
			self::STATUS_DONE => 'Done',
		];
	}
	
	public function getStatusLabel() 
	{
		$list = self::statusLabels();
		return isset($list[$this->status]) ? $list[$this->status] : '';
	}
	
	public function getActionListHistories()
	{
		if ($this->status == self::STATUS_WAITING_FOR_APPROVE) {
			return '<a href="'.url("admin/teacher/" . $this->id ."/total-history-reject").'" class="btn btn-xs btn-danger rounded" data-toggle="tooltip" title="Reject" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-minus"></i></a> '
				. '<a href="'.url("admin/teacher/" . $this->id ."/total-history-approve").'" class="btn btn-xs btn-success rounded" data-toggle="tooltip" title="Approve" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-check"></i></a> ';
		}
		
		if ($this->status == self::STATUS_APPROVED) {
			return '<a href="'.url("admin/teacher/" . $this->id ."/total-history-done").'" class="btn btn-xs btn-primary rounded" data-toggle="tooltip" title="Done" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-check-square"></i></a> ';
		}
	}
	
	public function sendNotificationTotalHistoryReject()
	{
		$notification = new Notification();
		$notification->user_id = $this->user_id;
		$notification->name = 'Request Honor di tolak';
		$notification->description = 'Permohonan pencairan uang honor sebesar Rp. ' . $this->getFormattedTotal() . ' telah ditolak.';
		$notification->category = Notification::CATEGORY_HONOR_CONFIRMATION;
		$notification->created_at = $notification->updated_at = \Carbon\Carbon::now()->toDateTimeString();
		$notification->save();
		$notification->sendPushNotification();
	}
	
	public function sendNotificationTotalHistoryApproved()
	{
		$notification = new Notification();
		$notification->user_id = $this->user_id;
		$notification->name = 'Request Honor di konfirmasi';
		$notification->description = 'Permohonan pencairan uang honor sebesar Rp. ' . $this->getFormattedTotal() . ' telah konfirmasi oleh admin, mohon tunggu sampai Status Done / Selesai karena pada status tersebut uang sudah di transfer ke Rekening Anda.';
		$notification->category = Notification::CATEGORY_HONOR_CONFIRMATION;
		$notification->created_at = $notification->updated_at = \Carbon\Carbon::now()->toDateTimeString();
		$notification->save();
		$notification->sendPushNotification();
	}
	
	public function sendNotificationTotalHistoryDone()
	{
		$notification = new Notification();
		$notification->user_id = $this->user_id;
		$notification->name = 'Request Honor telah Done';
		$notification->description = 'Permohonan pencairan uang honor sebesar Rp. ' . $this->getFormattedTotal() . ' telah selesai di proses, Uang sudah di transfer ke Rekening Anda.';
		$notification->category = Notification::CATEGORY_HONOR_CONFIRMATION;
		$notification->created_at = $notification->updated_at = \Carbon\Carbon::now()->toDateTimeString();
		$notification->save();
		$notification->sendPushNotification();
	}
	
	public function sendEmailReject()
	{
		return true;
	}
	
	public function sendEmailDone()
	{
		return true;
	}
	
	public function getEvidenceUrl()
	{
		return url(self::DESTINATION_PATH . $this->evidence);
	}
	
	public function getEvidenceHtml()
	{
		$label = $this->evidence;
		if ($this->evidence != null) {
			return "<a href='{$this->getEvidenceUrl()}' target='_blank'>{$label}</a>";
		}
		
		return '-';
	}
}
