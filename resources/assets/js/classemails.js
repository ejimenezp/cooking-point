window.$ = window.jQuery = require('jquery')
var url = require('url')
var moment = require('moment')

var calendarevent
var response
var current_url = window.location.href
var parts = url.parse(current_url, true)
var edit_button, action, aclass


//
// Function: populateBookingTable
// display a table retrieved from the server
//
function populateBookingTable() {
	$("#classemails_table > tbody").empty()	
	for (var j = 0; j < calendarevent.bookings.length; j++) {

		if (calendarevent.bookings[j].status_filter != 'REGISTERED') {
			continue
		}
		if (calendarevent.bookings[j].email.length > 0) {
			action = 'Edit e-mail'
			aclass = 'btn-link'
		} else {
			action = 'Add e-mail'
			aclass = 'btn-light'			
		}
		edit_button = '<td><button class="btn ' + aclass + ' button_email_edit" data-j="' + j +'">'+ action +'</button></td>'

		$('#classemails_table > tbody:last').append(
			'<tr><td>'+ 
			calendarevent.bookings[j].adult +
			((calendarevent.bookings[j].child > 0) ? (' + ' + calendarevent.bookings[j].child) : '') +
			'</td><td>' + 
			calendarevent.bookings[j].name +
			'</td><td class="booking_email" >' + 
			calendarevent.bookings[j].email +
			'</td>' + 
			edit_button +
			'</tr>');
	}
}

jQuery(document).ready(function($) {

	//
	// load calendar event info
	//
	response = $.ajax({
	    type: 'GET', 
	    url: '/api/calendarevent/find/' + parts.query.ce_id,
	   	dataType: 'json',
	    async: false,
	    success: function(msg){
	    	if (msg.status == 'fail') {
	    		alert('Error al acceder al calendario')
	    	}
	     }
	}).responseText
	calendarevent = JSON.parse(response).data


	// 
	// set bookings table title
	// 
	$('.dateshown').html(moment(calendarevent.date).format('dddd, D MMMM YYYY'))
	var clase = calendarevent.time.substring(0,5) + '&nbsp;&nbsp;&nbsp;' + calendarevent.short_description
	$('.classshown').html(clase)


	// 
	// populate bookings table
	// 
	populateBookingTable()


	//
	// event handling
	//

	$(document).on('click', '.button_email_edit', function (e) {
		e.preventDefault()
		var j = $(this).data('j')
		var email = $('tr:nth-child('+ (j+1) + ') td:nth-child(3)').html()

		if ($(this).html() != 'Confirm') {
			var email_tab = $('<input name="edited" type="text" />')
			email_tab.val(email)
			$('tr:nth-child('+ (j+1) + ') td:nth-child(3)').html(email_tab)
			email_tab.focus()
			$(this).removeClass('btn-link').removeClass('btn-light').addClass('btn-primary')
			$(this).html('Confirm')			
		} else {
			email = $('input[name=edited]').val()
			console.log(email)
		    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
		    if (email != "" && !filter.test(email)) {
				alert('Please, add a valid address, or leave it empty')	
				return
		    }
		    calendarevent.bookings[j].email = email
			$.ajax({
			    type: 'POST', 
			    url: '/api/booking/update',
			   	data: calendarevent.bookings[j],
			   	dataType: 'json',
			    async: false,
			    success: function(msg) {
			    	if (msg.status == 'ok') {
			    		populateBookingTable()
			    	} else {
						alert('Update failed, please try again')
					}
				}
			})
		}
	})

})
