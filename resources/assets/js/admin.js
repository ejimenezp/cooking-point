require('./bootstrap');
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
	var edit_button, classemails_button

	$("#calendarevent_table > tbody").empty();
	for (var i = 0; i < month_schedule.length; i++) {
		edit_button = ''
		classemails_button = ''
		if (user_role >= 3) {
			edit_button = '<button class="btn btn-primary btn-sm button_calendarevent_edit" data-i="'
					+ i + '">Detalles</button>'
		} else if (user_role >= 2 && month_schedule[i].info != '') {
			edit_button = '<button class="btn btn-primary btn-sm button_calendarevent_info" data-i="'
					+ i + '">+info</button>'			
		} else {
			edit_button = ''			
		}
		if (user_name == 'Emails') {
			classemails_button = '<a class="btn btn-primary btn-sm" href="/admin/classemails?ce_id=' + month_schedule[i].id + '">E-mails</a>'
		} 

		var calendarevent_tr_class = (user_role >= 2) ? 'calendarevent_line' : ''
		var secondstaff_name

		if (month_schedule[i].date == date_shown.format('YYYY-MM-DD')) {
			
			secondstaff_name = (month_schedule[i].secondstaff_id == 2 ? "" : ", " + cookName(month_schedule[i].secondstaff_id) )
			$('#calendarevent_table > tbody:last').append(
				'<tr onclick=""><td class="' + calendarevent_tr_class + '" data-i="' + i +'">'+ 
				month_schedule[i].time.substring(0,5) + 
				" (" + moment.duration(month_schedule[i].duration).asHours() +" h.)" +
				'</td><td class="' + calendarevent_tr_class + '" data-i="' + i +'">' + 
				month_schedule[i].type +
				'</td><td class="' + calendarevent_tr_class + '" data-i="' + i +'">' + 
				cookName(month_schedule[i].staff_id) + secondstaff_name +
				'</td><td class="' + calendarevent_tr_class + '" data-i="' + i +'">' + 
				month_schedule[i].registered +
				'</td><td>' +
				classemails_button +
				edit_button +
				'</td></tr>');
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
		$("input[name=fixed_date]").prop('checked', 0);
		$("select[name=pay_method]").val('N/A')
		$("input[name=payment_date]").val('')
		$("textarea[name=food_requirements]").val('')
		$("textarea[name=comments]").val('')
		$("select[name=crm]").val('NO')
		$("input[name=invoice]").val('')
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
		$("input[name=iva]").prop('checked', parseInt(bookings[j].iva))
		$("input[name=hide_price]").prop('checked', parseInt(bookings[j].hide_price))
		$("input[name=fixed_date]").prop('checked', parseInt(bookings[j].fixed_date))
		$("select[name=pay_method]").val(bookings[j].pay_method)
		$("input[name=payment_date]").val(bookings[j].payment_date)
		$("textarea[name=food_requirements]").val(bookings[j].food_requirements)
		$("textarea[name=comments]").val(bookings[j].comments)
		$("select[name=crm]").val(bookings[j].crm)
		$("input[name=locator]").val(bookings[j].locator)
		$("input[name=invoice]").val(bookings[j].invoice)
		url_action = 'bkg_edit'
	}
	updateUrl(parts, '/admin/booking', moment(booking_date), url_action, i, j)
	showPrice()
	showSection('#booking_edit');
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
		$("select[name=secondstaff_id]").val(2)  // not assigned yet
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
		$("select[name=secondstaff_id]").val(month_schedule[i].secondstaff_id)
		$("select[name=time]").val(month_schedule[i].time)
		$("select[name=duration]").val(month_schedule[i].duration)
		$("input[name=capacity]").val(month_schedule[i].capacity)
		$("textarea[name=info]").val(month_schedule[i].info)
		url_action = 'ce_edit'
	}
	updateUrl(parts, '/admin/calendarevent', moment($("input[name=date]").val()), url_action, i)
	showSection('#calendarevent_edit');
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
	var secondstaff_name = (month_schedule[i].secondstaff_id == 2 ? "" : ", " + cookName(month_schedule[i].secondstaff_id) )
	var clase = month_schedule[i].time.substring(0,5) + '&nbsp;&nbsp;&nbsp;' + month_schedule[i].type
	 			+ ' (' + cookName(month_schedule[i].staff_id) + secondstaff_name + ') '
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
// Function: showSection
// hide all sub-sections under div #main-section to show only the one in the arg
//
function showSection(arg) {
	$('#main-section > div').hide();
	$(arg).show();
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
// use https://www.regextester.com/1966 to validate 
//
function validBookingForm()
{
	// 

	var modal_title = 'Error'
	var modal_body = ''
	var show_it = false
	if ($("input[name=name]").val() == '') {
		modal_body += 'Introduce un nombre<br/>'
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
	filter = /^(\d+\.\d+)$|^(\d+)$/ 
	var input_field = $("input[name=price]").val()
    if (input_field == "" || input_field != "" && !filter.test(input_field)) {
		modal_body += 'Precio con . decimal<br/>'
		show_it = true
    }
	filter = /^(20\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])) *( +(0?[0-9]|1[0-9]|(2[0-3])):([0-9]|[0-5][0-9])(:([0-9]|[0-5][0-9]))?)?$/ 
	input_field = $("input[name=payment_date]").val()
    if (input_field != "" && !filter.test(input_field)) {
		modal_body += 'Fecha pago incorrecta. Usa aaaa-mm-dd [hh:mm:ss] []=opcional<br/>'
		show_it = true
    }

	if ($("select[name=status]").val() == 'PAID' && $("select[name=pay_method]").val() == 'N/A') {
		modal_body += 'Selecciona Forma de Pago<br/>'
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



	//
	// initial load
	//
	user_name = $('meta[name=user_name]').attr('content')
	user_role = $('meta[name=user_role]').attr('content')
	var month_changed = false


	//
	// load cook list
	//
	$.ajax({
	    type: 'GET', 
	    url: '/api/staff/get',
	    async: false,
	    success: function(data){
			cook = data;
			var select = ''
			$('.cooklist').empty()
			for (var ii = 0; ii < cook.length; ii++) {
				select += '<option value="'+ cook[ii].id +'">' + cook[ii].name + '</option>'
			}
			$('.cooklist').append(select)
	     }
	});


	//
	// load source list
	//
	$.ajax({
	    type: 'GET', 
	    url: '/api/source/get',
	    success: function(data){
			source = data;
			select = ''
			$('#sourcelist').empty()
			for (var ii = 0; ii < source.length; ii++) {
				select += '<option value="'+ source[ii].id +'">' + source[ii].type + ' - ' + source[ii].name + '</option>'
			}
			$('#sourcelist').append(select)
	     }
	});


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
				showSection('#calendarevent_index');
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
					showSection('#calendarevent_edit');
					break

				case 'bkg_index':
					bookings = getEventBookings(month_schedule[i].id)
					populateBookingList(i);
					showSection('#booking_index');
					break	

				case 'ce_index':
				default:
					showSection('#calendarevent_index')
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
					showSection('#booking_edit');
					break	

				default:
					showSection('#booking_index');
					break								
			}
			break

		default:
			showSection('#calendarevent_index');
			break			
	}


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
		calendarEventEditShow(month_schedule, date_shown, $(this).data('i'))
	})

	$(document).on('click', '.button_calendarevent_info', function() {
		var i = $(this).data('i')
		$('.modal_admin_title').html(month_schedule[i].short_description)
    	$('.modal_admin_body').html(month_schedule[i].info.replace(/\n/g, '<br\/>'))
	    $('#modal_admin').modal('show')	
	})

	$(document).on('click', '.calendarevent_line', function() {
		var i = $(this).data('i')
		// var clase = month_schedule[i].time.substring(0,5) + '&nbsp;&nbsp;&nbsp;' + month_schedule[i].type
		// 			+ '<span class="pull-right">Registrados: ' + month_schedule[i].registered +'</span>'
		// $('#classshown').html(clase)
		bookings = getEventBookings(month_schedule[i].id)
		populateBookingList(i);
 	  	updateUrl(parts, '/admin/calendarevent', '', 'bkg_index', i)
		showSection('#booking_index');
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
			showSection('#calendarevent_index');
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

		bookings = getEventBookings(month_schedule[i].id)
		populateBookingList(i);

  		if (form_changed) {
  			$('#button_calendarevent_close').trigger('click')
  		} else {
			showSection('#booking_index');
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
			showSection('#calendarevent_index');
		}
	})

	//
	// modal close, modal ok
	//
	$("#modal_button_calendarevent_close, #modal_button_calendarevent_ok").click(function() {
		form_changed = false
		updateUrl(parts, '/admin/calendarevent', date_shown, 'ce_index')
		showSection('#calendarevent_index');
		$('#modal_calendarevent_close').modal('hide')
		$('#modal_calendarevent').modal('hide')
	})

	//
	// save, modal save i.e. add, update calendarevent
	//
	$("#button_calendarevent_save, #modal_button_calendarevent_save").click(function() {
		var ce_id = $('input[name=id]').val()
		var url
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
			    async: false
			})
			.done(function(data){
		    	date_shown =  moment($('input[name=date]').val());
		    	month_schedule = getMonthSchedule(date_shown);
		    	refreshDateShown(month_schedule, date_shown);
		    	showSection('#calendarevent_index');
		    })
		    .fail(function(data) {
		    	month_schedule = getMonthSchedule(date_shown)
		    	refreshDateShown(month_schedule, date_shown)
	    		$('#modal_calendarevent_title').html('Error');
	    		$('#modal_calendarevent_body').html(data.responseJSON)
		        $('#modal_calendarevent').modal('show')			    			    		
			});
		}
	});

	//
	// delete, modal delete
	//
	
	$("#button_calendarevent_delete").click(function() {
		$('#modal_calendarevent_delete').modal('show')
	})

	$("#modal_button_calendarevent_delete").click(function() {

		$('#modal_calendarevent_delete').modal('hide')
		var ce_id = $('input[name=id]').val()
		if (ce_id != 0) {
			$.ajax({
			    type: 'GET', 
			    url: '/api/calendarevent/delete/' + ce_id,
			    async: false,
			    success: function(msg){
				    month_schedule = getMonthSchedule(date_shown)
				    refreshDateShown(month_schedule, date_shown)
			    	if (msg.status != 'ok') {
				    	$('#modal_calendarevent_title').html('No Eliminado')
				    	$('#modal_calendarevent_body').html('Este evento tiene reservas')			    					    		
					    $('#modal_calendarevent').modal('show')
			    	} else {
			    		$("#modal_button_calendarevent_close").click()
			    	}
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
		bookingEditShow($("#booking_table").data('i'), $(this).data('j'))
	})

	//
	// #form_booking_edit buttons
	//
	
	//
	//  copy to clipboard
	$("#button_booking_copy").click(function() {
		var textArea = document.createElement("textarea")
		textArea.value = "https://cookingpoint.es/booking/" + $("input[name=locator]").val()
		document.body.appendChild(textArea)
		textArea.select()
		try {
		    document.execCommand('copy')
		} catch (err) {
			console.log('Oops, unable to copy')
		}
		document.body.removeChild(textArea)
	})

	//
	// send voucher by email
	//
	$("#button_booking_emailit").click(function() {
		if (form_changed)
		{
			$('#modal_booking_save_before_emailit').modal('show');
		}
		else
		{
			var mail = $("input[name=email]").val()
			$('.modal_admin_body').html('Enviar correo a ' + mail + '?')
			$('#modal_booking_save_before_emailit').modal('hide');
			$('#modal_booking_agree_before_emailit').modal('show');
		}
	})

	$("#modal_button_booking_emailit").click(function() {
		$('#modal_booking_agree_before_emailit').modal('hide');
		$.ajax({
			type: 'POST', 	
		    url: '/api/booking/emailIt',
		   	data: {locator: $("input[name=locator]").val()}
			})
		.done(function() {
			$('.modal_admin_title').html('Done')
			$('.modal_admin_body').html('Correo enviado correctamente')
			$('#modal_admin').modal('show')
		})
		.fail(function(jqXHR, textStatus, errorThrown ) {
			$('.modal_admin_title').html('Error')
			$('.modal_admin_body').html(jqXHR.responseText + '<br/>')
			$('#modal_admin').modal('show')
		})
	})



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
			showSection('#booking_index');
		}
	})

	//
	// booking modal close, modal ok
	//
	$("#modal_button_booking_close").click(function() {
		form_changed = false
		updateUrl(parts, '/admin/calendarevent', date_shown, 'bkg_index', parts.query.i)
		showSection('#booking_index');
		$('#modal_booking_close').modal('hide')
		$('#modal_admin').modal('hide')
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
			    async: false
			})
			.done(function(msg){
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
				$("#admindatepicker").datepicker("setDate", month_schedule[i].date);
				updateUrl(parts, '/admin/calendarevent', moment(month_schedule[i].date), 'bkg_index', i);
			    populateBookingList(i);
			    form_changed = false;
			    showSection("#booking_index");
			})
			.fail(function(data) {
		    	$('.modal_admin_title').html('Error')
		    	$('.modal_admin_body').html(data.responseJSON)
			    $('#modal_admin').modal('show')							
			});
		}
	});

	//
	// booking delete, modal delete
	//
	
	$("#button_booking_delete").click(function() {

		var bkg_status_filter = $('input[name=status_filter]').val()
	    if (bkg_status_filter == 'REGISTERED') {
			$('.modal_admin_title').html('Reserva Confirmada')
			$('.modal_admin_body').html('Atención, esta reserva está confirmada. Cancela antes de borrar')
			$('#modal_admin').modal('show')
		} else {
			$('#modal_booking_delete').modal('show')
		}
	})

	$("#modal_button_booking_delete").click(function() {

		$('#modal_booking_delete').modal('hide')

		var bkg_id = $('input[name=id]').val()
		if (bkg_id != 0) {
			$.ajax({
			    type: 'GET', 
			    url: '/api/booking/delete/' + bkg_id,
			    async: false,
			    success: function(msg){
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
				    $('#modal_button_booking_close').click()
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

