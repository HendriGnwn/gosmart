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
	 * @param Request $request
	 * @return type
	 */
	public function index(Request $request)
	{
		$search = $request->get('search');
		$sort = $request->get('sort');
		$perPage = 50;

		$model = \App\Course::with(['courseLevel'])
			->select(['course.*'])
			->leftJoin('course_level', 'course_level.id', '=', 'course.course_level_id')
			->actived();
		if (!empty($search)) {
			$model = $model->where('course.name', 'LIKE', "%$search%")
					->orWhere('course_level.name', 'LIKE', "%$search%");
		}
		$model = $model->orderBy('course.name', 'asc')->paginate($perPage);
		$model = $model->toArray();
		$model['status'] = 200;
		$model['message'] = 'Success';

		return response()->json($model, 200);
	}
	
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
				'message' => 'Course is already to use',
				'validators' => [
					'course_id' => 'Course is already to use',
					'description' => null,
					'expected_cost' => null
				],
			], 400);
		}
		
		$request['user_id'] = $user->id;
		$request['expected_cost_updated_at'] = Carbon::now()->toDateTimeString();
		$request['additional_cost'] = \App\Config::getAdditionalCost();
		$request['admin_fee'] = \App\Config::getTeacherCourseAdminFee();
		$request['final_cost'] = (int) $request['expected_cost'] + \App\Config::getAdditionalCost() + \App\Config::getTeacherCourseAdminFee();
		$request['status'] = \App\TeacherCourse::STATUS_INACTIVE;
		$teacherCourse = new \App\TeacherCourse();
		$teacherCourse->fill($request->all());
		$teacherCourse->created_at = $teacherCourse->updated_at = Carbon::now()->toDateTimeString();
		$teacherCourse->save();
		
		$user = User::whereUniqueNumber($uniqueNumber)
			->roleApps()
			->appsActived()
			->first();
		if (!$user) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		return response()->json([
			'status' => 201,
			'message' => 'Success',
			'data' => $user,
		], 201);
	}
	
	public function updateChooseCourse($uniqueNumber, $id, Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		if ($user->unique_number != $uniqueNumber || $user->role != User::ROLE_TEACHER || $user->status != User::STATUS_ACTIVE) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		$model = \App\TeacherCourse::whereId($id)->first();
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
		
		$available = \App\TeacherCourse::where('course_id', '!=', $model->course_id)->whereCourseId($request['course_id'])->whereUserId($user->id)->count();
		if ($available > 0) {
			return response()->json([
				'status' => 400,
				'message' => 'Course is already to use',
				'validators' => [
					'course_id' => 'Course is already to use',
					'description' => null,
					'expected_cost' => null
				],
			], 400);
		}
		
		$request['user_id'] = $user->id;
		$request['expected_cost_updated_at'] = Carbon::now()->toDateTimeString();
		$request['additional_cost'] = \App\Config::getAdditionalCost();
		$request['admin_fee'] = \App\Config::getTeacherCourseAdminFee();
		$request['final_cost'] = (int) $request['expected_cost'] + \App\Config::getAdditionalCost() + \App\Config::getTeacherCourseAdminFee();
		$request['status'] = \App\TeacherCourse::STATUS_INACTIVE;
		$model->fill($request->all());
		$model->updated_at = Carbon::now()->toDateTimeString();
		$model->save();
		
		$user = User::whereUniqueNumber($uniqueNumber)
			->roleApps()
			->appsActived()
			->first();
		if (!$user) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		return response()->json([
			'status' => 200,
			'message' => 'Success',
			'data' => $user,
		], 200);
	}
	
	public function deleteChooseCourse($uniqueNumber, $id, Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		if ($user->unique_number != $uniqueNumber || $user->role != User::ROLE_TEACHER || $user->status != User::STATUS_ACTIVE) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		$model = \App\TeacherCourse::whereId($id)->first();
		$model->deleteFile();
		$model->delete();
		
		$user = User::whereUniqueNumber($uniqueNumber)
			->roleApps()
			->appsActived()
			->first();
		if (!$user) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		return response()->json([
			'status' => 200,
			'message' => 'Success',
			'data' => $user,
		], 200);
	}
	
	public function listAvailability(Request $request)
	{
		$search = $request->get('search');
		$sort = $request->get('sort');
		$latitude = $request->get('latitude');
		$longitude = $request->get('longitude');
		$radius = $request->get('radius');
		$courseId = $request->get('course_id');
		$R = 6371;
		$perPage = 16;
		
		$models = \App\TeacherCourse::select([
				'teacher_course.*',
			])->with([
				'course',
				'user',
			])
			->join('user', 'user.id', '=', 'teacher_course.user_id')
			->join('course', 'course.id', '=', 'teacher_course.course_id')
				->actived();
		if (!empty($courseId)) {
			$models = $models->where('course.id', '=', $courseId);
		}
		
        if (!empty($search)) {
            $models = $models->where('course.name', 'LIKE', "%$search%")
					->orWhere('user.first_name', 'LIKE', "%$search%")
					->orWhere('user.last_name', 'LIKE', "%$search%");
        }
		if (!empty($latitude) && !empty($longitude) && !empty($radius)) {
			$maxLatitude = $latitude + rad2deg($radius/$R);
			$minLatitude = $latitude - rad2deg($radius/$R);
			$maxLongitude = $longitude + rad2deg(asin($radius/$R) / cos(deg2rad($latitude)));
			$minLongitude = $longitude - rad2deg(asin($radius/$R) / cos(deg2rad($latitude)));
			
			$models = $models->whereBetween('user.latitude', [$minLatitude, $maxLatitude])
				->whereBetween('user.longitude', [$minLongitude, $maxLongitude]);
		}
		
		$models = $models->paginate($perPage);
		
		$models = $models->toArray();
		$models['status'] = 200;
		
		return response()->json($models, 200);
	}
	
	public function getSimiliarTeacherCourses($id) 
	{
		$perPage = 16;
		$teacherCourse = \App\TeacherCourse::whereId($id)->first();
		
		$models = \App\TeacherCourse::select([
				'teacher_course.*',
			])->with([
				'course',
				'user',
			])
			->join('user', 'user.id', '=', 'teacher_course.user_id')
			->join('course', 'course.id', '=', 'teacher_course.course_id')
			->actived()
			->where('user.id', '=', $teacherCourse->user_id)
			->where('teacher_course.id', '!=', $id)
			->paginate($perPage);
		
		$models = $models->toArray();
		$models['status'] = 200;
		
		return response()->json($models, 200);
	}
}