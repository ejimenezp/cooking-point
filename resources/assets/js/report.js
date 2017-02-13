window.$ = window.jQuery = require('jquery')
require('jquery-ui/ui/widgets/datepicker')
require('bootstrap-sass');
require('jquery-serializejson')


var moment = require('moment')

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

//
// Global variables
//
// var right_now = moment("2016-12-15 09:00")
var right_now = moment()
var date_shown = right_now.clone()

//
// Begin jquery(document).ready
//

jQuery(document).ready(function($) {


	//
	// Booking Datepicker
	//
	$( "#startdatepicker" ).datepicker({
 	  	language: 'es',
 	  	defaultDate: date_shown.toDate(), 
        dateFormat: "DD, d MM yy" ,
		altFormat: "yy-mm-dd",
		altField: "#start"

	});	

    $('#ui-datepicker-div').wrap('<div class="admin-eventdatepicker"></div>');

	$( "#enddatepicker" ).datepicker({
 	  	language: 'es',
 	  	defaultDate: date_shown.toDate(), 
        dateFormat: "DD, d MM yy" ,
		altFormat: "yy-mm-dd",
		altField: "#end"

	});	

    $('#ui-datepicker-div').wrap('<div class="admin-eventdatepicker"></div>');

	$('#startdatepicker').datepicker("setDate", date_shown.clone().startOf('month').toDate())
	$('#enddatepicker').datepicker("setDate", date_shown.clone().endOf('month').toDate())

	// 
    // end initial display
    //

	//
    // event-driven actions
    //


	$('.report').click(function (e) {
        e.preventDefault();
        $('#report_form').attr('action', '/admin/report/' + $(this).attr('report_id'))
        $('#report_form').submit()
    })

	$('.ir').click(function (e) {
        e.preventDefault();
        location.href= $(this).attr('href')
    })




}) // jQuery