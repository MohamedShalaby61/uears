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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//authentication
Route::post('login'    , 'API\UserController@login');
Route::post('register' , 'API\UserController@register');


//contact us 
Route::post('contactus','API\ContactUsController@store');

//Faculities
Route::post('insert_faculty','API\FacultyController@insert_faculty');
Route::get('all_faculities','API\FacultyController@all_faculities');
Route::get('get_faculty','API\FacultyController@get_faculty');


