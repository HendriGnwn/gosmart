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
			Route::get('/notification/{uniqueNumber}', 'Api\RequestController@notification');
			Route::get('/notification/detail/{id}', 'Api\RequestController@getNotification');
			
			Route::get('/schedules/{uniqueNumber}', 'Api\UserController@schedules');
		});
		Route::group(['prefix' => 'teacher'], function() {
			Route::post('/choose-course/{uniqueNumber}', 'Api\CourseController@chooseCourse');
			Route::put('/choose-course/update/{uniqueNumber}/{id}', 'Api\CourseController@updateChooseCourse');
			Route::delete('/choose-course/delete/{uniqueNumber}/{id}', 'Api\CourseController@deleteChooseCourse');
			Route::post('/update-teacher-bank/{uniqueNumber}', 'Api\UserController@updateTeacherBank');
			Route::post('/request-honor/{uniqueNumber}', 'Api\UserController@requestHonor');
		});
		Route::group(['prefix' => 'order'], function () {
			Route::post('/create/{uniqueNumber}', 'Api\OrderController@create');
			Route::get('/show/{uniqueNumber}', 'Api\OrderController@show');
			Route::patch('/update/on-at/{uniqueNumber}/{orderId}', 'Api\OrderController@updateOnAt');
			Route::delete('/delete/{uniqueNumber}/{orderId}', 'Api\OrderController@deleteOrder');
			Route::patch('/checkout/{uniqueNumber}/{orderId}', 'Api\OrderController@checkout');
			Route::post('/confirmation/{uniqueNumber}/{orderId}', 'Api\OrderController@confirmation');
			Route::get('/histories/{uniqueNumber}', 'Api\OrderController@histories');
		});
		Route::group(['prefix' => 'private'], function () {
			Route::get('/active/{uniqueNumber}', 'Api\PrivateController@activedPrivate');
			Route::get('/actives-by-teacher/{uniqueNumber}', 'Api\PrivateController@activedPrivates');
			Route::get('/histories/{uniqueNumber}', 'Api\PrivateController@histories');
			Route::post('/check/{uniqueNumber}/{privateId}', 'Api\PrivateController@check');
		});
		
		Route::get('/courses-availability', 'Api\CourseController@listAvailability');
		Route::get('/similiar-courses/{id}', 'Api\CourseController@getSimiliarTeacherCourses');
		Route::get('/courses', 'Api\CourseController@index');
	});

	Route::get('/course-levels', 'Api\CourseController@getCourseLevelWithRelations');
	Route::get('/courses-spinner', 'Api\CourseController@listCourseLevels');
	Route::get('/payments', 'Api\PaymentController@listPayments');
	
	Route::get('/teacher-term-condition', 'Api\RequestController@teacherTermCondition');
	Route::post('/review/{uniqueNumber}', 'Api\RequestController@storeReview');
	Route::post('/send-feedback', 'Api\RequestController@sendFeedback');
	
});