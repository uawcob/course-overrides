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

Route::group(['middleware' => 'auth'], function(){
    Route::name('courses.data')->get('/courses/data', 'CourseController@data');
    Route::name('courses.fetch')->post('/courses/fetch', 'CourseController@fetch');
    Route::resource('courses', 'CourseController');

    Route::name('cart.index')->get('/cart', 'CartController@index');
    Route::name('cart.data')->get('/cart/data', 'CartController@data');
    Route::name('cart.add')->post('/cart/add/{course}', 'CartController@add');
    Route::name('cart.remove')->post('/cart/remove/{course}', 'CartController@remove');

    Route::name('admin.index')->get('/admin', 'AdminController@index');

    Route::name('plans.index')->get('/plans', 'PlanController@index');

    Route::name('requests.index')->get('/requests', 'PlanController@requests');
});
