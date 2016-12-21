window.$ = window.jQuery = require('jquery')
require('jquery-ui/ui/widgets/datepicker')
require('bootstrap-sass');
require('jquery-serializejson')

var moment = require('moment')
require('moment/locale/es')
var url = require('url')


//
// Global variables
//
var hoy = moment()
var date_shown = hoy.clone()
var form_changed = false
var cook = Array()
var source = Array()
var bookings = Array()
var month_schedule = Array()
var user_name
var user_role

var stateObj = { foo: "bar" }
var current_url = window.location.href
var parts = url.parse(current_url, true)

//
// token protection
//
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//
// datepicker locale
//
$.datepicker.regional['es'] = {
	closeText: 'Cerrar',
	prevText: '<<',
	nextText: '>>',
	currentText: 'Hoy',
	monthNames: ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	dayNames: ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'],
	dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
	weekHeader: 'Sm',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: '' }

$.datepicker.setDefaults($.datepicker.regional['es'])




/////////////////////////////////////////////////////////////////////
//
// F U N C T I O N S
//
///////////////////////////////////////////////////////////////////

//
// Function: refreshDateShown
// refresh all selectors with the new date's data
//
function refreshDateShown(month_schedule, date_shown) {
	var date_shown_locale = date_shown.format('dddd, D MMMM YYYY')
	$('.dateshown').html(date_shown_locale)	

	// aqui, refrescar el index del día	
	var edit_button
	$("#calendarevent_table > tbody").empty();
	for (var i = 0; i < month_schedule.length; i++) {
		if (user_role >= 3) {
			edit_button = '<td class=""><button class="btn btn-primary btn-xs button_calendarevent_edit" data-i="'
					+ i + '">Detalles</button></td>'
		} else if (user_role >= 2 && month_schedule[i].info != '') {
			edit_button = '<td class=""><button class="btn btn-primary btn-xs button_calendarevent_info" data-i="'
					+ i + '">+info</button></td>'			
		} else {
			edit_button = ''
		}
		var calendarevent_tr_class = (user_role >= 2) ? 'calendarevent_line' : ''

		if (month_schedule[i].date == date_shown.format('YYYY-MM-DD')) {
			$('#calendarevent_table > tbody:last').append(
				'<tr onclick=""><td class="' + calendarevent_tr_class + '" data-i="' + i +'">'+ 
				month_schedule[i].time.substring(0,5) + 
				'<td class="' + calendarevent_tr_class + '" data-i="' + i +'">' + 
				month_schedule[i].type +
				'<td class="' + calendarevent_tr_class + '" data-i="' + i +'">' + 
				cookName(month_schedule[i].staff_id) +
				'<td class="' + calendarevent_tr_class + '" data-i="' + i +'">' + 
				month_schedule[i].registered +
				'</td>' +
				edit_button +
				'</tr>');
		}
	}
}

//
// Function: addSlashes
// escape input fields to prevent sql statements break
//

// function addSlashes(string) {

//     return string.replace(/\\/g, '').
//       replace(/\u0008/g, '\\b').
//        replace(/\t/g, '\\t').
//         replace(/\n/g, '<br\/>').
//         replace(/\f/g, '\\f').
//         replace(/\r/g, '\\r').
//       replace(/'/g, '\\\'').
//        replace(/"/g, '\\"');
// }

