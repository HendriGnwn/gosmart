<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;

class User extends BaseModel implements
	AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Notifiable, SoftDeletes;
	
	const STATUS_BLOCKED = 5;
	
	const ROLE_SUPERADMIN = 1;
	const ROLE_TEACHER = 2;
	const ROLE_STUDENT = 3;
	
	protected $table = 'user';
	
	public $title;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'unique_number',
        'first_name', 
        'last_name', 
        'phone_number', 
        'latitude', 
        'longitude', 
        'address', 
		'email', 
		'password',
		'remember_token',
		'status',
		'role',
		'last_login_at',
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
        'id', 
        'password', 
		'remember_token',
		'deleted_at',
    ];
	
	protected $with = [
		'studentProfile', 
		'teacherProfile',
		'teacherProfile.teacherCourses',
		'teacherProfile.teacherCourses.course',
		'teacherProfile.teacherCourses.course.courseLevel',
		'teacherProfile.teacherTotalHistories',
	];
	
	/**
	 * @param type $role
	 * @param type $padLength
	 * @param type $separator
	 * @return type
	 */
	public static function generateUniqueNumber($role = null, $padLength = 4, $separator = '')
	{
		switch ($role) {
			case self::ROLE_TEACHER :
				$role = 'TEA';
				break;
			case self::ROLE_STUDENT :
				$role = 'STU';
				break;
			default :
				$role = 'USR';
		}
		
		$left = strtoupper($role) . $separator . date('Ym') . $separator;
        $leftLen = strlen($left);
        $increment = 1;

        $last = self::where('unique_number', 'LIKE', "%".$left."%")
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->first();

        if ($last) {
            $increment = (int) substr($last->unique_number, $leftLen, $padLength);
            $increment += 1;
        }

        $number = str_pad($increment, $padLength, '0', STR_PAD_LEFT);

        return $left . $number;
	}
	
	public function studentProfile() 
	{
		return $this->hasOne('\App\StudentProfile', 'user_id', 'id');
	}
	
	public function teacherProfile() 
	{
		return $this->hasOne('\App\TeacherProfile', 'user_id', 'id');
	}
	
	/**
	 * @param type $query
	 * @return type
	 */
	public function scopeRoleApps($query)
	{
		return $query->whereIn($this->table . '.role', [self::ROLE_TEACHER, self::ROLE_STUDENT]);
	}
	
	/**
	 * @param type $query
	 * @return type
	 */
	public function scopeRoleStudent($query)
	{
		return $query->where($this->table . '.role', '=', self::ROLE_STUDENT);
	}
	
	/**
	 * @param type $query
	 * @return type
	 */
	public function scopeRoleTeacher($query)
	{
		return $query->where($this->table . '.role', '=', self::ROLE_TEACHER);
	}
	
	public function scopeAppsActived($query)
	{
		return $query->whereIn($this->table . '.status', [self::STATUS_ACTIVE, self::STATUS_INACTIVE]);
	}
	
	public function getFullName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}
	
	public function insertStudent()
	{
		$this->role = self::ROLE_STUDENT;
		$this->status = self::STATUS_INACTIVE;
		$this->unique_number = self::generateUniqueNumber($this->role);
		
		$this->save();
		
		$student = new StudentProfile();
		$student->user_id = $this->id;
		$student->save();
		
		$this->sendWelcomeMessageToStudent();
		
		return true;
	}
	
	public function insertTeacher()
	{
		$this->role = self::ROLE_TEACHER;
		$this->status = self::STATUS_INACTIVE;
		$this->unique_number = self::generateUniqueNumber($this->role);
		
		$this->save();
		
		$teacher = new TeacherProfile();
		$teacher->user_id = $this->id;
		$teacher->title = $this->title;
		$teacher->save();
		
		$this->sendWelcomeMessageToTeacher();
		
		return true;
	}
	
	public function sendWelcomeMessageToStudent()
	{
		$user = $this;
//		Mail::send('emails.user.new-user-student', [
//			'user' => $user
//		], function ($message) use ($user)
//		{
//			$message->to($user->email, $user->getFullName())
//					->subject('Welcome to ' . config('app.name'));
//		});
		
		return true;
	}
	
	public function sendWelcomeMessageToTeacher()
	{
		$user = $this;
//		Mail::send('emails.user.new-user-teacher', [
//			'user' => $user
//		], function ($message) use ($user)
//		{
//			$message->to($user->email, $user->getFullName())
//					->subject('Welcome to ' . config('app.name'));
//		});
		
		return true;
	}
	
	public function sendEmailForgotPassword($password)
	{
		return true;
	}
}
