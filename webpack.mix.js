/*
  Para compilar usar:
    npm run dev
*/

const mix = require('laravel-mix')
require('laravel-mix-polyfill')

mix.webpackConfig({
  module: {
    rules: [
      { test: /booking.js/, loader: 'babel-loader' }
    ]
  }
})

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
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/booking.scss', 'public/css')
  .sass('resources/sass/admin/admin.scss', 'public/css/admin')
  .js('resources/js/app.js', 'public/js').sourceMaps()
  .js('resources/js/home.js', 'public/js')
  .js('resources/js/contactoeventos.js', 'public/js')
  .js('resources/js/contactonlineclasses.js', 'public/js')
  .js('resources/js/booking/booking.js', 'public/js')
  .js('resources/js/admin/bookings.js', 'public/js/admin')
  .js('resources/js/admin/tienda.js', 'public/js/admin')
  .js('resources/js/admin/cashbox.js', 'public/js/admin')
  .js('resources/js/admin/admin.js', 'public/js/admin')
  .js('resources/js/admin/blogtool.js', 'public/js/admin')
  .js('resources/js/admin/report.js', 'public/js/admin')
  .js('resources/js/admin/fileuploader.js', 'public/js/admin')
  .js('resources/js/admin/classemails.js', 'public/js/admin')
  .js('resources/js/adminbookings/adminbookings.js', 'public/js/admin')

if (mix.inProduction()) {
  mix.version()
}