//
// Function: bookingEditShow
// populate and show screen to add new or edit 
//
function bookingEditShow(i, j) {

	var url_action
	var booking_date
	var booking_moment

	if (j < 0) {  // nueva reserva
		$('#booking_edit h1').html('Nueva Reserva')
		$('#button_booking_delete').hide()
		$('.dateshown, .classshown').show()
		booking_date = month_schedule[i].date
		booking_moment = moment(booking_date)
		$("input[name=date]").val(booking_date)
		$('.booking_date_input').hide()

		$("input[name=id]").val(0)  // new booking
		$("input[name=calendarevent_id]").val(month_schedule[i].id)
		$("select[name=source_id]").val('3')  // user
		$("select[name=status]").val('GUARANTEE')
		$("input[name=status_filter]").val('REGISTERED')
		$("input[name=name]").val('')
		$("input[name=email]").val('')
		$("input[name=phone]").val('')
		$("input[name=locator]").val('')
		$('select[name=adult]').val(1)
		$("select[name=child]").val(0)
		$("input[name=price]").val($("select[name=adult]").val()*70 + $("select[name=child]").val()*35)
		$("input[name=iva]").prop('checked', 1);
		$("input[name=hide_price]").prop('checked', 0);
		$("select[name=pay_method]").val('N/A')
		$("input[name=payment_date]").val('')
		$("textarea[name=food_requirements]").val('')
		$("textarea[name=info]").val('')
		$("select[name=crm]").val('YES')
		url_action = 'bkg_new'
	} else {
		$("#booking_edit h1").html("Editar Reserva")
		$('#button_booking_delete').show()
		$('.booking_date_input').show()
		$('.dateshown, .classshown').show()
		booking_date = month_schedule[i].date
		booking_moment = moment(booking_date)
		$("#booking_date_edit").val(booking_moment.format('dddd, D MMMM YYYY'))
		$("input[name=date]").val(booking_date)
		populateSelect_dayeventlist()
		$("#dayeventlist").val(bookings[j].calendarevent_id)
		$("input[name=id]").val(bookings[j].id)
		$("input[name=calendarevent_id]").val(bookings[j].calendarevent_id)
		$("select[name=source_id]").val(bookings[j].source_id)
		$("select[name=status]").val(bookings[j].status)
		$("input[name=status_filter]").val(bookings[j].status_filter)
		$("input[name=name]").val(bookings[j].name)
		$("input[name=email]").val(bookings[j].email)
		$("input[name=phone]").val(bookings[j].phone)
		$('select[name=adult]').val(bookings[j].adult)
		$("select[name=child]").val(bookings[j].child)
		$("input[name=price]").val(bookings[j].price)
		$("input[name=iva]").prop('checked', bookings[j].iva)
		$("input[name=hide_price]").prop('checked', bookings[j].hide_price)
		$("select[name=pay_method]").val(bookings[j].pay_method)
		$("input[name=payment_date]").val(bookings[j].payment_date)
		$("textarea[name=food_requirements]").val(bookings[j].food_requirements)
		$("textarea[name=comments]").val(bookings[j].comments)
		$("select[name=crm]").val(bookings[j].crm)
		$("input[name=locator]").val(bookings[j].locator)
		url_action = 'bkg_edit'
	}
	updateUrl(parts, '/admin/booking', moment(booking_date), url_action, i, j)
	showPrice()
	$('#booking_edit').show()
}

//
// Function: calendarEventEditShow
// populate and show calendar event screen to add new or edit 
//
function calendarEventEditShow(month_schedule, date_shown, i) {

	var ce_id
	var url_action

	if (i < 0) {  // nuevo evento
		$('#calendarevent_edit h1').html('Nuevo Evento')
		$('#button_calendarevent_delete').hide()
		ce_id = 0		
		$("input[name=id]").val(ce_id)
		$("input[name=date]").val(date_shown.format('YYYY-MM-DD'))
		$("#eventdatepicker").val(date_shown.format('dddd, D MMMM YYYY'))
		$("select[name=type]").val('GROUP')
		$("input[name=short_description]").val('')
		$("select[name=staff_id]").val(2)  // not assigned yet
		$("select[name=time]").val('10:00:00')
		$("select[name=duration]").val('04:00:00')
		$("input[name=capacity]").val(24)
		$("textarea[name=info]").val('')
		url_action = 'ce_new'
	} else {
		$("#calendarevent_edit h1").html("Editar Evento")
		$('#button_calendarevent_delete').show()
		ce_id = month_schedule[i].id
		$("input[name=id]").val(ce_id)
		$("input[name=date]").val(month_schedule[i].date)
		$("#eventdatepicker").val(date_shown.format('dddd, D MMMM YYYY'))
		$("select[name=type]").val(month_schedule[i].type)
		$("input[name=short_description]").val(month_schedule[i].short_description)
		$("select[name=staff_id]").val(month_schedule[i].staff_id)
		$("select[name=time]").val(month_schedule[i].time)
		$("select[name=duration]").val(month_schedule[i].duration)
		$("input[name=capacity]").val(month_schedule[i].capacity)
		$("input[name=info]").val(month_schedule[i].info)
		url_action = 'ce_edit'
	}
	updateUrl(parts, '/admin/calendarevent', moment($("input[name=date]").val()), url_action, i)
	$('#calendarevent_edit').show()
}

