window.$ = window.jQuery = require('jquery');
require('jquery-ui/ui/widgets/datepicker');
// require('jquery-serializejson')
require('print-this');



var moment = require('moment')

//
// Global variables
//
var date_shown = null
var form_changed = false
var month_changed = false
var month_availability = Array()
var ce_i = 0 // index of ce within month_availability
var bkg = null
var locator = null
var tpv_result = null




/////////////////////////////////////////////////////////////////////
//
// F U N C T I O N S
//
///////////////////////////////////////////////////////////////////

//
// Function: getDayAvailability
// Datepicker's beforeShowDay function
//
function getDayAvailability(day)
{
	var type_shown = $("select[name=type]").val()
	var adult = parseInt($("select[name=adult]").val())
	var child = parseInt($("select[name=child]").val())
	var a_day = moment(day)
	var right_now = rightNow()
	var i, registered, capacity, n, class_type, start
	var to_return = null

	for (i = 0; i < month_availability.length; i++) {
		registered = parseInt(month_availability[i].registered)
		capacity = parseInt(month_availability[i].capacity)
		class_type = month_availability[i].type
		start = moment(month_availability[i].date + ' ' + month_availability[i].time)
		n = registered + adult + child

		if (a_day.isSame(start,'day') && start.isSameOrAfter(right_now) && class_type == type_shown) {
			if (registered >= capacity) {
				to_return = [false, '', 'Class Full']
				break				
			} else if (n > capacity) {
				to_return = [false, '', 'Not Enough Room']
				break
			} else if (n > 8) {
				to_return = [true, 'day-last-seats', 'Last Seats']
				break
			} else {
				to_return = [true, 'day-available', 'Available'] 
				break
			}
		}
	}

	if (bkg && bkg.type === 'GROUP') {
		to_return = [true, 'day-available', 'Private Class']				
	}

	if (to_return) {
		if (!to_return[0]) {
			return to_return
		} else if (start.clone().subtract(2, 'hours').isSameOrBefore(right_now)) {
			return [false, '', 'Admission Closed']			
		} else if (class_type == 'TAPAS' && start.clone().subtract(8, 'hours').isSameOrBefore(right_now) && registered == 0) {
			return [false, '', 'Admission Closed']			
		} else if (class_type == 'PAELLA' && start.clone().subtract(12, 'hours').isSameOrBefore(right_now) && registered == 0) {
			return [false, '', 'Admission Closed']			
		} else if (start.clone().subtract(24, 'hours').isSameOrBefore(right_now) && (adult+child) == 1 && registered == 0) {
			return [false, '', 'Admission Closed']			
		} else {
			return to_return
		}
	} else {
		return [false, '', 'No Class']			
	}
}
//
// Function: getMonthAvailability
// retrieve events for the full month of a date (moment)
//
function getMonthAvailability(a_date)
{
	// clone aDate to avoid side-efects
	var local_date = moment(JSON.parse(JSON.stringify(a_date)))

	var month_start = local_date.clone().startOf('month').format('YYYY-MM-DD')
	var month_end = local_date.clone().endOf('month').format('YYYY-MM-DD')
	
	$.ajax({
	    type: 'POST', 
	    url: '/api/calendarevent/getavailability',
	   	data: {start: month_start, end: month_end, bookable_only: 0},
	   	async: false,
	    success: function(data){
	    	var clear = data.replace(/x06/g, '5');
	    	month_availability = JSON.parse(atob(clear));
	    	// month_availability = JSON.parse(JSON.stringify(data));
	    	refreshDataShown()
	     }
		});
}

//
// Function: getParameterByName
// access date in querystring
//
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}


//
// Function: purchase
// add and/or check booking status and display accordingly
//
function purchase() {

	if (!bkg) {
			$.ajax({
			    type: 'POST', 
			    url: '/api/booking/add',
			   	data: $("#booking_form_1").serialize() + '&' + $("#booking_form_2").serialize() + '&' + $("#booking_form_3").serialize(), 

			    success: function(data) {
		    		$("input[name=locator]").val(data.locator);
		    		window.location.href = "/pay/" + data.id
				}
			})   	
	} else if (form_changed) {
		updateBooking()
		window.location.href = "/pay/" + bkg.id
	} else {
		window.location.href = "/pay/" + bkg.id
	}
}

