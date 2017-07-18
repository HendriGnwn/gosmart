<?php

namespace App\Http\Controllers\Api;

use App\Config;

class RequestController extends Controller 
{
	public function teacherTermCondition()
	{
		$termCondition = Config::getTermConditionTeacher();
		
		return response()->json([
			'status' => 200,
			'message' => 'success',
			'data' => [
				'description' => $termCondition,
			],
		], 200);
	}
}