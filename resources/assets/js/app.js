
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

if( /iPhone/i.test(navigator.userAgent) || $(window).width() <= 768) {
	$("#banner").append('<img id="image-home" src="/images/home-banner-sm.jpg" >')
	if (page !== ''){
		$("#section-banner").append('<img class="banner" src="/images/'+page+'-banner-sm.jpg" >')
	}
} else {
	$("#banner").append('<video id="video-home" autoplay loop> \
	     	<source src="images/small.mp4" type="video/mp4"> \
	   	 </video>')
	if (page !== ''){
		$("#section-banner").append('<img class="banner" src="/images/'+page+'-banner.jpg" >')
	}

}

$('.nav li a[href="' + this.location.pathname + '"]').addClass('active')

$("#image-home").click(function() {
    // show hi-res full screen video
    $('#modal-video').modal('show')
});


$(".home-youtube-button").click(function() {
    $('#modal-video').modal('show')
});

$('#modal-video').on('hidden.bs.modal', function () {
  $('#youtube-video').remove();
  $('.modal-video').append('<div id="youtube-video" class="embed-responsive embed-responsive-16by9"> \
								<iframe src="https://www.youtube.com/embed/LlBZ32RIB_U?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe> \
                    		</div>')
})


}); // end jQuery