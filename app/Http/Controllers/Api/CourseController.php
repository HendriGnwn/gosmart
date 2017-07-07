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
	
	public function chooseCourse($uniqueNumber, Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		if ($user->unique_number != $uniqueNumber || $user->role != User::ROLE_TEACHER || $user->status != User::STATUS_ACTIVE) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		$validators = \Validator::make($request->all(), [
			'course_id' => 'required|exists:course,id',
			'description' => 'required',
			'expected_cost' => 'required|numeric',
		]);
		
		if ($validators->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => FormatConverter::parseValidatorErrors($validators),
			], 400);
		}
		
		$available = \App\TeacherCourse::whereCourseId($request['course_id'])->whereUserId($user->id)->count();
		if ($available > 0) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => [
					'course_id' => 'Course is already to use',
					'description' => null,
					'expected_cost' => null
				],
			], 400);
		}
		
		$request['user_id'] = $user->id;
		$request['expected_cost_updated_at'] = Carbon::now();
		$request['additional_cost'] = \App\Config::getAdditionalCost();
		$request['admin_fee'] = \App\Config::getTeacherCourseAdminFee();
		$request['final_cost'] = (int) $request['expected_cost'] + \App\Config::getAdditionalCost() + \App\Config::getTeacherCourseAdminFee();
		$request['status'] = \App\TeacherCourse::STATUS_INACTIVE;
		$teacherCourse = new \App\TeacherCourse();
		$teacherCourse->fill($request->all());
		$teacherCourse->save();
		
		$teacherCourse = \App\TeacherCourse::find($teacherCourse->id);
		
		return response()->json([
			'status' => 201,
			'message' => 'save success',
			'data' => $teacherCourse,
		], 200);
	}
	
	public function updateChooseCourse($id, Request $request)
	{
		
	}
}