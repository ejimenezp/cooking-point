// comentario para nuevos-estados
var elixir = require('laravel-elixir');
var gulp = require('gulp');
var gutil = require('gulp-util');
var ftp = require( 'vinyl-ftp' );
var git = require('gulp-git');
var print = require('gulp-print');
var jQuery = require('jquery');

// var jqueryui = require('jquery-ui-browserify');

// var vue = require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    	mix.sass('app.scss')
    	.browserify('app.js')
    	.browserify('tienda.js')
    	.browserify('admin.js')
    	.browserify('report.js')
    	.browserify('booking.js')
    	.browserify('classemails.js')
    	.browserify('contactoeventos.js')

    	mix.version(['css/app.css', 'js/app.js', 'js/tienda.js', 'js/admin.js', 'js/report.js', 'js/booking.js', 'js/classemails.js'])
});
