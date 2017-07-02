<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FormatConverter;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CourseController extends Controller 
{
	/**
	 * @param type $uniqueNumber
	 * @param Request $request
	 * @return type
	 */
	public function getCourseLevelWithRelations(Request $request)
	{
		$courseLevels = \App\CourseLevel::select('course_level.*')
				->with([
				'courses',
				'courses.teacherCourses',
				'courses.teacherCourses.user',
				'courses.teacherCourses.user.studentProfile',
				'courses.teacherCourses.user.teacherProfile',
			])
			->join('course', 'course_level.id', '=', 'course.course_level_id')
			->join('teacher_course', 'teacher_course.course_id', '=', 'course.id')
			->actived()
			->ordered()
			->get();
		if (!$courseLevels) {
			return response()->json([
				'status' => 404,
				'message' => 'Data is not found',
			], 404);
		}
		
		return response()->json([
			'status' => 200,
			'message' => 'Success',
			'data' => $courseLevels,
		], 200);
	}
	
	public function listCourseLevels()
	{
		$courseLevels = \App\CourseLevel::with(['courses'])
				->actived()
				->ordered()
				->get();
		
		return response()->json([
			'status' => 200,
			'message' => 'success',
			'data' => $courseLevels,
		], 200);
	}
}