//
// Function: refreshDataShown
// update all fields displayed on screen based on input form and/or booking fields
// require month_availability[] updated with date_shown's month
//
function refreshDataShown()
{
  	var a, i
  	var found = false
  	var type_shown = $("select[name=type]").val()
	
	// if there is a locator, if looks up calendarevent data by its ce_id, instead of by date and time)
  // 	if (bkg) {
  // 		console.log("primer bucle")
	 // 	for (i = 0; i < month_availability.length; i++) {
	 // 		console.log(i)
		// 	if (month_availability[i].type == type_shown && month_availability[i].id == bkg.calendarevent_id) { 
		// 		console.log('found!')
		// 		console.log(bkg.calendarevent_id)
		// 		found = true
		// 		break
		// 	}
		// } 		
  // 	}
	if (!found) {
		for (i = 0; i < month_availability.length; i++) {
			a = moment(month_availability[i].date + ' ' + month_availability[i].time)
			if (month_availability[i].type == type_shown && a.isAfter(date_shown)) { 
				break
			}
		}
	}
	if (i == month_availability.length) {
		i = month_availability.length - 1
	}
	var ce_i = i
	$("input[name=calendarevent_id]").val(month_availability[ce_i].id)
	$('.dateshown').html(date_shown.format('dddd, D MMMM YYYY'))
	var start_time = moment(month_availability[ce_i].time, "HH:mm:ss")
	var duration = moment.duration(month_availability[ce_i].duration, "HH:mm:ss")
	var end_time = moment(month_availability[ce_i].time, "HH:mm:ss").add(duration)
	$('.timeshown').html(start_time.format('h:mm A') + " - " + end_time.format('h:mm A'))

	$(".typeshown").html(month_availability[ce_i].short_description)
	$(".statusshown").html($("input[name=status]").val())
	$(".adultshown").html($("select[name=adult]").val())
	$(".childshown").html($("select[name=child]").val())

	if ( $("input[name=status_filter]").val() == 'REGISTERED') {
		if (parseInt($("input[name=hide_price]").val())) {
			$(".priceshown").html('--.--')
		} else {
			$(".priceshown").html($("input[name=price]").val())	
		}	
	} else {
		$(".priceshown").html($("input[name=price]").val())				
	}
	$(".nameshown").html($("input[name=name]").val())
	$(".emailshown").html($("input[name=email]").val())
	$(".phoneshown").html($("input[name=phone]").val())
	$(".foodshown").html($("textarea[name=food_requirements]").val())
	$(".commentsshown").html($("textarea[name=comments]").val())
	$(".locatorshown").html($("input[name=locator]").val())

	$("#bookingdatepicker").datepicker("refresh")
}

//
// Function: retrieveBooking
// retrieve booking data from a locator
//
function retrieveBooking(locator) {
	var response = $.ajax({
    type: 'POST', 
    url: '/api/booking/findByLocator',
   	data: {locator: locator},
   	dataType: 'json',
    async: false,
    success: function(msg){
    	if (msg.status == 'fail') {
    		bkg = null
    	}
    }
	}).responseText
	bkg = JSON.parse(response).data
	date_shown = moment(bkg.date)
	$("#bookingdatepicker").datepicker("setDate", bkg.date)
	if (bkg.type === 'GROUP') {
		$("select[name=type]:last").append('<option value="GROUP">Private Group Event</option>')
	}
	$("select[name=type]").val(bkg.type)
	$("select option[value='"+bkg.type+"']").attr("selected","selected");
	$("input[name=calendarevent_id]").val(bkg.calendarevent_id)
	$("input[name=id]").val(bkg.id)
	$("select[name=status]").val(bkg.status)
	$("input[name=status_filter]").val(bkg.status_filter)
	$("input[name=name]").val(bkg.name)
	$("input[name=email]").val(bkg.email)
	$("input[name=phone]").val(bkg.phone)
	$('select[name=adult]').val(bkg.adult)
	$("select[name=child]").val(bkg.child)
	$("input[name=price]").val(bkg.price)
	$("input[name=iva]").val(bkg.iva)
	$("input[name=hide_price]").val(bkg.hide_price)
	$("textarea[name=food_requirements]").val(bkg.food_requirements)
	$("textarea[name=comments]").val(bkg.comments)
	$("input[name=locator]").val(bkg.locator)
	$("input[name=crm]").val(bkg.crm)
	$("input[name=source_id]").val(bkg.source_id)
	$("input[name=pay_method]").val(bkg.pay_method)
	$("input[name=payment_date]").val(bkg.payment_date)
	$("input[name=hide_price]").val(bkg.hide_price)
	$("input[name=fixed_date]").val(bkg.fixed_date)
	$("input[name=invoice]").val(bkg.invoice)

	var start_time = moment(bkg.calendarevent.time, "HH:mm:ss")
	var duration = moment.duration(bkg.calendarevent.duration, "HH:mm:ss")
	var end_time = moment(bkg.calendarevent.time, "HH:mm:ss").add(duration)

	$('.dateshown').html(date_shown.format('dddd, D MMMM YYYY'))
	$('.timeshown').html(start_time.format('h:mm A') + " - " + end_time.format('h:mm A'))

	form_changed = false
	$(".update_class").addClass('d-none')
	$(".update_contact").addClass('d-none')
	return bkg
}

