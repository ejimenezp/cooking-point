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
Route::post('calendarevent/getavailability', 'CalendareventControllerApi@getAvailability');
Route::post('calendarevent/getschedule', 'CalendareventControllerApi@getSchedule');
Route::post('calendarevent/add', 'CalendareventControllerApi@add');
Route::post('calendarevent/update', 'CalendareventControllerApi@update');
Route::get('calendarevent/find/{id}', 'CalendareventControllerApi@find');
Route::get('calendarevent/delete/{id}', 'CalendareventControllerApi@delete');

Route::get('booking/index/{ce_id}', 'BookingControllerApi@index');
Route::post('booking/add', 'BookingControllerApi@add');
Route::post('booking/update', 'BookingControllerApi@update');
Route::get('booking/delete/{id}', 'BookingControllerApi@delete');
Route::post('booking/findByLocator', 'BookingControllerApi@findByLocator');
Route::post('booking/emailIt', 'BookingControllerApi@emailIt');
Route::post('booking/cancelIt', 'BookingControllerApi@cancelIt');

Route::get('staff/get', 'StaffController@getCooks');

Route::get('source/get', 'SourceController@get');

Route::get('tienda/getTickets', 'TicketsController@getTickets');

Route::post('viator', 'ViatorController@main');
