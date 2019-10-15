
//
// global variable to avoid duplicated emails and conversion report
//
var email_sent = false;


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

	if ($("input[name=name]").val() == '') {
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


// Event snippet for solicitar info para evento españoles conversion page
// In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->

function gtag_report_conversion(url) {
  var callback = function () {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  };
  gtag('event', 'conversion', {
      'send_to': 'AW-985592263/PnCmCNa1-a0BEMfj-9UD',
      'event_callback': callback
  });
  return false;
}


$( document ).ready(function() {

$('#button_contacto_form').click(function() {

	if (!validateContactoForm() || email_sent) {
		return false;
	}

	var request = new Object();

	request.name = $('input[name=name]').val();
	request.email = $('input[name=email]').val();
	request.message = $('textarea[name=message]').val();

	$.ajax({
		type: 'POST', 
		url: '/api/contact/contactoeventos',
		data: request,
		success: function() {
			$('.modal_contactoeventos_title').html('Solicitud recibida');
			$('.modal_contactoeventos_body').html('Gracias por contactarnos. En breve recibirás noticias nuestras.');
			$('#modal_contactoeventos').modal('show');
			email_sent = true;
			gtag_report_conversion('/eventos-privados-madrid');
		},
		error: function(jqXHR, textStatus, errorThrown ) {
			$('.modal_contactoeventos_title').html('Ups!')
			$('.modal_contactoeventos_body').html(jqXHR.responseJSON + '<br/>')
			$('#modal_contactoeventos').modal('show')
		}
	});

});


}); // end jQuery
