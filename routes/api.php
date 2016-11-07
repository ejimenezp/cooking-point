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
Route::post('calendarevent/getschedule', 'CalendarEventControllerOnline@getSchedule');
Route::post('calendarevent/add', 'CalendarEventControllerOnline@add');
Route::post('calendarevent/update', 'CalendarEventControllerOnline@update');
Route::get('calendarevent/delete/{id}', 'CalendarEventControllerOnline@delete');

Route::get('booking/index/{ce_id}', 'BookingControllerOnline@index');
Route::post('booking/add', 'BookingControllerOnline@add');
Route::post('booking/update', 'BookingControllerOnline@update');
Route::get('booking/delete/{id}', 'BookingControllerOnline@delete');

Route::get('staff/get', 'StaffController@getCooks');

Route::get('source/get', 'SourceController@get');