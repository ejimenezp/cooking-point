window.$ = window.jQuery = require('jquery')

function toggleVideo () {
  var myVideo = $('#video-home').get(0)
  if (myVideo !== undefined) {
    if (myVideo.paused) {
      myVideo.play()
      $('.home-pause-button').html('<i class="fa fa-pause"></i>')
      setTimeout(toggleVideo, 90 * 1000)
    } else {
      myVideo.pause()
      $('.home-pause-button').html('<i class="fa fa-play"></i>')
    }
  }
}

//
//
// jQuery main function
//
//

$(document).ready(function () {
  $('#section-banner').find('img:first').remove()
  if (!/iPhone/i.test(navigator.userAgent) && $(window).width() >= 768) {
    var hgt = $(window).width() / 720 * 100
    $('#section-banner').prepend(' \
      <div style="height: ' + hgt + 'px; overflow: hidden;"> \
			<video id="video-home" poster="/images/home-banner.jpg" autoplay playsinline muted > \
	     	<source src="images/home-video-banner-01.mp4" type="video/mp4"> \
	   	 </video> \
       </div>')

    var videoList = ['images/home-video-banner-01.mp4', 'images/home-video-banner-02.mp4', 'images/home-video-banner-03.mp4', 'images/home-video-banner-04.mp4']
    var curVideo = 0
    var myVideo = $('#video-home').get(0)

    myVideo.onended = function () {
      curVideo++
		    if (curVideo < videoList.length) {
		        myVideo.src = videoList[curVideo]
		    } else {
		    	curVideo = 0
		        myVideo.src = videoList[curVideo]
		    }
    }
    // workaround to force autoplay on Safari browsers (iPad)
    if (/Safari/i.test(navigator.userAgent)) {
      setTimeout(function () { myVideo.play() }, 50)
    }
  }
}) // end jQuery

$('#section-banner').click(toggleVideo)
setTimeout(toggleVideo, 90 * 1000)
