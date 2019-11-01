
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

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


/**
 *  Project:      Scroll Up For Menu
 *  Description:  A simple mobile optimised menuing system which gets out of the way when you're not using it.
 *  Author:       David Simpson <david@davidsimpson.me>
 *  License:      Apache License, Version 2.0 <http://www.apache.org/licenses/LICENSE-2.0.html>
 *  Source:       http://github.com/dvdsmpsn/scroll-up-for-menu
 *
 *  Usage:        $('#top').scrollUpMenu(options);
 *      
 *
 *
 */
;(function ( $, window, document, undefined ) {

	var pluginName = 'scrollUpMenu';
	var defaults = {
			waitTime: 100,
			transitionTime: 50,
			menuCss: { 'position': 'fixed', 'top': '0', 'z-index' : '1030'},
			showDelta: 0
	};

	var lastScrollTop = 0;
	var $header;
	var timer;
	var pixelsFromTheTop;

	// The actual plugin constructor
	function Plugin ( element, options ) {
		this.element = element;
		this.settings = $.extend( {}, defaults, options );
		this._defaults = defaults;
		this._name = pluginName;
		this.init();
	}

	Plugin.prototype = {
		init: function () {
			
			var self = this;
			$header = $(this.element);
			$header.css(self.settings.menuCss);
			pixelsFromTheTop = $header.height();
			
			// $header.next().css({ 'margin-top': pixelsFromTheTop });
		
			$(window).bind('scroll',function () {
				clearTimeout(timer);
				timer = setTimeout(function() {
					self.refresh(self.settings);
				}, self.settings.waitTime );
			});
		},
		refresh: function (settings) {
			// Stopped scrolling, do stuff...
			var scrollTop = $(window).scrollTop();
			var change = lastScrollTop - scrollTop;

			if (scrollTop > lastScrollTop && scrollTop > pixelsFromTheTop){ // ensure that the header doesnt disappear too early
				// downscroll
				$header.slideUp(settings.transitionTime);
			} else {
				// upscroll
				if ( change > settings.showDelta ) {
					$header.slideDown(settings.transitionTime);
				}
			}
			lastScrollTop = scrollTop;
		}
	};

	$.fn[ pluginName ] = function ( options ) {
		return this.each(function() {
				if ( !$.data( this, 'plugin_' + pluginName ) ) {
						$.data( this, 'plugin_' + pluginName, new Plugin( this, options ) );
				}
		});
	};

})( jQuery, window, document );


//
//
// jQuery main function
//
//

$( document ).ready(function() {

var page = $("meta[name=page]").attr("content")
var caption = $("meta[name=page]").attr("caption")

if( /iPhone/i.test(navigator.userAgent) || $(window).width() <= 768) {
	// no video here for these browsers, squared banners
	if (page ==='') {
		// do nothing
	} else if (page === 'home') {
		$("#section-banner").append('<img class="img-fluid" src="/images/home-banner-sm.jpg" >')
	} else {
		$("#section-banner").append('<img class="img-fluid" src="/images/'+page+'-banner-sm.jpg" alt="'+caption+'" >')
	}
} else {
	if (page ==='') {
		// do nothing
	} else if (page === 'home') {

		$("#section-banner").append('<div class="img-fluid"> \
			<video id="video-home" poster="/images/home-banner.jpg" autoplay playsinline muted > \
	     	<source src="images/home-video-banner-01.mp4" type="video/mp4"> \
	   	 </video></div>')

		var videoList = ["images/home-video-banner-01.mp4", "images/home-video-banner-02.mp4","images/home-video-banner-03.mp4", "images/home-video-banner-04.mp4"]
		var curVideo = 0
		var myVideo = $('#video-home').get(0)

		myVideo.onended = function() {
			$('#video-home').removeAttr('poster')
			curVideo++
		    if(curVideo < videoList.length){    		
		        myVideo.src = videoList[curVideo];        
		    }
		    else {
		    	curVideo = 0;
		        myVideo.src = videoList[curVideo];        
		    }
		}
		// workaround to force autoplay on Safari browsers (iPad)
		if ( /Safari/i.test(navigator.userAgent) ) {
			setTimeout(function() { myVideo.play()}, 50)
		}
	} else {
		$("#section-banner").append('<img class="img-fluid" src="/images/'+page+'-banner.jpg" alt="'+caption+'" >')
	}




}

// to highlight selected menubar option
$('nav ul li a[href="' + window.location.pathname + '"]').addClass('active')


function toggleVideo () {
	var myVideo = $('#video-home').get(0)
	if (myVideo !== undefined){
		if (myVideo.paused) {
			myVideo.play()
			$('.home-pause-button').html('<i class="fa fa-pause"></i>')
			setTimeout(toggleVideo, 90*1000)
		} else {
			myVideo.pause()
			$('.home-pause-button').html('<i class="fa fa-play"></i>')
		}		
	}


}
$('.home-pause-button').click(toggleVideo)
setTimeout(toggleVideo, 90*1000)


$('#cabecera').scrollUpMenu();

//
// private-events' page call to action
//
$('.email-us').css('cursor', 'pointer');
$('.email-us').click(function() {
	window.open('mailto:info@cookingpoint.es', 'newwindow');
	return false;
	});

}); // end jQuery