//
// Function: cookName
// return the cook from the cook list retrieved on load 
//
function cookName(id) {
	for (var i = 0; i < cook.length; i++) {
		if (cook[i].id == id) {
			return cook[i].name;
		}
	}
}

//
// Function: getDaySchedule
// retrieve events for a date (string YYYY-MM-DD)
//
function getDaySchedule(a_date)
{
	var response = $.ajax({
	    type: 'POST', 
	    url: '/api/calendarevent/getschedule',
	   	data: {start: a_date, end: a_date, bookable_only: 1},
	   	dataType: 'json',
	    async: false,
	    success: function(msg){
	    	if (msg.status == 'fail') {
	    		alert('Error al acceder al calendario')
	    	}
	     }
	}).responseText
	return JSON.parse(response).data
}

//
// Function: getMonthSchedule
// retrieve events for the full month of a date (moment)
//
function getMonthSchedule(a_date)
{
	// clone aDate to avoid side-efects
	var local_date = (moment) (JSON.parse(JSON.stringify(a_date)))

	var month_start = local_date.startOf('month').format('YYYY-MM-DD')
	var month_end = local_date.endOf('month').format('YYYY-MM-DD')
	var response = $.ajax({
	    type: 'POST', 
	    url: '/api/calendarevent/getschedule',
	   	data: {start: month_start, end: month_end, bookable_only: 0},
	   	dataType: 'json',
	    async: false,
	    success: function(msg){
	    	if (msg.status == 'fail') {
	    		alert('Error al acceder al calendario')
	    	}
	     }
		}).responseText
	return JSON.parse(response).data
}

//
// Function: getEventBookings
// retrieve bookings of an calendarevent
//
function getEventBookings(ce_id)
{
	var response = $.ajax({
    type: 'GET', 
    url: '/api/booking/index/' + ce_id,
   	dataType: 'json',
    async: false,
    success: function(msg){
    	if (msg.status == 'fail') {
    		alert('Error al acceder a las reservas')
    	}
     }
	}).responseText
	return JSON.parse(response).data
}


//
// Function: populateBookingList
// populate booking table with current event's
// param i: index of month_schedule
//
function populateBookingList(i) {

	$("#booking_table").data('i', i)

	var clase = month_schedule[i].time.substring(0,5) + '&nbsp;&nbsp;&nbsp;' + month_schedule[i].type
	 			+ ' (' + cookName(month_schedule[i].staff_id) + ') '
				+ '<span class="pull-right">Confirmados: ' + month_schedule[i].registered +'</span>'
	$('.classshown').html(clase)
	// 
	$("#booking_table > tbody").empty()
	
	for (var j = 0; j < bookings.length; j++) {
		$('#booking_table > tbody:last').append(
			'<tr onclick=""><td class="booking_line" data-j="' + j +'">'+ 
			bookings[j].adult +
			((bookings[j].child > 0) ? (' + ' + bookings[j].child) : '') +
			'<td class="booking_line" data-j="' + j +'">' + 
			bookings[j].name +
			'<td class="booking_line" data-j="' + j +'">' + 
			bookings[j].status +
			'<td class="booking_line" data-j="' + j +'">' + 
			bookings[j].food_requirements.substring(0, 20) +
			'<td class="booking_line" data-j="' + j +'">' + 
			bookings[j].comments.substring(0, 20) +
			'</td></tr>');

	}
}

//
// Function: populateSelect_dayeventlist
// populate #dayeventlist with available events 
//
function populateSelect_dayeventlist(i) {
	var dayEvent = getDaySchedule($('#bookingNewDate').val())
	var select = ''
	$('#dayeventlist').empty()
	for (var ii = 0; ii < dayEvent.length; ii++) {
		select += '<option value="'+ dayEvent[ii].id +'">' + dayEvent[ii].type + '</option>'
	}
	$('#dayeventlist').append(select)
}

//
// Function: sourceName
// return the source from the source list retrieved on load 
//
function sourceName(id) {
	for (var i = 0; i < source.length; i++) {
		if (source[i].id == id) {
			return source[i].name;
		}
	}
}

