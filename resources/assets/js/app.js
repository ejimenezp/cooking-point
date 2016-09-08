
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: 'body'
});

window.$ = window.jQuery = require('jquery')
require('bootstrap-sass'); // needed for menu drop-down

///
/// jquery for page slideshows
///
$( document ).ready(function() {

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