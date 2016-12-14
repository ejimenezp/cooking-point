<?php

/*
 * |--------------------------------------------------------------------------
 * | Routes File
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you will register all of the routes in an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */

//
// Cooking Point
//

//
// FRONT-END
//
Route::get('/', function () { return view('pages.home', ['page' => 'home']); });

Route::get('bookings', 'BookingControllerOnline@legacyget');
Route::get('booking/forget', 'BookingControllerOnline@forget');
Route::get('/booking/{locator?}/{tpv_result?}', 'BookingControllerOnline@get')->middleware('cp-locator');
Route::get('/classes', function () { return view('pages.home', ['page' => 'home']); });
Route::get('/classes-paella-cooking-madrid-spain', function () { return view('pages.paella'); });
Route::get('/classes-spanish-tapas-madrid-spain', function () { return view('pages.tapas'); });
Route::get('/contact', function () { return view('pages.contact', ['page' => 'contact']); });
Route::get('/faq', function () { return view('pages.faq'); });
Route::get('/gallery', function () { return view('pages.gallery'); });
Route::get('/pay/{id}', 'TPVController@pay')->name('pay');
Route::post('/callback', 'TPVController@callback');
Route::get('/private-cooking-events-madrid-spain', function () { return view('pages.events'); });
Route::get('/school-madrid-spain', function () { return view('pages.school'); });
Route::get('/wine-tasting-madrid-spain', function () { return view('pages.wine'); });





//
// ONLINE ADMIN
//

Route::get('/admin/login', 'AuthController@login')->name('login');
Route::post('/admin/checklogin', 'AuthController@checklogin');
Route::get('/admin/logout', 'AuthController@logout');

Route::group(['prefix' => 'admin', 'middleware' => 'cp-auth'], function () {
    Route::get('', function() { return view('admin.index'); });
    Route::get('calendarevent', function() { return view('admin.index'); });
    Route::get('booking', function() { return view('admin.index'); });
});


//
// TIENDA
//
Route::group(['prefix' => 'tienda', 'middleware' => 'cp-auth'], function () {
	Route::get('', 'TicketsController@front');
	Route::get('tickets', 'TicketsController@index');
	Route::post('addticket', 'TicketsController@addticket');
	Route::get('deleteticket/{id}', 'TicketsController@deleteticket');
});


/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | This route group applies the "web" middleware group to every route
 * | it contains. The "web" middleware group is defined in your HTTP
 * | kernel and includes session state, CSRF protection, and more.
 * |
 */

Route::group([
    'middleware' => [
        'web'
    ]
], function () {
    //
});