//
// Function: showPrice
// display price based on roles and status 
//
function showPrice() {
	if (user_role >= 3 || $('select[name=status]').val() == 'GUARANTEE') {
		$('.price').show()
	} else {
		$('.price').hide()
	}
}

//
// Function: updateUrl
// sets new path and querystring according to the screen displayed
//
function updateUrl(parts, path, date, action, month_schedule_i = -1, bookings_j = -1)
{
	if (path) { parts.pathname = path }
	if (date) { parts.query.date = date.format('YYYY-MM-DD') }
	if (action) { parts.query.action = action }
	if (month_schedule_i < 0) { delete parts.query.i } else { parts.query.i = month_schedule_i }
	if (bookings_j < 0) { delete parts.query.j } else { parts.query.j = bookings_j }
	
	delete parts.search
	window.history.pushState(stateObj, 'nada', url.format(parts))
}

//
// Function: validBookingForm
// validates input fields and returns accordingly
//
function validBookingForm()
{
	// 

	var modal_title = 'Error'
	var modal_body = ''
	var show_it = false
	if ($("input[name=name]").val() == '') {
		modal_body += 'Intruduce un nombre<br/>'
		show_it = true
	}
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
	var mail = $("input[name=email]").val()
    if (mail != "" && !filter.test(mail))
    {
		modal_body += 'Introduce un email válido<br/>'
		show_it = true		
    }
	filter = /^[0-9 \(\)\-\+]+$/ 
	var phone = $("input[name=phone]").val()
    if (phone != "" && !filter.test(phone)) {
		modal_body += 'Introduce un teléfono válido<br/>'
		show_it = true
    }
    if (show_it) {
		$('.modal_admin_title').html(modal_title)
		$('.modal_admin_body').html(modal_body)
		$('#modal_admin').modal('show')
		return false	
    }
    return true
		    			    		
}


//
// comienzo del jquery(document).ready
//

