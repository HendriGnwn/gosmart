<?php

namespace App\Http\Controllers\Api;

use App\Config;
use App\Helpers\FormatConverter;
use App\PrivateModel;
use App\Review;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

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
	
	public function storeReview($uniqueNumber, Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		if ($user->unique_number != $uniqueNumber && $user->role != User::ROLE_TEACHER) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		$model = User::whereId($user->id)->roleStudent()->actived()->first();
		if (!$model) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		$validators = \Validator::make($request->all(), [
			'private_id' => 'required|exists:private,id',
			'rate' => 'required|numeric',
			'description' => 'required',
		]);
		
		if ($validators->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => FormatConverter::parseValidatorErrors($validators)
			], 400);
		}
		
		$privateModel = PrivateModel::whereId($request->private_id)->statusDone()->first();
		if (!$privateModel) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => [
					'private_id' => 'Private status must be done',
					'rate' => null,
					'description' => null
				]
			], 400);
		}
		
		$review = new Review();
		$review->fill($request->only([
			'private_id',
			'rate',
			'description'
		]));
		$review->user_id = $model->id;
		$review->teacher_id = $privateModel->teacher_id;
		$review->status = Review::STATUS_ACTIVE;
		$review->created_at =$review->updated_at = Carbon::now()->toDateTimeString();
		$review->save();
		
		return response()->json([
			'status' => 200,
			'message' => 'Success',
		], 200);
	}
	
	public function notification($uniqueNumber, Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		if ($user->unique_number != $uniqueNumber) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		$model = \App\Notification::whereUserId($user->id)->orderBy('created_at', 'desc')->paginate(50);
		if (!$model) {
			return response()->json([
				'status' => 404,
				'message' => 'Notification is not found',
			], 404);
		}
		
		$model = $model->toArray();
		$model['status'] = 200;
		$model['message'] = 'Success';

		return response()->json($model, 200);
	}
	
	public function getNotification($id, Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		if (!$user) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		$model = \App\Notification::whereId($id)->first();
		if (!$model) {
			return response()->json([
				'status' => 404,
				'message' => 'Notification is not found',
			], 404);
		}
		$model->read_at = Carbon::now()->toDateTimeString();
		$model->save();

		return response()->json([
			'status' => 200,
			'message' => 'success',
			'data' => $model
		], 200);
	}
	
	public function sendFeedback(Request $request)
	{
		$validators = \Validator::make($request->all(), [
			'first_name' => 'required',
			'email' => 'required|email',
			'phone' => 'required|numeric',
			'message' => 'required',
		]);
		
		if ($validators->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => FormatConverter::parseValidatorErrors($validators)
			], 400);
		}
		$models = [
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'email' => $request->email,
			'phone' => $request->phone,
			'message' => $request->message,
			'created_at' => Carbon::now()->toDateTimeString(),
		];
		\Mail::send('emails.api.send-feedback', [
			'model' => $models,
		], function ($message) use($models) {
			$message->to([
				'hendri.gnw@gmail.com'
			], 'Hendri Gunawan')
					->subject('Go Smart Send Feedback - ' . $models['first_name']);
		});
		
		return response()->json([
			'status' => 201,
			'message' => 'Terimakasih atas kritik dan sarannya.'
		], 201);
	}
}