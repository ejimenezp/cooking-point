
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

var page = $("meta[name=page]").attr("content")
var caption = $("meta[name=page]").attr("caption")

if( /iPhone/i.test(navigator.userAgent) || $(window).width() <= 768) {
	$("#banner").append('<img id="image-home" src="/images/home-banner-sm.jpg" >')
	if (page !== ''){
		$("#section-banner").append('<img class="banner" src="/images/'+page+'-banner-sm.jpg" alt="'+caption+'" >')
	}
} else {
	$("#banner").append('<video id="video-home" poster="/images/home-banner.jpg" autoplay playsinline muted loop> \
	     	<source src="images/small.mp4" type="video/mp4"> \
	   	 </video>')

	// workaround to force autoplay on Safari browsers (iPad)
	if ( /Safari/i.test(navigator.userAgent) ) {
		console.log('iPad landscape')
		var myVideo = $('#video-home').get(0)
		setTimeout(function() { myVideo.play()}, 50)
	}
	// end workaround

	if (page !== ''){
		$("#section-banner").append('<img class="banner" src="/images/'+page+'-banner.jpg" alt="'+caption+'" >')
	}

}

// to highlight selected menubar option
$('.nav li a[href="' + this.location.pathname + '"]').addClass('active')

function toggleVideo () {
	var myVideo = $('#video-home').get(0)
	if (myVideo.paused) {
		myVideo.play()
		$('.home-pause-button').html('<i class="fa fa-pause"></i>')
		setTimeout(toggleVideo, 90*1000)
	} else {
		myVideo.pause()
		$('.home-pause-button').html('<i class="fa fa-play"></i>')
	}

}
$('.home-pause-button').click(toggleVideo)
setTimeout(toggleVideo, 90*1000)

}); // end jQuery