<?php

/*
| en repo newadmin
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
// react
//


//
// JSON BACK-END
//
Route::post('calendarevent/add', 'CalendareventController@add');
Route::get('calendarevent/get/{id}', 'CalendareventController@get');
Route::post('calendarevent/update', 'CalendareventController@update');
Route::get('calendarevent/delete/{id}', 'CalendareventController@delete');
Route::get('calendarevent/getavailability', 'CalendareventController@getAvailability');
Route::post('calendarevent/getschedule', 'CalendareventController@getSchedule');

Route::post('booking/add', 'BookingController@add');
Route::get('booking/index/{ce_id}', 'BookingController@index');
Route::post('booking/update', 'BookingController@update');
Route::get('booking/delete/{id}', 'BookingController@delete');
Route::post('booking/cancelIt', 'BookingController@cancelIt');
Route::post('booking/emailIt', 'BookingController@emailIt');
Route::post('booking/findByLocator', 'BookingController@findByLocator');
Route::get('booking/timezones', 'BookingController@timezones');

Route::get('blogtool/index', 'BlogtoolController@indexforadmin');
Route::post('blogtool/savedisplayposition', 'BlogtoolController@savedisplayposition');
Route::get('blogtool/get/{id}', 'BlogtoolController@get');
Route::get('blogtool/delete/{id}', 'BlogtoolController@delete');
Route::get('blogtool/related/{id}', 'BlogtoolController@related');
Route::get('blogtool/duplicate/{id}', 'BlogtoolController@duplicate');
Route::post('blogtool/update', 'BlogtoolController@update');
Route::get('blogtool/publish/{id}', 'BlogtoolController@publish');
Route::get('blogtool/getimages/{id}', 'BlogtoolController@getimages');
Route::post('blogtool/uploadimage', 'BlogtoolController@uploadimage');
Route::post('blogtool/removeimages', 'BlogtoolController@removeimages');

Route::get('staff/get', 'StaffController@getCooks');
Route::get('source/get', 'SourceController@get');
Route::get('eventtype/get', 'EventtypeController@get');
Route::get('eventtype/bookable_by_clients', 'EventtypeController@bookable_by_clients');
Route::get('priceplan/get', 'PriceplanController@get');
Route::get('priceplan/exchangeratesapiid', 'PriceplanController@exchangeratesapiid');

Route::post('viator', 'ViatorController@main');

Route::post('contact/contactoeventos', 'ContactControllerApi@contactoeventos');
Route::post('contact/contactonlineclasses', 'ContactControllerApi@contactonlineclasses');
Route::post('contact/googleadswebhook', 'ContactControllerApi@googleadswebhook');


Route::post('upload/uploadfile', 'UploadController@uploadfile');
Route::post('upload/removefiles', 'UploadController@removefiles');
Route::get('upload/getfiles', 'UploadController@getfiles');
Route::post('upload/previewfile', 'UploadController@previewfile');
Route::post('upload/importstaffing', 'CalendareventController@importStaffing');

//
// API for react new admin calls
//
Route::get('wallet', 'WalletController@retrieveLast20');
Route::post('wallet', 'WalletController@create');
Route::put('wallet/{id}', 'WalletController@update');
Route::delete('wallet/{id}', 'WalletController@destroy');
Route::get('wallet/master', 'WalletController@retrieveMaster');

Route::get('product', 'ShopController@retrieveMaster');

Route::get('shop/{date}', 'ShopController@retrieveTicketList');
Route::post('shop/ticket', 'ShopController@create');
Route::get('shop/ticket/{id}', 'ShopController@retrieve');
Route::put('shop/ticket/{id}', 'ShopController@update');
Route::delete('shop/ticket/{id}', 'ShopController@destroy');