//
// Function: rightNow
// fresh datetime everytime the time is required
//
// var fake_now = prompt("entrar fecha", "2018-03-14 22:01:00")

function rightNow()
{
	// return moment(fake_now)
	return moment()
}

//
// Function: showModalBooking
// helper function to streamline modal showing and subsequent actions
//
function showModalBooking(tthis, title, body, show_cancel, action) {
	var new_modal = 'modal_booking_' + tthis.id
	var new_modal_id = '#' + new_modal

	$(new_modal_id).remove()
	$('#modal_booking').clone().attr('id', new_modal).insertAfter('#modal_booking')

	$(new_modal_id).find('.modal_booking_title').html(title)
	$(new_modal_id).find('.modal_booking_body').html(body)
	if (show_cancel) {
		$(new_modal_id).find('.btn-cancel').removeClass('d-none')
	} else {
		$(new_modal_id).find('.btn-cancel').addClass('d-none')		
	}
	$(new_modal_id).find('.btn-ok').unbind('click').click(action)
	$(new_modal_id).modal()
}


//
// Function: update
// update booking on server with updated form fields
//
function updateBooking() {
	$.ajax({
	    type: 'POST', 
	    url: '/api/booking/update',
	   	data: $("#booking_form_1").serialize() + '&' + $("#booking_form_2").serialize() + '&' + $("#booking_form_3").serialize(), 
	   	dataType: 'json',
	    async: false,
	    success: function(msg) {
	    	form_changed = false
	    	$(".update").addClass('d-none')

	    }
	})   	
}

//
// Function: validateBookingForm
// validates input fields and returns accordingly
//
function validateBookingForm()
{
	var modal_title = 'Form Validation Error'
	var modal_body = ''
	var show_it = false
	if ($("input[name=name]").val() == '') {
		modal_body += 'Enter a name<br/>'
		show_it = true
	}
	if ($("input[name=email]").val() == '') {
		modal_body += 'Enter an e-mail<br/>'
		show_it = true
	}
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
	var mail = $("input[name=email]").val()
    if (mail != "" && !filter.test(mail))
    {
		modal_body += 'Enter a valid e-mail<br/>'
		show_it = true		
    }
	filter = /^[0-9 \(\)\-\+]+$/ 
	var phone = $("input[name=phone]").val()
    if (phone != "" && !filter.test(phone)) {
		modal_body += 'Enter a valid phone number<br/>'
		show_it = true
    }
    if (show_it) {
    	modal_body += '<br/>Remember you can modify guest details at anytime using your Booking #.'
		$('.modal_booking_title').html(modal_title)
		$('.modal_booking_body').html(modal_body)
		$('#modal_booking').modal()
		return false	
    }
    return true
		    			    		
}

	//
	// initial display
	//


	date_shown = getParameterByName('date') ? moment(getParameterByName('date')) : rightNow().clone();
	// window.history.pushState(null, 'nada', '/booking')

	locator = $("input[name=locator]").val();
	if (locator != '') {
		retrieveBooking(locator);
	}
	getMonthAvailability(date_shown);

//
// Booking Datepicker
//
$( "#bookingdatepicker" ).datepicker({
	minDate: 0,
	beforeShowDay: getDayAvailability,
	  	dateFormat: 'yy-mm-dd',
	  	onSelect: function( s, i ) {  
	  		date_shown = moment($(this).val())
	  		refreshDataShown()
	  		form_changed = true
	  		$(".update_class").removeClass('d-none')

	 	},
	  	onChangeMonthYear: function(year, month, inst){
	  		var new_date = moment({y:year, M:month-1, d:1})
	  		getMonthAvailability(new_date)
	  	}
});

