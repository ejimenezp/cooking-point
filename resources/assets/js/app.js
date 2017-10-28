
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

if( /iPhone|iPad/i.test(navigator.userAgent) ) {
	$("#banner").append('<img id="image-home" src="/images/cliffs.jpg" >')
} else {
	$("#banner").append('<div class="video-container"> \
	    <video id="video-home" autoplay loop> \
	     	<source src="images/small.mp4" type="video/mp4"> \
	    </video> \
	</div>')
}

$("#image-home").click(function() {
    // show hi-res full screen video
});

$("#close-video").click(function() {
	var player = videojs('hires-video')
	player.dispose()
});

$("#video-home").click(function() {
    this.pause();
    $('#modal-video').modal('show')
});



}); // end jQuery