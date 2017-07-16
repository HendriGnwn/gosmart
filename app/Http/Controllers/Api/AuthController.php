<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FormatConverter;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller 
{
	/**
	 * login credentials
	 * 
	 * @param Request $request
	 * @return json
	 */
	public function login(Request $request)
	{
		$credentials = $request->only(['email', 'password']);

		$validators = \Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required|min:6',
			'firebase_token' => 'required',
		]);
		
		if ($validators->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => FormatConverter::parseValidatorErrors($validators),
			], 400);
		}
		
		try {
			if (!$token = JWTAuth::attempt($credentials)) {
				return response()->json([
					'status' => 401,
					'message' => 'Invalid Credentials',
				], 401);
			}
		} catch (Exception $ex) {
			return response()->json([
				'status' => 400,
				'message' => 'Could Not Create Token'
			], 400);
		}
		
		$user = User::whereEmail($request->email)
			->roleApps()
			->appsActived()
			->first();
		if (!$user) {
			return response()->json([
				'status' => 401,
				'message' => 'Invalid Credentials'
			], 401);
		}
		
		$token = JWTAuth::fromUser($user);
		$user->last_login_at = Carbon::now()->toDateTimeString();
		$user->firebase_token = $request['firebase_token'];
		$user->save();
		$user['token'] = $token;
		
		return response()->json([
			'status' => 200,
			'message' => 'Login Success',
			'data' => $user,
		], 200);
	}
	
	public function registerStudent(Request $request)
	{
		$validators = \Validator::make($request->all(), [
			'first_name' => 'required|max:50',
			//'last_name' => 'required',
			'phone_number' => 'required|numeric|min:10',
			'address' => 'required|max:255',
			'email' => 'required|email|max:100|unique:user,email',
			'password' => 'required|min:6|max:255',
		]);
		
		if ($validators->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => FormatConverter::parseValidatorErrors($validators),
			], 400);
		}
		
		$user = new User();
		$user->fill($request->all());
		$user->created_at = $user->updated_at = Carbon::now()->toDateTimeString();
		$user->password = bcrypt($request->password);
		$user->insertStudent();
		
		$user = User::whereId($user->id)
			->roleApps()
			->appsActived()
			->first();
		if (!$user) {
			return response()->json([
				'status' => 401,
				'message' => 'Invalid Credentials'
			], 401);
		}
		
		$token = JWTAuth::fromUser($user);
		$user->last_login_at = Carbon::now()->toDateTimeString();
		$user->save();
		$user['token'] = $token;
		
		return response()->json([
			'status' => 200,
			'message' => 'Registration Success',
			'data' => $user,
		], 200);
	}
	
	public function registerTeacher(Request $request)
	{
		$validators = \Validator::make($request->all(), [
			'title' => 'required|numeric',
			'first_name' => 'required|max:50',
			//'last_name' => 'required',
			'phone_number' => 'required|numeric|min:10',
			'address' => 'required|max:255',
			'email' => 'required|email|max:100|unique:user,email',
			'password' => 'required|min:6|max:255',
		]);
		
		if ($validators->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => FormatConverter::parseValidatorErrors($validators),
			], 400);
		}
		
		$user = new User();
		$user->fill($request->all());
		$user->created_at = $user->updated_at = Carbon::now()->toDateTimeString();
		$user->password = bcrypt($request->password);
		$user->title = $request->title;
		$user->insertTeacher();
		
		$user = User::whereId($user->id)
			->roleApps()
			->appsActived()
			->first();
		if (!$user) {
			return response()->json([
				'status' => 401,
				'message' => 'Invalid Credentials'
			], 401);
		}
		
		$token = JWTAuth::fromUser($user);
		$user->last_login_at = Carbon::now()->toDateTimeString();
		$user->save();
		$user['token'] = $token;
		
		return response()->json([
			'status' => 200,
			'message' => 'Registration Success',
			'data' => $user,
		], 200);
	}
	
	public function forgotPassword(Request $request)
	{
		$validators = \Validator::make($request->all(), [
			'email' => 'required|email|max:255|exists:user,email',
		]);
		
		if ($validators->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'Email is invalid',
			], 400);
		}
		
		$user = User::whereEmail($request->email)->roleApps()->first();
		if (!$user) {
			return response()->json([
				'status' => 400,
				'message' => 'Email is not registered',
			], 400);
		}
		
		$password = str_random(8);
		$user->password = bcrypt($password);
		$user->updated_at = Carbon::now()->toDateTimeString();
		$user->save();
		
		$user->sendEmailForgotPassword($password);
		
		return response()->json([
			'status' => 200,
			'message' => 'Success, please check your email.',
		], 200);
	}
	
	/**
	 * @param Request $request
	 * @return type
	 */
    public function logout(Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		User::whereId($user->id)->update(['firebase_token' => null]);
		JWTAuth::parseToken()->invalidate();
		
        return response()->json([
			'status' => 200,
			'message' => 'Logout is success',
		], 200);
    }
	
	/**
	 * @param type $uniqueNumber
	 * @param Request $request
	 * @return type
	 */
	public function changePassword($uniqueNumber, Request $request)
	{
		$token = JWTAuth::parseToken()->authenticate();
		if ($token->unique_number != $uniqueNumber) {
			return response()->json([
				'status' => 403,
				'message' => 'Token not syncronize with parameter username',
			], 403);
		}

		$user = User::whereUniqueNumber($uniqueNumber)->roleApps()->first();
		
		$validator = \Validator::make($request->all(), [
			'current_password' => 'required',
			'new_password' => 'required|min:6',
			'confirm_password' => 'required|min:6',
		]);
		
		if ($validator->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'Some Parameters is invalid',
				'validators' => FormatConverter::parseValidatorErrors($validator),
			], 400);
		}
		
		if (!\Hash::check($request->current_password, $user->password)) {
			return response()->json([
				'status' => 400,
				'message' => 'Current Password do not match with database.',
				'validators' => FormatConverter::parseValidatorErrors($validator),
			], 400);
		}
		
		if ($request->new_password != $request->confirm_password) {
			return response()->json([
				'status' => 400,
				'message' => 'New Password do not match with Confirmation Password',
				'validators' => FormatConverter::parseValidatorErrors($validator),
			], 400);
		}
		
		$user->password = bcrypt($request->new_password);
		$user->save();
		
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
			'message' => 'change password is successfully saved.',
			'data' => $user,
		], 200);
	}
}