$('#bookingdatepicker').datepicker("setDate", date_shown.toDate())

//
// Begin jquery(document).ready
//

jQuery(document).ready(function($) {


    $('#booking_steps > div').addClass('d-none')
    if (bkg) {
    	if (bkg.status != 'PENDING') {
		    $('#step4').removeClass('d-none')
		   	document.title =  $(".typeshown").html() + " for " + $(".nameshown").html() + " on " + $(".dateshown").html()
		    $('select[name=adult] option:selected').siblings().attr('disabled','disabled')
		    $('select[name=child] option:selected').siblings().attr('disabled','disabled')
		    var start = moment(bkg.calendarevent.date + ' ' + bkg.calendarevent.time)
			if (start.isSameOrBefore(rightNow())) {
	    		$("#button_booking_edit").addClass('d-none')	
	    	}
    	} else {
	 		if (!getDayAvailability(bkg.date)[0]) {
	    		$('.modal_booking_title').html('Class no longer available')
				$('.modal_booking_body').html('Please, select a date with availability')
	    		$("#modal_booking").modal()
		 	    $('#step1').removeClass('d-none')
	 		} else {
		 	    $('#step2').removeClass('d-none')
	 		}
    	}
    } else {
	    $('#step1').removeClass('d-none')    	
    }

    switch ($("#step4").data('tpv_result')) {
    	case 'OK':
    		$('.modal_booking_title').html('Thank you for booking a class with us!')
			$('.modal_booking_body').html('We have sent a confirmation email to <span class="primary-color">' + $('.emailshown').html() + '</span><br/><br/>Please check your inbox to make sure you receive our mails. If you can\'t find them, please check also the spam folder. You can modify your e-mail address anytime')
    		$("#modal_booking").modal()
    		break
    	case 'KO':
    		$('.modal_booking_title').html('Payment Failure')
			$('.modal_booking_body').html('It seems you could not complete the transaction. Please, try it again')
    		$("#modal_booking").modal()
    }


}) // jQuery

	// 
    // end initial display
    //

