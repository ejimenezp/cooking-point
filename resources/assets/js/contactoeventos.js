window.$ = window.jQuery = require('jquery')
require('bootstrap-sass');

//
// Function: showModalBooking
// helper function to streamline modal showing and subsequent actions
// (copied from bookings.js)
//
function showModalBooking(tthis, title, body, show_cancel, action) {
	var new_modal = 'modal_contactoeventos_' + tthis.id
	var new_modal_id = '#' + new_modal

	$(new_modal_id).remove()
	$('#modal_contactoeventos').clone().attr('id', new_modal).insertAfter('#modal_contactoeventos')

	$(new_modal_id).find('.modal_contactoeventos_title').html(title)
	$(new_modal_id).find('.modal_contactoeventos_body').html(body)
	if (show_cancel) {
		$(new_modal_id).find('.btn-cancel').removeClass('hidden')
	} else {
		$(new_modal_id).find('.btn-cancel').addClass('hidden')		
	}
	$(new_modal_id).find('.btn-ok').unbind('click').click(action)
	$(new_modal_id).modal('show')
}


//
// Function: validateContactoForm
// validates input fields and returns accordingly
// (copied from booking.js)
//
function validateContactoForm()
{
	var modal_title = 'Error en el formulario'
	var modal_body = ''
	var show_it = false

	if ($("textarea[name=message]").val() == '') {
		modal_body += 'Rellena tu nombre. Lo usaremos para dirigirnos a ti.<br/>'
		show_it = true
	}
	if ($("input[name=email]").val() == '') {
		modal_body += 'Rellena tu e-mail. Escribe uno válido.<br/>'
		show_it = true
	}
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
	var mail = $("input[name=email]").val()
    if (mail != "" && !filter.test(mail))
    {
		modal_body += 'Escribe un e-mail válido.<br/>'
		show_it = true		
    }
	if ($("textarea[name=message]").val() == '') {
		modal_body += 'Escribe un mensaje. Dinos algo sobre el evento que quieres organizar.<br/>'
		show_it = true
	}

    if (show_it) {
		$('.modal_contactoeventos_title').html(modal_title)
		$('.modal_contactoeventos_body').html(modal_body)
		$('#modal_contactoeventos').modal('show')
		return false	
    }
    return true
		    			    		
}

$( document ).ready(function() {

$('#button_contacto_form').click(function() {

	if (!validateContactoForm()) {
		return false;
	}

	var response = $.ajax({
	    type: 'POST', 
	    url: '/api/contact/contactoeventos',
	   	data: $("#form_contactoeventos").serialize(),
	   	dataType: 'json',
	    async: false,			    			    					    	
	}).responseText

	if (response == 'ok'){
		showModalBooking(
	    	this,
			'Solicitud Recibida',
			'Gracias por contactarnos. En breve recibirás noticias nuestras.',
			false,
    		function() { window.location.href = '/eventos-privados-madrid' }
    	)
	} else {
		showModalBooking(
	    	this,
			'Ups! ',
			'Parece que hay problemas. Por favor, envíanos un correo a info@cookingpoint.es',
			false,
    		function() { }
    	)				
	}

})


}); // end jQuery
