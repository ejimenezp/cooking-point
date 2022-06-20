require('../bootstrap')
const $ = require('jquery')

//
// token protection
//
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
})

// to display pulldown menus on smartphones
// 

  $(document).click(function (event) {
    const target = event.target.closest('.menu-strips')
    if (target !== null) {
      document.getElementById('dropdown-content').classList.toggle('dropdown-content-slide-in')
    } else if ($('#dropdown-content').hasClass("dropdown-content-slide-in")) {
      document.getElementById('dropdown-content').classList.toggle('dropdown-content-slide-in')
    }
  })

// to highlight selected menubar option
$('.cp-navbar ul li a[href="' + window.location.pathname + '"]').addClass('active')
