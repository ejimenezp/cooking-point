
/*
	Para compilar usar: 
		npm run dev
*/


let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
	.sass('resources/assets/sass/app.scss', 'public/css')
	.sass('resources/assets/sass/booking.scss', 'public/css')
	.sass('resources/assets/sass/admin/admin.scss', 'public/css/admin')
	.js('resources/assets/js/app.js', 'public/js')
	.js('resources/assets/js/home.js', 'public/js')
	.js('resources/assets/js/booking.js', 'public/js')
	.js('resources/assets/js/admin/bookings.js', 'public/js/admin')
	.js('resources/assets/js/admin/tienda.js', 'public/js/admin')
	.js('resources/assets/js/admin/cashbox.js', 'public/js/admin')
	.js('resources/assets/js/admin/admin.js', 'public/js/admin')
	.js('resources/assets/js/admin/blogtool.js', 'public/js/admin')
	.js('resources/assets/js/admin/report.js', 'public/js/admin')
	.js('resources/assets/js/admin/fileuploader.js', 'public/js/admin')
	.js('resources/assets/js/admin/classemails.js', 'public/js/admin')
	.js('resources/assets/js/admin/contactoeventos.js', 'public/js/admin');

if (mix.inProduction()) {
    mix.version();
}

