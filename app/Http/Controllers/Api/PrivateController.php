<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FormatConverter;
use App\Helpers\ImageHelper;
use App\Order;
use App\OrderConfirmation;
use App\OrderDetail;
use App\Payment;
use App\TeacherCourse;
use App\User;
use Carbon\Carbon;
use Eventviva\ImageResize;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class PrivateController extends Controller 
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
			], 400);
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
			], 400);
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
		$model->payment_id = Payment::PAYMENT_TRANSFER_BANK;
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
		$model->updated_at = Carbon::now()->toDateTimeString();
		$model->save();
		
		$onAt = explode(',', $request->on_at);
		$startDate = $onAt[0] ? $onAt[0] : null;
		$endDate = end($onAt) ? end($onAt): null;
		$order->start_date = $startDate;
		$order->end_date = $endDate;
		$order->updated_at = Carbon::now()->toDateTimeString();
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
		if (!$order) {
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
		$order->updated_at = Carbon::now()->toDateTimeString();
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
	
	public function confirmation($uniqueNumber, $orderId, Request $request)
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
		
		$order = Order::whereStatus(Order::STATUS_CONFIRMED)
				->whereId($orderId)
				->orderBy('order.created_at', 'desc')
				->count();
		if ($order > 0) {
			return response()->json([
				'status' => 400,
				'message' => 'Status order is already confirmed',
			], 400);
		}
		
		$validators = \Validator::make($request->all(), [
			'bank_id' => 'required|exists:bank,id',
			'bank_number' => 'required',
			'bank_holder_name' => 'required',
			'amount' => 'required',
			'evidence' => 'required',
		]);
		
		if ($validators->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => FormatConverter::parseValidatorErrors($validators),
			], 400);
		}
		
		$model = new OrderConfirmation();
		
		if (!empty($request->evidence) || $request->evidence!= '') {
			$evidenceBase64 = $request->evidence;
			if (!ImageHelper::isImageBase64($evidenceBase64)) {
				return response()->json([
					'status' => 400,
					'message' => 'Evidence File must be image',
					'validators' => [
						'bank_id' => null,
						'bank_number' => null,
						'bank_holder_name' => null,
						'amount' => null,
						'evidence' => 'File must be image',
					],
				]);
			}
			$evidenceData = ImageHelper::getImageBase64Information($evidenceBase64);
			$img = ImageResize::createFromString(base64_decode($evidenceData['data']));
			
			$filename = str_slug($uniqueNumber . ' ' . $request->last_name . ' ' . time()) . '.' . $evidenceData['extension'];
			
			$img->save($model->getPath() . $filename);
			$request['upload_bukti'] = $filename;
		} else {
			if (!ImageHelper::isImageBase64($evidenceBase64)) {
				return response()->json([
					'status' => 400,
					'message' => 'Evidence File must be image',
					'validators' => [
						'bank_id' => null,
						'bank_number' => null,
						'bank_holder_name' => null,
						'amount' => null,
						'evidence' => 'evidence file field is required.',
					],
				]);
			}
		}
		
		$model->fill($request->only([
			'bank_id',
			'bank_number',
			'bank_name',
			'amount',
			'upload_bukti',
		]));
		$model->order_id = $orderId;
		$model->user_id = $user->id;
		$model->bank_behalf_of = $request->bank_holder_name;
		$model->description = !empty($request->description) ? $request->description : '';
		$model->created_at = $model->updated_at = Carbon::now()->toDateTimeString();
		$model->save();
		$model->order()->update([
			'status' => Order::STATUS_CONFIRMED,
			'confirmed_at' => Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon::now()->toDateTimeString(),
		]);
		
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
	
	public function histories($uniqueNumber, Request $request)
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
		
		$perPage = 50;
		
		$model = \App\PrivateModel::whereUserId($user->id)
				->orderBy('order.created_at', 'desc')
				->paginate($perPage);
		
		$model = $model->toArray();
		$model['status'] = 200;
		$model['message'] = 'Success';

		return response()->json($model, 200);
	}
}