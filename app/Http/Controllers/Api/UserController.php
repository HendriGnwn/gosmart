<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FormatConverter;
use App\Helpers\ImageHelper;
use App\PrivateModel;
use App\TeacherBank;
use App\TeacherTotalHistory;
use App\User;
use Carbon\Carbon;
use Eventviva\ImageResize;
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
		
		$user = User::whereId($user->id)->roleTeacher()->first();
		
		if (!empty($request->photo) || $request->photo!= '') {
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
			$img = ImageResize::createFromString(base64_decode($photoData['data']));
			$img->resizeToWidth(500);
			
			$user->deleteFile();
			$imageFilename = str_slug($request->first_name . ' ' . $request->last_name . ' ' . time()) . '.' . $photoData['extension'];
			
			$img->save($user->getPath() . $imageFilename);
			$request['photo'] = $imageFilename;
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
			$img = ImageResize::createFromString(base64_decode($data['data']));
			
			$user->teacherProfile->deleteFile();
			$imageFilename = str_slug($request->first_name . ' ' . $request->last_name . ' ' . time()) . '.' . $data['extension'];
			
			$img->save($user->teacherProfile->getPath() . $imageFilename);
			$request['upload_izajah'] = $imageFilename;
		}
		
		
		if (isset($request['photo']) && $request['photo'] != '') {
			$userRequest = $request->only([
				'first_name',
				'last_name',
				'phone_number',
				'latitude',
				'longitude',
				'address',
				'email',
				'photo'
			]);
		} else {
			$userRequest = $request->only([
				'first_name',
				'last_name',
				'phone_number',
				'latitude',
				'longitude',
				'address',
				'email',
			]);
		}
		
		$profileRequest = $request->only([
			'title',
			'izajah_number',
			'graduated',
			'bio',
			'upload_izajah',
		]);
		
		$user->fill($userRequest);
		$user->updated_at = Carbon::now()->toDateTimeString();
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
		
		$user = User::whereId($user->id)->roleStudent()->first();
		
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
			$img = ImageResize::createFromString(base64_decode($photoData['data']));
			$img->resizeToWidth(500);
			
			$user->deleteFile();
			$imageFilename = str_slug($request->first_name . ' ' . $request->last_name . ' ' . time()) . '.' . $photoData['extension'];
			
			$img->save($user->getPath() . $imageFilename);
			$request['photo'] = $imageFilename;
		}
		
		if (isset($request['photo']) && $request['photo'] != '') {
			$userRequest = $request->only([
				'first_name',
				'last_name',
				'phone_number',
				'latitude',
				'longitude',
				'address',
				'email',
				'photo',
			]);
		} else {
			$userRequest = $request->only([
				'first_name',
				'last_name',
				'phone_number',
				'latitude',
				'longitude',
				'address',
				'email',
			]);
		}
		
		
		$profileRequest = $request->only([
			'school',
			'degree',
			'department',
			'school_address',
		]);
		
		$user->fill($userRequest);
		$user->updated_at = Carbon::now()->toDateTimeString();
		$user->save();
		$user->studentProfile()->update($profileRequest);
		
		$profile = $user->studentProfile;
		if (!empty($profile->school) &&
			!empty($profile->degree) &&
			!empty($profile->school_address) &&
			!empty($user->photo)) {
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
	
	public function updateTeacherBank($uniqueNumber, Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		if ($user->unique_number != $uniqueNumber && $user->role != User::ROLE_TEACHER) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		$model = User::whereId($user->id)->roleTeacher()->actived()->first();
		if (!$model) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		$validators = \Validator::make($request->all(), [
			'name' => 'required|max:50',
			'number' => 'required|numeric',
			'branch' => 'required|max:100',
			'behalf_of' => 'required',
		]);
		
		if ($validators->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => FormatConverter::parseValidatorErrors($validators)
			], 400);
		}
		
		$request['user_id'] = $user->id;
		$attributes = $request->only([
			'user_id', 'name', 'number', 'branch', 'behalf_of'
		]);
		if (isset($model->teacherProfile->teacherBank)) {
			$model->teacherProfile->teacherBank->fill($attributes);
			$model->teacherProfile->teacherBank->updated_at = Carbon::now()->toDateTimeString();
			$model->teacherProfile->teacherBank->save();
		} else {
			$teacherBank = new TeacherBank();
			$teacherBank->fill($attributes);
			$teacherBank->created_at = $teacherBank->updated_at = Carbon::now()->toDateTimeString();
			$teacherBank->save();
		}
		
		$result = User::whereUniqueNumber($model->unique_number)
			->roleApps()
			->appsActived()
			->first();
		
		return response()->json([
			'status' => 200,
			'message' => 'Update success',
			'data' => $result,
		], 200);
	}
	
	public function requestHonor($uniqueNumber, Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		if ($user->unique_number != $uniqueNumber && $user->role != User::ROLE_TEACHER) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		$model = User::whereId($user->id)->roleTeacher()->actived()->first();
		if (!$model) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		$validators = \Validator::make($request->all(), [
			'total' => 'required|numeric',
		]);
		
		if ($validators->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => FormatConverter::parseValidatorErrors($validators)
			], 400);
		}
		
		$history = TeacherTotalHistory::whereUserId($user->id)->where('status', '!=', TeacherTotalHistory::STATUS_DONE)->count();
		if ($history) {
			return response()->json([
				'status' => 400,
				'message' => 'Honor already to requested.',
				'validators' => [
					'total' => null
				],
			], 400);
		}
		
		if ($request->total <= 0) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => [
					'total' => 'Total is invalid',
				],
			], 400);
		}
		
		if ($request->total > $user->teacherProfile->total) {
			return response()->json([
				'status' => 400,
				'message' => 'Some parameters is invalid',
				'validators' => [
					'total' => 'Total not more than IDR ' . $user->teacherProfile->getFormattedTotal(),
				],
			], 400);
		}
		
		$requestHonor = new TeacherTotalHistory();
		$requestHonor->fill($request->only(['total']));
		$requestHonor->private_id = null;
		$requestHonor->user_id = $model->id;
		$requestHonor->operation = TeacherTotalHistory::OPERATION_MINUS;
		$requestHonor->status = TeacherTotalHistory::STATUS_WAITING_FOR_APPROVE;
		$requestHonor->created_at =$requestHonor->updated_at = Carbon::now()->toDateTimeString();
		$requestHonor->save();
		
		$result = User::whereUniqueNumber($model->unique_number)
			->roleApps()
			->appsActived()
			->first();
		
		return response()->json([
			'status' => 200,
			'message' => 'Thank you, Your request will be processed',
			'data' => $result,
		], 200);
	}
	
	public function schedules($uniqueNumber, Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		if ($user->unique_number != $uniqueNumber) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		$user = User::whereId($user->id)->roleApps()->actived()->first();
		if (!$user) {
			return response()->json([
				'status' => 404,
				'message' => 'User is not found',
			], 404);
		}
		
		if ($user->role == User::ROLE_TEACHER) {
			$privateModels = PrivateModel::with(['student', 'teacher'])->whereTeacherId($user->id)->whereStatus(PrivateModel::STATUS_ON_GOING)->orderBy('private.created_at', 'desc')->get();
		} else if ($user->role == User::ROLE_STUDENT) {
			$privateModels = PrivateModel::with(['student', 'teacher'])->whereUserId($user->id)->whereStatus(PrivateModel::STATUS_ON_GOING)->orderBy('private.created_at', 'desc')->get();
		}
		
		$schedules = [];
		if (count($privateModels) > 0) {
			$no = 0;
			foreach ($privateModels as $privateModel) {
				$onAts = explode(',', $privateModel->getFirstPrivateDetail()->on_at);
				$dates = [];
				foreach ($onAts as $onAt) {
					if (\Carbon\Carbon::now()->toDateString() == \Carbon\Carbon::parse($onAt)->toDateString()) {
						$schedules[$no]['private_model'] = $privateModel;
						if ($user->role == User::ROLE_TEACHER) {
							$schedules[$no]['message'] = "Jadwal ngajar  ". Carbon::parse($onAt)->toDateTimeString() ." dengan mata pelajaran " . $privateModel->getFirstPrivateDetail()->teacherCourse->course->name . " untuk siswa " . $privateModel->student->getFullName();
						} else if ($user->role == User::ROLE_STUDENT) {
							$schedules[$no]['message'] = "Jadwal belajar ". Carbon::parse($onAt)->toDateTimeString() ." dengan mata pelajaran " . $privateModel->getFirstPrivateDetail()->teacherCourse->course->name . " untuk Guru " . $privateModel->teacher->getFullName();
						}
						$schedules[$no]['date'] = $onAt;
						$no++;
						break;
					}
				}
				
			}
		}
		
		return response()->json([
			'status' => 200,
			'message' => 'Success',
			'data' => $schedules,
		], 200);
	}
}