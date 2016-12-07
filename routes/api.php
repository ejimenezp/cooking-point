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

//
// JSON BACK-END
//
Route::post('calendarevent/getavailability', 'CalendarEventControllerApi@getAvailability');
Route::post('calendarevent/getschedule', 'CalendarEventControllerApi@getSchedule');
Route::post('calendarevent/add', 'CalendarEventControllerApi@add');
Route::post('calendarevent/update', 'CalendarEventControllerApi@update');
Route::get('calendarevent/delete/{id}', 'CalendarEventControllerApi@delete');

Route::get('booking/index/{ce_id}', 'BookingControllerApi@index');
Route::post('booking/add', 'BookingControllerApi@add');
Route::post('booking/update', 'BookingControllerApi@update');
Route::get('booking/delete/{id}', 'BookingControllerApi@delete');
Route::post('booking/findByLocator', 'BookingControllerApi@findByLocator');

Route::get('staff/get', 'StaffController@getCooks');

Route::get('source/get', 'SourceController@get');