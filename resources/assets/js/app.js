
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.$ = window.jQuery = require('jquery');
require('bootstrap');
require('lazysizes');
// import a plugin
require('lazysizes/plugins/parent-fit/ls.parent-fit');


// window.Vue = require('vue');

// *
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
 

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });


// to allow sass mixins for different browsers
document.documentElement.setAttribute("data-browser", navigator.userAgent);

///
/// jquery for page slideshows
///

//
//
// jQuery main function
//
//

$( document ).ready(function() {

	var page = $("meta[name=page]").attr("content")
	var caption = $("meta[name=page]").attr("caption")

	// if (page !=='') {
	// 	if (/iPhone/i.test(navigator.userAgent) || $(window).width() <= 768) {
	if (true) {
		if ($(window).width() <= 768) {
			$("#section-banner").append('<img class="lazyload img-fluid" data-src="/images/'+page+'-banner-sm.jpg" alt="'+caption+'" >');
		} else {
			$("#section-banner").append('<img class="lazyload img-fluid" data-src="/images/'+page+'-banner.jpg" alt="'+caption+'" >');
		}		
	}



}); // end jQuery


// to make divs clickable
$(".all-clickable").click(function() {
  window.location = $(this).find("a").attr("href"); 
  return false;
});


// to highlight selected menubar option
$('nav ul li a[href="' + window.location.pathname + '"]').addClass('active');


//
// private-events' page call to action
//
$('.email-us').css('cursor', 'pointer');

$('.email-us').click(function() {
	window.open('mailto:info@cookingpoint.es', 'newwindow');
	return false;
});

