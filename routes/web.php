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
Route::get('/', 'CalendareventControllerOnline@home');

Route::get('/bookings/{hash?}', 'BookingControllerOnline@legacyget');
Route::get('/booking/forget', 'BookingControllerOnline@forget');
Route::get('/booking/{locator?}/{tpv_result?}', 'BookingControllerOnline@get')->middleware('cp-locator');
Route::get('/classes-paella-cooking-madrid-spain', 'CalendareventControllerOnline@paella');
Route::get('/classes-spanish-tapas-madrid-spain', 'CalendareventControllerOnline@tapas');
Route::get('/location', function () { return view('pages.location', ['page' => 'location']); });
Route::get('/faq', function () { return view('pages.faq'); });
Route::get('/gallery', function () { return view('pages.gallery'); });
Route::get('/pay/{id}', 'TPVController@pay')->name('pay');
Route::post('/callback', 'TPVController@callback');
Route::get('/private-cooking-events-madrid-spain', function () { return view('pages.events'); });
Route::get('/eventos-privados-madrid', function () { return view('pages.eventos'); });
Route::get('/contacto-eventos-privados', function () { return view('pages.contactoeventos'); });
Route::get('/oferta-para-agencias', function () { return view('pages.agencias'); });

//
// blog entries
//
Route::get('/blog', function () { return view('pages.blog'); });
Route::get('/paella-fish-stock', function () { return view('blog.fish-stock'); });
Route::get('/iberico-ham', function () { return view('blog.iberico-ham'); });
Route::get('/denominacion-de-origen-protegida', function () { return view('blog.dop'); });
Route::get('/spanish-potato-omelet', function () { return view('blog.tortilla'); });



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
    Route::get('report', function() { return view('admin.reportindex'); });
    Route::post('report/{id}', 'ReportController@report');
    Route::get('classemails', function() { return view('admin.classemails'); });
});


//
// TIENDA
//
Route::group(['prefix' => 'tienda', 'middleware' => 'cp-auth'], function () {
	Route::get('', 'TicketsController@front');
	Route::get('tickets', function() { return view('tienda.index'); });
	Route::post('addticket', 'TicketsController@addticket');
	Route::get('deleteticket', 'TicketsController@deleteticket');
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
