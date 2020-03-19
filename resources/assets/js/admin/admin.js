require('../bootstrap');

//
// token protection
//
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// to display pulldown menus on smartphones
$('.menu-strips').click(function() {
	$( "#dropdown-content" ).toggle();
});

// to highlight selected menubar option
$('.cp-navbar ul li a[href="' + window.location.pathname + '"]').addClass('active');


