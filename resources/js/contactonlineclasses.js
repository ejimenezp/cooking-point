
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
	var modal_title = 'Error in form'
	var modal_body = ''
	var show_it = false

	if ($("input[name=name]").val() == '') {
		modal_body += 'Write a name.<br/>'
		show_it = true
	}
	if ($("input[name=email]").val() == '') {
		modal_body += 'Enter an e-mail.<br/>'
		show_it = true
	}
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
	var mail = $("input[name=email]").val()
    if (mail != "" && !filter.test(mail))
    {
		modal_body += 'Enter a valid e-mail.<br/>'
		show_it = true		
    }
	if ($("textarea[name=message]").val() == '') {
		modal_body += 'Write a message. Tell us about your preferred day and time. We\'ll do our best to accommodate your requirements.<br/>'
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

	if (email_sent) {
			$('.modal_contactoeventos_title').html('Thank you again');
			$('.modal_contactoeventos_body').html('Be patient. We will contact you within next 24 hours.');
			$('#modal_contactoeventos').modal('show');	
		return false;
	}

	if (!validateContactoForm()) {
		return false;
	}

	var request = new Object();

	request.name = $('input[name=name]').val();
	request.email = $('input[name=email]').val();
	request.message = $('textarea[name=message]').val();

	$.ajax({
		type: 'POST', 
		url: '/api/contact/contactonlineclasses',
		data: request,
		success: function() {
			$('.modal_contactoeventos_title').html('Inquiry Received');
			$('.modal_contactoeventos_body').html('Thanks for your interest. We will contact you within next 24 hours.');
			$('#modal_contactoeventos').modal('show');
			email_sent = true;
			// GTM dataLayer to track conversion
			window.dataLayer = window.dataLayer || [];
			window.dataLayer.push({
				'event': 'Solicitar info actividades empresas',
			});
		},
		error: function(jqXHR, textStatus, errorThrown ) {
			$('.modal_contactoeventos_title').html('Oops!')
			$('.modal_contactoeventos_body').html(jqXHR.responseJSON + '<br/>')
			$('#modal_contactoeventos').modal('show')
		}
	});

});


}); // end jQuery