//
// this is apparently needed to force reload the booking page on mobile Safari 
// when the back button is clicked
//
$(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        window.location.reload() 
    }
});


	//
    // event-driven actions
    //
	$("select[name=adult], select[name=child], select[name=type]").change(function() {

    	$("input[name=price]").val($("select[name=adult]").val()*70 + $("select[name=child]").val()*35)
    	refreshDataShown()
    	form_changed = true
		$('.update_class').removeClass('d-none')

	    if (!getDayAvailability(date_shown.toDate())[0]) {
    		$('.modal_booking_title').html('Booking Not Available')
			$('.modal_booking_body').html('Please, select a date with availability')
    		$("#modal_booking").modal()
    	}
   	});


	$( "#booking_form_2 :input, #booking_form_3 :input" )
	  .keypress(function () {
	    form_changed = true
	    $(".update_contact").removeClass('d-none')
	})

	$('.step').click(function (e) {
        e.preventDefault();
        $('#booking_steps > div').addClass('d-none')
        $($(this).attr('href')).removeClass('d-none')
    })

    $(".cancel").click(function() {
    	retrieveBooking($("input[name=locator]").val())
    	refreshDataShown()
	})

    $(".update_contact").click(function(e) {
		updateBooking()
		retrieveBooking($("input[name=locator]").val())
		refreshDataShown()
		$('#booking_steps > div').addClass('d-none')
    	$($(this).attr('href')).removeClass('d-none')
	})

    $("#button_booking_help").click(function() {
		$('#modal_booking_help').modal()
	})

    $(".booking_retrieve").click(function() {
		$('#modal_booking_retrieve').modal()
	})

    $(".update_class").click(function(e) {
    	if (!getDayAvailability(date_shown.toDate())[0]) {
    		$('.modal_booking_title').html('Booking Not Available')
			$('.modal_booking_body').html('Please, select a date with availability')
    		$("#modal_booking").modal()
		} else if ($(this).attr('checkout')) {
	    	if (!parseInt($("select[name=adult]").val())) {
	    		$('.modal_booking_title').html('Invalid number of guests')
				$('.modal_booking_body').html('Book for 1 adult at least')
	    		$("#modal_booking").modal()
			} else {
				$('#booking_steps > div').addClass('d-none')
		    	$($(this).attr('href')).removeClass('d-none')
		    }
		} else { 				// booking already exist, and probably paid
			updateBooking()
			retrieveBooking($("input[name=locator]").val())
			refreshDataShown()
			$('#booking_steps > div').addClass('d-none')
	    	$($(this).attr('href')).removeClass('d-none')
		}
	})

    $("#button_purchase").click(function() {
    	if (validateBookingForm()) {
			purchase()
    	}
	})

    $("#button_booking_forget").click(function() {
	    showModalBooking(
	        this,
	        'Clean-up Form',
	  		'Please confirm you want to clear the booking form',
	  		true,
	        function() { 
	    		window.location.href = '/booking/forget'
			})
	})

    $("#button_booking_edit").click(function() {
    	var right_now = rightNow()
    	var start = moment(bkg.calendarevent.date + ' ' + bkg.calendarevent.time)
		if (start.isSameOrBefore(right_now)) {
    		$('.modal_booking_title').html("Past Class")
			$('.modal_booking_body').html('This class has already taken place, no edition is allowed.')
    		$("#modal_booking").modal()	
	    } else if (start.subtract(11, 'hours').isSameOrBefore(right_now)) {
    		$('.modal_booking_title').html("Edition not allowed")
			$('.modal_booking_body').html('Class is too close to start, so no edition allowed.<br/><br/>Please contact us by phone should you have any question.')
    		$("#modal_booking").modal()
		} else {
			$('#modal_booking_edit').modal('show')
		}		
	})

    $("#date_edit").click(function() {
    	var start = moment(bkg.calendarevent.date + ' ' + bkg.calendarevent.time)
		if (start.subtract(24, 'hours').isSameOrBefore(rightNow())) {
    		$('.modal_booking_title').html("Class changes not allowed")
			$('.modal_booking_body').html('Class is too close to change your date or type.<br/><br/>Please contact us by phone should you have any question.')
    		$("#modal_booking").modal()
		} else {
	        $('#booking_steps > div').addClass('d-none')
	        $('#step1').removeClass('d-none')
		}		
	})

    $('#booking_cancel').click(function() {
    	var bkg = retrieveBooking(locator)
    	var start = moment(bkg.calendarevent.date + ' ' + bkg.calendarevent.time)
		if (start.subtract(24, 'hours').isSameOrBefore(rightNow())) {
    		$('.modal_booking_title').html("Cancellation Late Notice")
			$('.modal_booking_body').html('Your request is within 24 hours before the event, so no refund is made except for major reasons.<br/><br/>Please contact us should you have any questions.')
    		$("#modal_booking").modal()
			return
		}
	    showModalBooking(
	        this,
	        'Cancel Booking',
	  		'Please confirm you really want to cancel your booking.',
	  		true,
	        function() { 
				var response = $.ajax({
					type: 'POST', 
					url: '/api/booking/cancelIt',
					data: {locator: locator},
					dataType: 'json'
				})
				showModalBooking(
					this,
					'Booking Cancellation',
					'Sorry to hear you will not be able to attend the class. We will proceed to refund the total amount of your booking.<br/><br/>We will email you as soon as we have made the transfer. Please notice it will take a few days to receive it into your credit card. Thank you for your patience.',
					false,
					function() {}
				)
			}
	    )
	})


    $("#button_print_voucher").click(function() {
    	$('#printer_voucher').empty()
    	$('.step4_voucher').clone().appendTo('#printer_voucher')
		$('#printer').printThis()
	})

    $("#button_email_voucher").click(function() {
    	showModalBooking(
	    	this,
			'Send Voucher',
			'We are about to send your voucher to <span class="primary-color">' + $('.emailshown').html() + '</span><br/><br/>Please check your inbox to make sure you receive our mails. If you can\'t find them, please check also the spam folder. You can modify your e-mail address anytime',
			true,
			function() {
				var response = $.ajax({
			    type: 'POST', 
			    url: '/api/booking/emailIt',
			   	data: {locator: locator},
			   	dataType: 'json',
			    async: false,
			    success: function(msg){
			    	if (msg.status == 'fail') {
			    		bkg = null
			    	} else {
						// alert('email sent')
			    	}
			    }
				}).responseText }
		)
    })



