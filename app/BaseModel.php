<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BaseModel extends Model
{
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;
	
	private $_path;
	
	public function getPath() 
	{
		return $this->_path;
	}
	
	public function setPath($value)
	{
		$this->_path = $value;
	}
	
	/**
	 * @param type $query
	 * @return query
	 */
	public function scopeActived($query)
	{
		return $query->where($this->table . '.status', self::STATUS_ACTIVE);
	}
	
	/**
	 * @param type $query
	 * @return query
	 */
	public function scopeOrdered($query)
	{
		return $query->orderBy($this->table . '.order');
	}
	
	public static function statusLabels()
	{
		return [
			self::STATUS_ACTIVE => 'Active',
			self::STATUS_INACTIVE => 'Inactive',
		];
	}
	
	public function getStatusLabel()
	{
		$list = self::statusLabels();
		return isset($list[$this->status]) ? $list[$this->status] : '';
	}
}