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
// react
//
Route::get('/booking/forget', 'BookingController@forget');
Route::get('/booking/new/availability', 'BookingController@get')->middleware('cp-locator');
Route::get('/booking/{locator?}/{more?}', 'BookingController@get')->middleware('cp-locator');

//
// FRONT-END
//
Route::get('/', 'CalendareventControllerOnline@home');
Route::get('/classes-paella-cooking-madrid-spain', 'CalendareventControllerOnline@paella');
Route::get('/classes-spanish-tapas-madrid-spain', 'CalendareventControllerOnline@tapas');
Route::get('/online-virtual-cooking-classes', 'CalendareventControllerOnline@online');

Route::get('/location', function () { return view('pages.location'); });
Route::get('/faq', function () { return view('pages.faq'); });
Route::get('/gallery', function () { return view('pages.gallery'); });
Route::get('/pay/{id}', env('APP_ENV') == 'production' ? 'TPVController@pay' : 'TPVControllerStub@pay')->name('pay');
Route::post('/callback', env('APP_ENV') == 'production' ? 'TPVController@callback' : 'TPVControllerStub@callback');
Route::post('/tpv-stub-main', 'TPVStub@main');
Route::post('/tpv-stub-reply', 'TPVStub@reply');
Route::get('/private-events', function () { return view('pages.privateevents'); });
Route::get('/private-cooking-events-madrid-spain', function () { return view('pages.events'); });
Route::get('/private-online-events', function () { return view('pages.onlineevents'); });
Route::get('/actividades-team-building-empresas-madrid', function () { return view('pages.espanol.actividadesempresas'); });
Route::get('/oferta-para-agencias', function () { return view('pages.espanol.agencias'); });
Route::get('/paymentrequest/{locator?}/{tpv_result?}', 'BookingControllerOnline@thirdpartypaymentget');
Route::get('/about-us', function () { return view('pages.aboutus'); });
Route::get('/best-cooking-classes-madrid', function () { return view('pages.bestclasses'); });
Route::get('/online-virtual-cooking-classes/spanish-classic-recipes', function () { return view('pages.onlineclasses.selection'); });
Route::get('/online-virtual-cooking-classes/paella', function () { return view('pages.onlineclasses.paella'); });
Route::get('/actividades-team-building-online', function () { return view('pages.espanol.teambuildingonline'); });
// Route::get('/in-person-classes-madrid', function () { return view('pages.inperson'); });
Route::get('/privacidad', function () { return view('pages.espanol.privacidad'); });

//
// blog entries
//
Route::get('/blog', 'BlogtoolController@indexforuser');
Route::get('/blog/{friendlyurl}', 'BlogtoolController@showpost');
Route::get('/sitemap.txt', 'BlogtoolController@sitemap');



//
// ONLINE ADMIN
//

Route::get('/admin/login', 'AuthController@login')->name('login');
Route::post('/admin/checklogin', 'AuthController@checklogin');
Route::get('/admin/logout', 'AuthController@logout');

Route::group(['prefix' => 'admin', 'middleware' => 'cp-auth'], function () {
    Route::get('', function() {     return redirect('admin/bookings'); });
    Route::get('bookings', function() { return view('admin.bookings'); });
    Route::get('bookings/layouttest', 'CalendareventController@layouttest');
    Route::post('bookings/layout', 'CalendareventController@layout');
    Route::get('bookings/calendarevent', function() { return view('admin.bookings'); });
    Route::get('bookings/booking', function() { return view('admin.bookings'); });
    Route::post('report/{id}', 'ReportController@report');
    Route::get('blogtool', function() { return view('admin.postindex'); });
    Route::get('blogtool/sandbox', function () { return view('admin.blogsandbox'); });
    Route::get('blogtool/{id}', function($id) { return view('admin.post',['id' => $id]); });
    Route::get('blogtool/preview/{id}', 'BlogtoolController@preview' );
    Route::get('report', function() { return view('admin.reportindex'); });
    Route::get('cashbox', function() { return view('admin.cashbox.index'); });
    Route::get('cashbox/{id}', function($id) { return view('admin.cashbox.sesion',['id' => $id]); });
    Route::get('tienda', 'TicketsController@front');
    Route::get('tienda/tickets', function() { return view('admin.tienda.sales'); });
    Route::get('tienda/deleteticket', 'TicketsController@deleteticket');
    Route::get('classemails', function() { return view('admin.classemails'); });
    Route::get('fileuploader', function() { return view('admin.fileuploader'); });
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
