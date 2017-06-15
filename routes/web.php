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

Route::name('login')->get('/idp', '\StudentAffairsUwm\Shibboleth\Controllers\ShibbolethController@login');

Route::group(['middleware' => 'auth'], function(){
    Route::resource('courses', 'CourseController');
    Route::name('courses.fetch')->post('/courses/fetch', 'CourseController@fetch');
});
