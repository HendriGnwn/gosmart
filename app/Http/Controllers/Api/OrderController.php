<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FormatConverter;
use App\Order;
use App\OrderDetail;
use App\TeacherCourse;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderController extends Controller 
{
	/**
	 * login credentials
	 * 
	 * @param Request $request
	 * @return json
	 */
	public function create($uniqueNumber, Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		if ($user->unique_number != $uniqueNumber) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
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
		
		$validators = \Validator::make($request->all(), [
			'teacher_unique_number' => 'required|exists:user,unique_number',
			'teacher_course_id' => 'required|exists:course,id',
			'on_at' => 'required',
		]);
		
		if ($validators->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => FormatConverter::parseValidatorErrors($validators),
			], 400);
		}
		
		$countOrderExist = Order::whereUserId($user->id)
				->statusDisplayAppsOrder()
				->count();
		if($countOrderExist > 0) {
			return response()->json([
				'status' => 400,
				'message' => 'You already have order data, please to delete old order to make new order',
				'validators' => [
					'teacher_unique_number' => null,
					'teacher_course_id' => null,
					'on_at' => null,
				],
			]);
		}
		
		$teacher = User::whereUniqueNumber($request->teacher_unique_number)->appsActived()->first();
		$teacherCourse = TeacherCourse::whereId($request->teacher_course_id)
				->whereUserId($teacher->id)
				->actived()
				->first();
		
		$countCourseExist = TeacherCourse::whereUserId($teacher->id)
				->whereId($request->teacher_course_id)
				->count();
		if($countCourseExist == 0) {
			return response()->json([
				'status' => 400,
				'message' => 'Request is not available',
				'validators' => [
					'teacher_unique_number' => null,
					'teacher_course_id' => null,
					'on_at' => null,
				],
			]);
		}
		
		$onAt = explode(',', $request->on_at);
		$startDate = $onAt[0] ? $onAt[0] : null;
		$endDate = end($onAt) ? end($onAt): null;
		
		$model = new Order();
		$model->code = Order::generateCode();
		$model->teacher_id = $teacher->id;
		$model->user_id = $user->id;
		$model->section = $teacherCourse->course->section;
		$model->section_time = $teacherCourse->course->section_time;
		$model->start_date = $startDate;
		$model->end_date = $endDate;
		$model->payment_id = null;
		$model->admin_fee = $model->getAdminFeeValue();
		$model->final_amount = $teacherCourse->final_cost;
		$model->status = Order::STATUS_DRAFT;
		$model->created_at = $model->updated_at = Carbon::now()->toDateTimeString();
		$model->save();
		
		$detail = new OrderDetail();
		$detail->order_id = $model->id;
		$detail->teacher_course_id = $request->teacher_course_id;
		$detail->on_at = $request->on_at;
		$detail->section = $teacherCourse->course->section;
		$detail->section_time = $teacherCourse->course->section_time;
		$detail->amount = $teacherCourse->final_cost;
		$detail->created_at = $detail->updated_at = Carbon::now()->toDateTimeString();
		$detail->save();

		$result = Order::statusDisplayAppsOrder()
				->orderBy('order.created_at', 'desc')
				->first();
		
		return response()->json([
			'status' => 201,
			'message' => 'Order Success',
			'data' => $result,
		], 201);
	}
	
	public function show($uniqueNumber, Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		if ($user->unique_number != $uniqueNumber) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
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
		
		$result = Order::statusDisplayAppsOrder()
				->orderBy('order.created_at', 'desc')
				->first();
		
		if (!$result) {
			return response()->json([
				'status' => 404,
				'message' => 'Order is not found',
			], 404);
		}
		
		return response()->json([
			'status' => 200,
			'message' => 'Success',
			'data' => $result,
		], 201);
	}
	
	public function updateOnAt($uniqueNumber, $orderId, Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		if ($user->unique_number != $uniqueNumber) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
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
		
		$order = Order::statusDisplayAppsOrder()
				->whereId($orderId)
				->whereUserId($user->id)
				->first();
		iF (!$order) {
			return response()->json([
				'status' => 404,
				'message' => 'Order is not found',
			], 404);
		}
		
		$validators = \Validator::make($request->all(), [
			'teacher_course_id' => 'required|exists:course,id',
			'on_at' => 'required',
		]);
		
		if ($validators->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => FormatConverter::parseValidatorErrors($validators),
			], 400);
		}
		
		$model = OrderDetail::whereOrderId($orderId)
				->whereTeacherCourseId($request->teacher_course_id)
				->first();
		$model->on_at = $request->on_at;
		$model->save();
		
		$onAt = explode(',', $request->on_at);
		$startDate = $onAt[0] ? $onAt[0] : null;
		$endDate = end($onAt) ? end($onAt): null;
		$order->start_date = $startDate;
		$order->end_date = $endDate;
		$order->save();
		
		$result = Order::statusDisplayAppsOrder()
				->whereId($orderId)
				->orderBy('order.created_at', 'desc')
				->first();
		
		return response()->json([
			'status' => 200,
			'message' => 'Success',
			'data' => $result,
		], 201);
	}
	
	public function deleteOrder($uniqueNumber, $orderId, Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		if ($user->unique_number != $uniqueNumber) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
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
		
		$order = Order::statusDisplayAppsOrder()
				->whereId($orderId)
				->whereUserId($user->id)
				->first();
		iF (!$order) {
			return response()->json([
				'status' => 404,
				'message' => 'Order is not found',
			], 404);
		}
		$order->delete();
		OrderDetail::whereOrderId($orderId)->delete();
		
		return response()->json([
			'status' => 200,
			'message' => 'Success',
		]);
	}
	
	public function checkout($uniqueNumber, $orderId, Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		if ($user->unique_number != $uniqueNumber) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
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
		
		$order = Order::statusDisplayAppsOrder()
				->whereId($orderId)
				->whereUserId($user->id)
				->first();
		iF (!$order) {
			return response()->json([
				'status' => 404,
				'message' => 'Order is not found',
			], 404);
		}
		$order->status = Order::STATUS_WAITING_PAYMENT;
		$order->save();
		
		$result = Order::statusDisplayAppsOrder()
				->whereId($orderId)
				->orderBy('order.created_at', 'desc')
				->first();
		
		return response()->json([
			'status' => 200,
			'message' => 'Success',
			'data' => $result,
		], 201);
	}
}