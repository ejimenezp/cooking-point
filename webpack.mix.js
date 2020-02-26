
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
	.js('resources/assets/js/app.js', 'public/js')
	.js('resources/assets/js/home.js', 'public/js')
	.js('resources/assets/js/booking.js', 'public/js')
	.js('resources/assets/js/tienda.js', 'public/js')
	.js('resources/assets/js/cashbox.js', 'public/js')
	.js('resources/assets/js/admin.js', 'public/js')
	.js('resources/assets/js/adminblogtool.js', 'public/js')
	.js('resources/assets/js/report.js', 'public/js')
	.js('resources/assets/js/fileuploader.js', 'public/js')
	.js('resources/assets/js/classemails.js', 'public/js')
	.js('resources/assets/js/contactoeventos.js', 'public/js');

if (mix.inProduction()) {
    mix.version();
}

