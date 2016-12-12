window.$ = window.jQuery = require('jquery')
require('jquery-ui/ui/widgets/datepicker')
require('bootstrap-sass');
require('jquery-serializejson')
require('printThis');


var moment = require('moment')

//
// Global variables
//
// var right_now = moment("2016-12-15 09:00")
var right_now = moment()
var date_shown = right_now.clone()
var form_changed = false
var month_changed = false
var month_availability = Array()
var ce_i = 0 // index of ce within month_availability
var bkg = null
var locator = null
var tpv_result = null


//
// Initialization
//
// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });


/////////////////////////////////////////////////////////////////////
//
// F U N C T I O N S
//
///////////////////////////////////////////////////////////////////

//
// Function: getMonthAvailability
// Datepicker's beforeShowDay function
//
function getDayAvailability(day)
{
	var type_shown = $("select[name=type]").val()
	var adult = parseInt($("select[name=adult]").val())
	var child = parseInt($("select[name=child]").val())
	var a_day = moment(day)
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

	if (to_return) {
		if (!to_return[0]) {
			return to_return
		} else if (start.clone().subtract(2, 'hours').isSameOrBefore(right_now)) {
			return [false, '', 'Admission Closed']			
		} else if (class_type == 'TAPAS' && start.clone().subtract(8, 'hours').isSameOrBefore(right_now) && registered == 0) {
			return [false, '', 'Admission Closed']			
		} else if (class_type == 'PAELLA' && start.clone().subtract(11, 'hours').isSameOrBefore(right_now) && registered == 0) {
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
	var response = $.ajax({
	    type: 'POST', 
	    url: '/api/calendarevent/getavailability',
	   	data: {start: month_start, end: month_end, bookable_only: 0},
	   	dataType: 'json',
	    async: false,
	    success: function(msg){
	    	if (msg.status == 'fail') {
	    		alert('Error al acceder al calendario')
	    	}
	     }
		}).responseText
	var avail = JSON.parse(response).data
	return avail
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
			   	dataType: 'json',
			    async: false,
			    success: function(msg) {
			    	if (msg.status == 'ok') {
			    		window.location.href = "/pay/" + msg.data.id
			    	}
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
  	var type_shown = $("select[name=type]").val()
	for (i = 0; i < month_availability.length; i++) {
		a = moment(month_availability[i].date + ' ' + month_availability[i].time)
		if (month_availability[i].type == type_shown && a.isAfter(date_shown)) { 
			break
		}
	}
	if (i > month_availability.length) {
		i = month_availability.length
	}
	var ce_i = i
	$("input[name=calendarevent_id]").val(month_availability[ce_i].id)
	$('.dateshown').html(date_shown.format('dddd, D MMMM YYYY'))
	var start_time = moment(month_availability[ce_i].time, "HH:mm:ss")
	var duration = moment.duration(month_availability[ce_i].duration, "HH:mm:ss")
	var end_time = moment(month_availability[ce_i].time, "HH:mm:ss").add(duration)
	$('.timeshown').html(start_time.format('h:mm A') + " - " + end_time.format('h:mm A'))

	$(".typeshown").html($("select[name=type] :selected").text())
	$(".statusshown").html($("input[name=status]").val())
	$(".adultshown").html($("select[name=adult]").val())
	$(".childshown").html($("select[name=child]").val())
	$(".priceshown").html($("input[name=price]").val())
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
	$("select[name=type]").val(bkg.type)
	$("select option[value='"+bkg.type+"']").attr("selected","selected");
	$("input[name=calendarevent_id]").val(bkg.calendarevent_id)
	$("input[name=id]").val(bkg.id)
	$("select[name=status]").val(bkg.status)
	$("input[name=name]").val(bkg.name)
	$("input[name=email]").val(bkg.email)
	$("input[name=phone]").val(bkg.phone)
	$('select[name=adult]').val(bkg.adult)
	$("select[name=child]").val(bkg.child)
	$("input[name=price]").val(bkg.price)
	$("input[name=iva]").val(bkg.iva)
	$("textarea[name=food_requirements]").val(bkg.food_requirements)
	$("textarea[name=comments]").val(bkg.comments)
	$("input[name=locator]").val(bkg.locator)
	$("input[name=crm]").val(bkg.crm)

	var start_time = moment(bkg.calendarevent.time, "HH:mm:ss")
	var duration = moment.duration(bkg.calendarevent.duration, "HH:mm:ss")
	var end_time = moment(bkg.calendarevent.time, "HH:mm:ss").add(duration)

	$('.dateshown').html(date_shown.format('dddd, D MMMM YYYY'))
	$('.timeshown').html(start_time.format('h:mm A') + " - " + end_time.format('h:mm A'))

	form_changed = false
	$(".update_class").addClass('hidden')
	$(".update_contact").addClass('hidden')
	return bkg
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
		$(new_modal_id).find('.btn-cancel').removeClass('hidden')
	} else {
		$(new_modal_id).find('.btn-cancel').addClass('hidden')		
	}
	$(new_modal_id).find('.btn-ok').unbind('click').click(action)
	$(new_modal_id).modal('show')
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
	    	$(".update").addClass('hidden')

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
		$('.modal_booking_title').html(modal_title)
		$('.modal_booking_body').html(modal_body)
		$('#modal_booking').modal('show')
		return false	
    }
    return true
		    			    		
}

//
// Begin jquery(document).ready
//

jQuery(document).ready(function($) {

	//
	// initial display
	//

	$('.loading').show()

	window.history.pushState(null, 'nada', '/booking')

	locator = $("input[name=locator]").val()
	if (locator != '') {
		retrieveBooking(locator)
	}
	month_availability = getMonthAvailability(date_shown)

	refreshDataShown()

    $('#booking_steps > div').addClass('hidden')
    if (bkg) {
    	if (bkg.status != 'PENDING') {
		    $('#step4').removeClass('hidden')
		   	document.title =  $(".typeshown").html() + " for " + $(".nameshown").html() + " on " + $(".dateshown").html()
		    $('select[name=adult] option:selected').siblings().attr('disabled','disabled')
		    $('select[name=child] option:selected').siblings().attr('disabled','disabled')
    	} else {
	 	    $('#step2').removeClass('hidden')    	   		
    	}
    } else {
	    $('#step1').removeClass('hidden')    	
    }

    switch ($("#step4").data('tpv_result')) {
    	case 'OK':
    		$('.modal_booking_title').html('Check your email')
			$('.modal_booking_body').html('We have sent a confirmation email to <span class="primary-color">' + $('.emailshown').html() + '</span><br/><br/>Please check your inbox to make sure you receive our mails. If you can\'t see it, please check also the spam folder. You can modify your e-mail address anytime')
    		$("#modal_booking").modal('show')
    		break
    	case 'KO':
    		$('.modal_booking_title').html('Payment Failure')
			$('.modal_booking_body').html('It seems you could not complete the transaction. Please, try it again')
    		$("#modal_booking").modal('show')
    }

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
 	  		$(".update_class").removeClass('hidden')

 	 	},
 	  	onChangeMonthYear: function(year, month, inst){
 	  		var new_date = moment({y:year, M:month-1, d:1})
 	  		month_availability = getMonthAvailability(new_date)
 	  	}
	});

	$('#bookingdatepicker').datepicker("setDate", date_shown.toDate())

	$('.loading').hide()

	// 
    // end initial display
    //

	//
    // event-driven actions
    //
	$("select[name=adult], select[name=child], select[name=type]").change(function() {

    	$("input[name=price]").val($("select[name=adult]").val()*70 + $("select[name=child]").val()*35)
    	refreshDataShown()
    	form_changed = true
		$('.update_class').removeClass('hidden')

	    if (!getDayAvailability(date_shown.toDate())[0]) {
	    	console.log(date_shown.toDate())
    		$('.modal_booking_title').html('Class Not Available')
			$('.modal_booking_body').html('Please, Select a Date with Availability')
    		$("#modal_booking").modal('show')
    	}
   	});


	$( "#booking_form_2 :input, #booking_form_3 :input" )
	  .keypress(function () {
	    form_changed = true
	    $(".update_contact").removeClass('hidden')
	})

	$('.step').click(function (e) {
        e.preventDefault();
        $('#booking_steps > div').addClass('hidden')
        $($(this).attr('href')).removeClass('hidden')
    })

    $(".cancel").click(function() {
    	retrieveBooking($("input[name=locator]").val())
    	refreshDataShown()
	})

    $(".update_contact").click(function(e) {
		updateBooking()
		retrieveBooking($("input[name=locator]").val())
		refreshDataShown()
		$('#booking_steps > div').addClass('hidden')
    	$($(this).attr('href')).removeClass('hidden')
	})

    $("#button_booking_help").click(function() {
		$('#modal_booking_help').modal('show')
	})

    $(".booking_retrieve").click(function() {
		$('#modal_booking_retrieve').modal('show')
	})

    $(".update_class").click(function(e) {
    	if (!getDayAvailability(date_shown.toDate())[0]) {
    		$('.modal_booking_title').html('Not Available')
			$('.modal_booking_body').html('Please, Select a Date with Availability')
    		$("#modal_booking").modal('show')
		} else if ($(this).attr('checkout')) {
			$('#booking_steps > div').addClass('hidden')
	    	$($(this).attr('href')).removeClass('hidden')
		} else { 				// booking already exist, and probably paid
			updateBooking()
			retrieveBooking($("input[name=locator]").val())
			refreshDataShown()
			$('#booking_steps > div').addClass('hidden')
	    	$($(this).attr('href')).removeClass('hidden')
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
	  		'Confirm you want to clear the booking form',
	  		true,
	        function() { 
	    		window.location.href = '/booking/forget'
			})
	})

    $("#button_booking_edit").click(function() {
		$('#modal_booking_edit').modal('show')
	})

    $('#booking_cancel').click(function() {
    	var start
    	var bkg = retrieveBooking(locator)
    	start = moment(bkg.calendarevent.date + ' ' + bkg.calendarevent.time)
    	// console.log(start)
		if (start.subtract(48, 'hours').isSameOrBefore(right_now)) {
    		$('.modal_booking_title').html("Cancellation Late Notice")
			$('.modal_booking_body').html('Your request is within 48 hours before the event, so no refund is made except for major reasons.<br/><br/>Please contact us to should you have any questions.')
    		$("#modal_booking").modal('show')
			return
		}
	    showModalBooking(
	        this,
	        'Cancel Booking',
	  		'Please confirm you really want to cancel your booking and get it refunded.',
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
					'Sorry to hear it. We proceed to proceed with the refund.<br/><br/>We will email you as soon as we do it. It takes a few days to get your money back. Please, be patient.',
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
			'We are about to send your voucher to <span class="primary-color">' + $('.emailshown').html() + '</span><br/><br/>Please check your inbox to make sure you receive our mails. If you can\'t see it, please check also the spam folder. You can modify your e-mail address anytime',
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



}) // jQuery