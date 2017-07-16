<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'middleware' => ['requiredParameterJson']], function () {
	
	Route::group(['prefix' => 'auth'], function () {
		Route::post('/login', 'Api\AuthController@login');
		Route::post('/register-student', 'Api\AuthController@registerStudent');
		Route::post('/register-teacher', 'Api\AuthController@registerTeacher');
		Route::post('/forgot-password', 'Api\AuthController@forgotPassword');
	});
	
	Route::group(['middleware' => ['jwt.auth']], function() {
		Route::group(['prefix' => 'auth'], function() {
			Route::post('/change-password/{uniqueNumber}', 'Api\AuthController@changePassword');
			Route::post('/logout', 'Api\AuthController@logout');
		});
		Route::group(['prefix' => 'user'], function() {
			Route::get('/get-by-unique/{uniqueNumber}', 'Api\UserController@getByUniqueNumber');
			Route::put('/update-student', 'Api\UserController@updateStudentProfile');
			Route::put('/update-teacher', 'Api\UserController@updateTeacherProfile');
		});
		Route::group(['prefix' => 'teacher'], function() {
			Route::post('/choose-course/{uniqueNumber}', 'Api\CourseController@chooseCourse');
		});
	});
	
	Route::get('/course-levels', 'Api\CourseController@getCourseLevelWithRelations');
	Route::get('/courses-spinner', 'Api\CourseController@listCourseLevels');
	Route::get('/payments', 'Api\PaymentController@listPayments');
	
});