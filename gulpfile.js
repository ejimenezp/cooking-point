
var elixir = require('laravel-elixir');
// var elixirwebpack = require('laravel-elixir-webpack-official');
var gulp = require('gulp');
var gutil = require('gulp-util');
var ftp = require( 'vinyl-ftp' );
var git = require('gulp-git');
var print = require('gulp-print');
var jQuery = require('jquery');
// var jqueryui = require('jquery-ui');

var vue = require('laravel-elixir-vue');

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

elixir(mix => {
      mix.sass('app.scss')
    	.webpack('app.js')
    	.webpack('tienda.js')
    	.webpack('legacy/cp-scripts.js')
});
