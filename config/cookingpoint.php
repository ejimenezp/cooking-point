<?php
/* 
 *
 * Cooking Point Booking System Configuration File
 *
 *
 */
return [

	'favicon' => env('APP_FAVICON' , 'rubbish-icon'),
	'adminfavicon' => env('APP_ADMIN_FAVICON' , 'rubbish-icon'),

	'redsys' => [
	    'firma' => 'TioXuMyEcpN34V4kO2hS36ru/4pl3rzv',
	    // 'merchanturl' => 'http://bs2.cookingpoint.es/callback', // testing
	    'merchanturl' => env('APP_URL', 'https://cookingpoint.es') . '/callback', 
	    'nombrecomercio' => 'Cooking Point',
	    'fuc' => '333658318',
	    'url' => 'https://sis.redsys.es/sis/realizarPago',  // production
	    'produrl' => 'https://sis.redsys.es/sis/realizarPago',
	    'testurl'=> 'https://sis-t.redsys.es:25443/sis/realizarPago',
		],
	'gmail' => [
		'client_secret' => 'app/client_secret_testing.json',
		'credentials' => 'app/gmail_api_credentials_testing.json',
		'refresh' => 'app/refresh_token_testing.json',
		],
];

