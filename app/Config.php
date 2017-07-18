<?php

namespace App;

class Config extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'config';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
		'value', 
		'label', 
		'notes',
    ];
	
	/**
	 * @param type $name
	 * @return type
	 */
	public static function getValueByName($name)
	{
		$config = self::select('value')
				->whereName($name)->first();
		if (!$config) {
			return null;
		}
		
		return $config->value;
	}
	
	/**
     * return value array or object of setting by its name
     * 
     * @param type $name
     * @param type $isArray
     * @return type
     */
    public static function getValueJsonByName($name, $isArray = true)
    {
        $result = self::getValueByName($name);

        return json_decode($result, $isArray);
    }
	
	public static function getAdditionalCost()
	{
		return (double) self::getValueByName('additional_cost');
	}
	
	public static function getTeacherCourseAdminFee()
	{
		return (double) self::getValueByName('teacher_course_admin_fee');
	}
	
	public static function getTermConditionTeacher()
	{
		return (string) self::getValueByName('term_condition_teacher');
	}
}