jQuery(document).ready(function($) {



	$('.loading').show()
	// $('.loading').hide()
	//
	// initial load
	//
	user_name = $('meta[name=user_name]').attr('content')
	user_role = $('meta[name=user_role]').attr('content')
	var month_changed = false


	//
	// load cook list
	//
	var response = $.ajax({
	    type: 'GET', 
	    url: '/api/staff/get',
	   	dataType: 'json',
	    async: false,
	    success: function(msg){
	    	if (msg.status == 'fail') {
	    		alert('Error al acceder al calendario')
	    	}
	     }
	}).responseText
	cook = JSON.parse(response).data
	var select = ''
	$('#cooklist').empty()
	for (var ii = 0; ii < cook.length; ii++) {
		select += '<option value="'+ cook[ii].id +'">' + cook[ii].name + '</option>'
	}
	$('#cooklist').append(select)

	//
	// load source list
	//
	response = $.ajax({
	    type: 'GET', 
	    url: '/api/source/get',
	   	dataType: 'json',
	    async: false,
	    success: function(msg){
	    	if (msg.status == 'fail') {
	    		alert('Error al acceder a los sources')
	    	}
	     }
	}).responseText
	source = JSON.parse(response).data

	select = ''
	$('#sourcelist').empty()
	for (var ii = 0; ii < source.length; ii++) {
		select += '<option value="'+ source[ii].id +'">' + source[ii].type + ' - ' + source[ii].name + '</option>'
	}
	$('#sourcelist').append(select)

	//
	// set status and pay_method based on source_id
	//
	$('select[name=source_id]').change(function() {
		if ($(this).val() > 3 ) {  // marketplace or agency
			$('select[name=status]').val('CONFIRMED')
			$('select[name=pay_method]').val('N/A')
			$("input[name=hide_price]").prop('checked', 1)
		}
		showPrice()
	})

	//
	// sidebar datepicker
	//
	$( "#admindatepicker" ).datepicker({
 	  	language: 'es',
 	  	dateFormat: 'yy-mm-dd',
 	  	onSelect: function( s, i ) {  
 	  		var new_date = moment($(this).val())
 	  		if (month_changed) {
 	  			month_schedule = getMonthSchedule(new_date)
 	  			month_changed = false }
 	  		date_shown = new_date
 	  		refreshDateShown(month_schedule, new_date)
 	  		if (form_changed) {
 	  			$('#button_calendarevent_close').trigger('click')
 	  		} else {
 	  			updateUrl(parts, '/admin/calendarevent', new_date, 'ce_index', -1)
				$('#calendarevent_index').show()
				$('#calendarevent_edit').hide()
				$('#booking_index').hide()
				$('#booking_edit').hide()
	 	  	}
 	 	},
 	  	onChangeMonthYear: function(year, month, inst){
 	  		month_changed = true }

	});	

	//
	// toggle admindatepicker
	//
	$('#toggle_datepicker').click(function() {
		$('#admindatepicker').toggle()
	})

	//
	// show sections based on url and query string
	//
	if (typeof parts.query.date === "undefined") {
		date_shown = hoy.clone()		
	} else {
		date_shown = moment(parts.query.date)
	}
	$("#admindatepicker").datepicker("setDate", date_shown.toDate())
	month_schedule = getMonthSchedule(date_shown)
	refreshDateShown(month_schedule, date_shown)
	var i = parts.query.i
	var j = parts.query.j

	switch (parts.pathname) {
		case '/admin/calendarevent':
			switch (parts.query.action) {
				case 'ce_new':
					i = -1
				case 'ce_edit':
					calendarEventEditShow(month_schedule, date_shown, i)
					$('#calendarevent_index').hide()
					$('#calendarevent_edit').show()
					$('#booking_index').hide()
					$('#booking_edit').hide()
					break

				case 'bkg_index':
					bookings = getEventBookings(month_schedule[i].id)
					populateBookingList(i);
					$('#calendarevent_index').hide()
					$('#calendarevent_edit').hide()
					$('#booking_index').show()
					$('#booking_edit').hide()
					break	

				case 'ce_index':
				default:
					$('#calendarevent_index').show()
					$('#calendarevent_edit').hide()
					$('#booking_index').hide()
					$('#booking_edit').hide()
					break					

			}
			break

		case '/admin/booking':
			bookings = getEventBookings(month_schedule[i].id)
			bookingEditShow(i, j)
			switch (parts.query.action) {
				case 'bkg_new':
					j = -1
				case 'bkg_edit':
					$('#calendarevent_index').hide()
					$('#calendarevent_edit').hide()
					$('#booking_index').hide()
					$('#booking_edit').show()
					break	

				default:
					$('#calendarevent_index').hide()
					$('#calendarevent_edit').hide()
					$('#booking_index').show()
					$('#booking_edit').hide()
					break								
			}
			break

		default:
			$('#calendarevent_index').show()
			$('#calendarevent_edit').hide()
			$('#booking_index').hide()
			$('#booking_edit').hide()
			break			
	}

	$('.loading').hide();

	//
	// check form change
	//
	$( "#form_calendarevent :input, #form_booking :input" )
	  .change(function () {
	    form_changed = true;});

	//
	// calendar event new/edit datepicker
	//
	$( "#eventdatepicker" ).datepicker({
 	  	language: 'es',
 	  	defaultDate: date_shown.toDate(), 
        dateFormat: "DD, d MM yy" ,
		altFormat: "yy-mm-dd",
		altField: "#realDate"

	});	

	$('#ui-datepicker-div').wrap('<div class="admin-eventdatepicker"></div>');

	// 
	// calendar event buttons
	// we use .on() for dynamically created elements
	//
	$(document).on('click', '.button_calendarevent_edit', function() {
		$('#calendarevent_index').hide()
		calendarEventEditShow(month_schedule, date_shown, $(this).data('i'))
	})

	$(document).on('click', '.button_calendarevent_info', function() {
		var i = $(this).data('i')
		$('.modal_admin_title').html(month_schedule[i].short_description)
    	$('.modal_admin_body').html(month_schedule[i].info)
	    $('#modal_admin').modal('show')	
	})

	$(document).on('click', '.calendarevent_line', function() {
		var i = $(this).data('i')
		// var clase = month_schedule[i].time.substring(0,5) + '&nbsp;&nbsp;&nbsp;' + month_schedule[i].type
		// 			+ '<span class="pull-right">Registrados: ' + month_schedule[i].registered +'</span>'
		// $('#classshown').html(clase)
		$('#calendarevent_index').hide()
		bookings = getEventBookings(month_schedule[i].id)
		populateBookingList(i);
 	  	updateUrl(parts, '/admin/calendarevent', '', 'bkg_index', i)
		$('#booking_index').show()
	})
	
	$(".button_day_selector").click(function() {
		var new_date
		switch ($(this).data("d")) {
			case "prev":
				new_date = date_shown.subtract(1, 'days')
				break;
			case "next":
				new_date = date_shown.add(1, 'days')
				break;
			case "today":
				new_date = hoy				
		}
		$("#admindatepicker").datepicker("setDate", new_date.toDate())
 	  	updateUrl(parts, '/admin/calendarevent', new_date, 'ce_index', -1)
  		if (month_changed) {
  			month_schedule = getMonthSchedule(new_date)
  			month_changed = false 
  		}
  		date_shown = new_date
  		refreshDateShown(month_schedule, new_date)

  		if (form_changed) {
  			$('#button_calendarevent_close').trigger('click')
  		} else {
			$('#calendarevent_index').show()
			$('#calendarevent_edit').hide()
			$('#booking_index').hide()
			$('#booking_edit').hide()
	  	}
	  	return false
	})

	$(".button_calendarevent_selector").click(function() {
		var new_date
		var i = $("#booking_table").data('i')
		switch ($(this).data("d")) {
			case "prev":
				if (i == 0) {
					month_schedule = getMonthSchedule(date_shown.subtract(1, 'months'))
					i = month_schedule.length-1
				} else {
					i--
				}
				new_date = moment(month_schedule[i].date) 
				$("#admindatepicker").datepicker("setDate", new_date.toDate())
		 	  	updateUrl(parts, '/admin/calendarevent', new_date, 'bkg_index', i)
				month_changed = false
				date_shown = new_date
				break;
			case "next":
				if (i == month_schedule.length-1) {
					month_schedule = getMonthSchedule(date_shown.add(1, 'months'))
					i = 0
				} else {
					i++
				}
				new_date = moment(month_schedule[i].date) 
				$("#admindatepicker").datepicker("setDate", new_date.toDate())
		 	  	updateUrl(parts, '/admin/calendarevent', new_date, 'bkg_index', i)
				month_changed = false
				date_shown = new_date
				break;
			case "now":
				hoy = moment()
				new_date = hoy
				$("#admindatepicker").datepicker("setDate", new_date.toDate())
		 	  	updateUrl(parts, '/admin/calendarevent', new_date, 'bkg_index', i)
		  		if (month_changed) {
		  			month_schedule = getMonthSchedule(new_date)
		  			month_changed = false 
		  		}
		  		// date_shown = new_date
		  		var a
		  		for (i = 0; i < month_schedule.length; i++) {
		  			a = moment(month_schedule[i].date + ' ' + month_schedule[i].time)
		  			a.add(moment.duration(month_schedule[i].duration))
		  			if (a.isAfter(hoy)) {
						// console.log('i vale ' + i)
						break
		  			}
		  		}
				new_date = moment(month_schedule[i].date) 
				$("#admindatepicker").datepicker("setDate", new_date.toDate())
		 	  	updateUrl(parts, '/admin/calendarevent', new_date, 'bkg_index', i)
		  		if (month_changed) {
		  			month_schedule = getMonthSchedule(new_date)
		  			month_changed = false 
		  		}
				date_shown = new_date

				
		}
		var date_shown_locale = date_shown.format('dddd, D MMMM YYYY')
		$('.dateshown').html(date_shown_locale)	

		$('#calendarevent_index').hide()
		bookings = getEventBookings(month_schedule[i].id)
		populateBookingList(i);

  		if (form_changed) {
  			$('#button_calendarevent_close').trigger('click')
  		} else {
			$('#calendarevent_index').hide()
			$('#calendarevent_edit').hide()
			$('#booking_index').show()
			$('#booking_edit').hide()
	  	}
	  	return false;
	})
	//
	// #form_calendarvent_edit buttons
	//
	
	//
	// close
	//
	$("#button_calendarevent_close").click(function() {
		if (form_changed)
		{
			$('#modal_calendarevent_close').modal('show');
		}
		else
		{
		 	updateUrl(parts, '/admin/calendarevent', date_shown, 'ce_index')
			$('#calendarevent_index').show()
			$('#calendarevent_edit').hide()	
		}
	})

	//
	// modal close, modal ok
	//
	$("#modal_button_calendarevent_close, #modal_button_calendarevent_ok").click(function() {
		form_changed = false
		updateUrl(parts, '/admin/calendarevent', date_shown, 'ce_index')
		$('#calendarevent_index').show()
		$('#calendarevent_edit').hide()	
		$('#modal_calendarevent_close').modal('hide')
		$('#modal_calendarevent').modal('hide')
	})

	//
	// save, modal save i.e. add, update calendarevent
	//
	$("#button_calendarevent_save, #modal_button_calendarevent_save").click(function() {
		var ce_id = $('input[name=id]').val()
		var url
		$('.loading').show()
		if (form_changed || ce_id == 0 || typeof ce_id === "undefined") {  // form changed or new event

			$('#modal_calendarevent_close').modal('hide')

			if (ce_id == 0 || typeof ce_id === "undefined") {
				url = "/api/calendarevent/add"
			} else {
				url = "/api/calendarevent/update" 
			}
			$.ajax({
			    type: 'POST', 
			    url: url,
			   	data: $("#form_calendarevent").serialize(),
			   	dataType: 'json',
			    async: false,
			    success: function(msg){
			    	var error_msg
			    	var modal_title
			    	if (msg.status == 'ok'){
				    	date_shown =  moment($('input[name=date]').val())
				    	month_schedule = getMonthSchedule(date_shown)
				    	refreshDateShown(month_schedule, date_shown)
				    	$("#modal_button_calendarevent_ok").click()
			    	} else {
						modal_title = 'Error'
						if (ce_id == 0 || typeof ce_id === "undefined") {
							error_msg = 'Este evento ya existe'
						} else {
							error_msg = 'Este evento ya no existe'
						}
				    	month_schedule = getMonthSchedule(date_shown)
				    	refreshDateShown(month_schedule, date_shown)
			    		$('#modal_calendarevent_title').html(modal_title)
			    		$('#modal_calendarevent_body').html(error_msg)
				        $('#modal_calendarevent').modal('show')			    			    		
					}	
			    	$('.loading').hide()
			    }
			})
	    }
	})

	//
	// delete, modal delete
	//
	
	$("#button_calendarevent_delete").click(function() {
		$('#modal_calendarevent_delete').modal('show')
	})

	$("#modal_button_calendarevent_delete").click(function() {

		$('#modal_calendarevent_delete').modal('hide')
		$('.loading').show()
		var ce_id = $('input[name=id]').val()
		if (ce_id != 0) {
			$.ajax({
			    type: 'GET', 
			    url: '/api/calendarevent/delete/' + ce_id,
			    async: false,
			    success: function(msg){
			    	if (msg.status == 'ok') {
				    	$('#modal_calendarevent_title').html('Éxito')
				    	$('#modal_calendarevent_body').html('Evento borrado con éxito')			    		
			    	} else {
				    	$('#modal_calendarevent_title').html('Error')
				    	$('#modal_calendarevent_body').html('No se ha borrado')			    					    		
			    	}
				    month_schedule = getMonthSchedule(date_shown)
				    refreshDateShown(month_schedule, date_shown)
				    $('#modal_calendarevent').modal('show')
			    	$('.loading').hide()
				}
			})
		}
	})


	//
	//
	// booking buttons
	//
	//

	// 
	// booking buttons
	// we use .on() for dynamically created elements
	//
	$(document).on('click', '.booking_line, .button_booking_edit', function() {
		$('#booking_index').hide()
		bookingEditShow($("#booking_table").data('i'), $(this).data('j'))
	})

	//
	// #form_booking_edit buttons
	//
	
	//
	// booking close
	//
	$("#button_booking_close").click(function() {
		if (form_changed)
		{
			$('#modal_booking_close').modal('show');
		}
		else
		{
			updateUrl(parts, '/admin/calendarevent', date_shown, 'bkg_index', parts.query.i)
			$('#booking_index').show()
			$('#booking_edit').hide()	
		}
	})

	//
	// booking modal close, modal ok
	//
	$("#modal_button_booking_close, #modal_button_booking_ok").click(function() {
		form_changed = false
		updateUrl(parts, '/admin/calendarevent', date_shown, 'bkg_index', parts.query.i)
		$('#booking_index').show()
		$('#booking_edit').hide()	
		$('#modal_booking_close').modal('hide')
		$('#modal_booking').modal('hide')
	})

	//
	// booking save, modal save i.e. add, update 
	//
	$("#button_booking_save, #modal_button_booking_save").click(function() {
		var bkg_id = $('input[name=id]').val()
		var url;

		if (form_changed || bkg_id == 0 || typeof bkg_id === "undefined" ) {  // form changed or new booking

			if (!validBookingForm()) return true;

			$('#modal_booking_close').modal('hide')
			$('.loading').show();


			if (bkg_id == 0 || typeof bkg_id === "undefined") {
				url = "/api/booking/add"
			} else {
				url = "/api/booking/update" 
			}
			$.ajax({
			    type: 'POST', 
			    url: url,
			   	data: $("#form_booking").serialize(),
			   	dataType: 'json',
			    async: false,
			    success: function(msg){
			    	var error_msg
			    	var modal_title
			    	var show_modal = false
			    	if (msg.status == 'ok'){
			    	} else {
						modal_title = 'Error'
						show_modal = true
					}
					var date_shown = moment($('input[name=date]').val()) 
				    month_schedule = getMonthSchedule(date_shown)
				    refreshDateShown(month_schedule, date_shown)
				    var ce_id = $('input[name=calendarevent_id]').val()
					bookings = getEventBookings(ce_id)	
					var i
					for (i = 0 ; i < month_schedule.length; i++) {
						if (month_schedule[i].id == ce_id)
							break
					}
					$("#admindatepicker").datepicker("setDate", month_schedule[i].date)
					updateUrl(parts, '/admin/calendarevent', moment(month_schedule[i].date), 'bkg_index', i)
				    populateBookingList(i)
				    if (show_modal) {
				    	$('.modal_booking_title').html(modal_title)
				    	$('.modal_booking_body').html(error_msg)
					    $('#modal_booking').modal('show')				    	
				    } else {
				    	$('#modal_button_booking_ok').click()
				    }
				    $('.loading').hide();
			    }			    			    					    	
	    	})
		}
	})

	//
	// booking delete, modal delete
	//
	
	$("#button_booking_delete").click(function() {
		$('#modal_booking_delete').modal('show')
	})

	$("#modal_button_booking_delete").click(function() {

		$('#modal_booking_delete').modal('hide')
		$('.loading').show();

		var bkg_id = $('input[name=id]').val()
		if (bkg_id != 0) {
			$.ajax({
			    type: 'GET', 
			    url: '/api/booking/delete/' + bkg_id,
			    async: false,
			    success: function(msg){
			    	$('.modal_booking_title').html('Éxito')
			    	$('.modal_booking_body').html('Reserva borrada con éxito')
				    month_schedule = getMonthSchedule(date_shown)
				    refreshDateShown(month_schedule, date_shown)
				    var ce_id = $('input[name=calendarevent_id]').val()
					bookings = getEventBookings(ce_id)	
					var i
					for (i = 0 ; i < month_schedule.length; i++) {
						if (month_schedule[i].id == ce_id)
							break
					}
				    populateBookingList(i)
				    $('#modal_booking').modal('show')
				    $('.loading').hide();
				}
			})
		}
	})

	//
	// booking edit datepicker
	//
	$( "#booking_date_edit" ).datepicker({
 	  	language: 'es',
 	  	// defaultDate: date_shown.toDate(), 
        dateFormat: "DD, d MM yy" ,
		altFormat: "yy-mm-dd",
		altField: "#bookingNewDate",
		onSelect: function (dateText, inst) {
			form_changed = true
			populateSelect_dayeventlist()
			$("input[name=date]").val($('#bookingNewDate').val())
			$("input[name=calendarevent_id]").val($('#dayeventlist').val())

		}
	});	

	// 
	// booking edit new calendar event
	//
	$('#dayeventlist').change(function() {
		$("input[name=calendarevent_id]").val($(this).val())
	})


}) // jQuery

