
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.$ = window.jQuery = require('jquery')
require('bootstrap-sass'); // needed for menu drop-down

// to allow sass mixins for different browsers
document.documentElement.setAttribute("data-browser", navigator.userAgent);

///
/// jquery for page slideshows
///
$( document ).ready(function() {

	console.log(navigator.userAgent)

	var currentIndex = 0,
	items = $('.cp-slideshow div'),
	itemAmt = items.length;
	
	function cycleItems() {
	var item = $('.cp-slideshow div').eq(currentIndex);
	items.hide();
	item.css('display','inline-block');
	}
	
	var autoSlide = setInterval(function() {
	currentIndex += 1;
	if (currentIndex > itemAmt - 1) {
	  currentIndex = 0;
	}
	cycleItems();
	}, 4000);

});