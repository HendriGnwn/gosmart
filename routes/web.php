<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth', 'AdminAccess'], 'prefix' => 'admin'], function() {
	Route::get('/dashboard/list-teacher', ['as' => 'dashboard.listteacher', 'uses' => 'Admin\\DashboardController@listTeachers']);
	Route::get('/', 'Admin\\DashboardController@index');
	
	Route::get('/payment/data', ['as' => 'payment.data', 'uses' => 'Admin\\PaymentController@anyData']);
	Route::resource('/payment', 'Admin\\PaymentController');
	
	Route::get('/bank/data', ['as' => 'bank.data', 'uses' => 'Admin\\BankController@anyData']);
	Route::resource('/bank', 'Admin\\BankController');
	
	Route::get('/course-level/data', ['as' => 'course-level.data', 'uses' => 'Admin\\CourseLevelController@anyData']);
	Route::resource('/course-level', 'Admin\\CourseLevelController');
	
	Route::get('/course/data', ['as' => 'course.data', 'uses' => 'Admin\\CourseController@anyData']);
	Route::resource('/course', 'Admin\\CourseController');
	
	Route::get('/order/data', ['as' => 'order.data', 'uses' => 'Admin\\OrderController@anyData']);
	Route::resource('/order', 'Admin\\OrderController');
	
	Route::get('/private/data', ['as' => 'private.data', 'uses' => 'Admin\\PrivateController@anyData']);
	Route::resource('/private', 'Admin\\PrivateController');
	
	Route::get('/student/data', ['as' => 'student.data', 'uses' => 'Admin\\StudentController@anyData']);
	Route::resource('/student', 'Admin\\StudentController');
	
	Route::get('/teacher/course/data/{id}', 'Admin\\TeacherController@listTeacherCourses');
	Route::get('/teacher/data', ['as' => 'teacher.data', 'uses' => 'Admin\\TeacherController@anyData']);
	Route::resource('/teacher', 'Admin\\TeacherController');
	
	Route::get('/user/data', ['as' => 'user.data', 'uses' => 'Admin\\UserController@anyData']);
	Route::resource('/user', 'Admin\\UserController');
});
