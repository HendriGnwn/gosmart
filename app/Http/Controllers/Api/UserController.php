<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FormatConverter;
use App\Helpers\ImageHelper;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller 
{
	/**
	 * @param type $uniqueNumber
	 * @param Request $request
	 * @return type
	 */
	public function getByUniqueNumber($uniqueNumber, Request $request)
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
		
		return response()->json([
			'status' => 200,
			'message' => 'Success',
			'data' => $user,
		], 200);
	}
	
	public function updateTeacherProfile(Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		if ($user->role != User::ROLE_TEACHER) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		$validators = \Validator::make($request->all(), [
			'first_name' => 'required|max:50',
			//'last_name' => 'required',
			'phone_number' => 'required|numeric|min:10',
			'address' => 'required|max:255',
			'email' => 'required|email|max:100|unique:user,email,'.$user->id,
			'latitude' => 'required',
			'longitude' => 'required',
			'title' => 'required|numeric', //1,2,3
			//'ijazah_number' => 'required',
			'graduated' => 'required',
			//'photo' => 'required',
			//'upload_izajah' => 'required',
		]);
		
		if ($validators->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => array_merge(
						FormatConverter::parseValidatorErrors($validators), 
						[
							'photo' => null,
							'upload_izajah' => null,
						]
				),
			], 400);
		}
		
		if (!empty($request->photo)) {
			$photoBase64 = $request->photo;
			if (!ImageHelper::isImageBase64($photoBase64)) {
				return response()->json([
					'status' => 400,
					'message' => 'Some Parameters is invalid',
					'validators' => [
						'first_name' => null,
						'phone_number' => null,
						'address' => null,
						'email' => null,
						'latitude' => null,
						'longitude' => null,
						'title' => null,
						'graduated' => null,
						'bio' => null,
						'photo' => 'Photo format is invalid',
						'upload_izajah' => null,
					],
				]);
			}
			$photoData = ImageHelper::getImageBase64Information($photoBase64);
			
			$request['photo'] = null;
		}
		
		if (!empty($request->upload_izajah)) {
			$izajahBase64 = $request->upload_izajah;
			if (!ImageHelper::isImageBase64($izajahBase64)) {
				return response()->json([
					'status' => 400,
					'message' => 'Some Parameters is invalid',
					'validators' => [
						'first_name' => null,
						'phone_number' => null,
						'address' => null,
						'email' => null,
						'latitude' => null,
						'longitude' => null,
						'title' => null,
						'graduated' => null,
						'bio' => null,
						'photo' => null,
						'upload_izajah' => 'Izajah format is invalid',
					],
				]);
			}
			$data = ImageHelper::getImageBase64Information($izajahBase64);
			
			$request['upload_izajah'] = null;
		}
		
		$userRequest = $request->only([
			'first_name',
			'last_name',
			'phone_number',
			'latitude',
			'longitude',
			'address',
			'email',
		]);
		
		$profileRequest = $request->only([
			'title',
			'izajah_number',
			'graduated',
			'bio',
			'photo',
			'upload_izajah',
		]);
		
		$user = User::whereId($user->id)->roleTeacher()->first();
		$user->fill($userRequest);
		$user->updated_at = \Carbon\Carbon::now();
		$user->save();
		$user->teacherProfile()->update($profileRequest);
		
		$result = User::whereUniqueNumber($user->unique_number)
			->roleApps()
			->appsActived()
			->first();
		
		return response()->json([
			'status' => 200,
			'message' => 'Update success',
			'data' => $result,
		], 200);
	}
	
	public function updateStudentProfile(Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		if ($user->role != User::ROLE_STUDENT) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		$validators = \Validator::make($request->all(), [
			'first_name' => 'required|max:50',
			//'last_name' => 'required',
			'phone_number' => 'required|numeric|min:10',
			'address' => 'required|max:255',
			'email' => 'required|email|max:100|unique:user,email,'.$user->id,
			'latitude' => 'required',
			'longitude' => 'required',
			'school' => 'required',
			'degree' => 'required|numeric',
			//'department' => 'required',
			'school_address' => 'required',
			//'photo' => 'required',
		]);
		
		if ($validators->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => array_merge(
						FormatConverter::parseValidatorErrors($validators), 
						[
							'photo' => null,
						]
				),
			], 400);
		}
		
		if (!empty($request->photo)) {
			$photoBase64 = $request->photo;
			if (!ImageHelper::isImageBase64($photoBase64)) {
				return response()->json([
					'status' => 400,
					'message' => 'Some Parameters is invalid',
					'validators' => [
						'first_name' => null,
						'phone_number' => null,
						'address' => null,
						'email' => null,
						'latitude' => null,
						'longitude' => null,
						'school' => null,
						'degree' => null,
						'school_address' => null,
						'photo' => 'Photo format is invalid',
					],
				]);
			}
			$photoData = ImageHelper::getImageBase64Information($photoBase64);
			
			$request['photo'] = null;
		}
		
		$userRequest = $request->only([
			'first_name',
			'last_name',
			'phone_number',
			'latitude',
			'longitude',
			'address',
			'email',
		]);
		
		$profileRequest = $request->only([
			'school',
			'degree',
			'department',
			'school_address',
			'photo',
		]);
		
		$user = User::whereId($user->id)->roleStudent()->first();
		$user->fill($userRequest);
		$user->updated_at = \Carbon\Carbon::now();
		$user->save();
		$user->studentProfile()->update($profileRequest);
		
		$profile = $user->studentProfile;
		if (!empty($profile->school) &&
			!empty($profile->degree) &&
			!empty($profile->school_address) &&
			!empty($profile->photo)) {
			$user->status = User::STATUS_ACTIVE;
		} else {
			$user->status = User::STATUS_INACTIVE;
		}
		$user->save();
		
		$result = User::whereUniqueNumber($user->unique_number)
			->roleApps()
			->appsActived()
			->first();
		
		return response()->json([
			'status' => 200,
			'message' => 'Update success',
			'data' => $result,
		], 200);
	}
}