window.$ = window.jQuery = require('jquery')
require('jquery-ui/ui/widgets/datepicker')
require('bootstrap')

var moment = require('moment')

//
// datepicker locale
//
$.datepicker.regional.es = {
  closeText: 'Cerrar',
  prevText: '<<',
  nextText: '>>',
  currentText: 'Hoy',
  monthNames: ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'],
  monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
  dayNames: ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'],
  dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
  dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
  weekHeader: 'Sm',
  firstDay: 1,
  isRTL: false,
  showMonthAfterYear: false,
  yearSuffix: ''
}

$.datepicker.setDefaults($.datepicker.regional.es)

//
// Global variables
//
var start_moment, end_moment

//
// snippet to move querystring params to array
//
var vars = []; var hash
var q = document.URL.split('?')[1]
if (q != undefined) {
  q = q.split('&')
  for (var i = 0; i < q.length; i++) {
    hash = q[i].split('=')
    vars.push(hash[1])
    vars[hash[0]] = hash[1]
  }
}

//
// Begin jquery(document).ready
//

jQuery(document).ready(function ($) {
  if (vars.start_date) {
    start_moment = moment(vars.start_date)
  } else {
    start_moment = moment().startOf('month')
    vars.start_date = start_moment.format('YYYY-MM-DD')
  }

  if (vars.end_date) {
    end_moment = moment(vars.end_date)
  } else {
    end_moment = start_moment.clone().endOf('month')
    vars.end_date = end_moment.format('YYYY-MM-DD')
  }

  //
  // Booking Datepicker
  //
  $('#startdatepicker').datepicker({
 	  	language: 'es',
 	  	defaultDate: start_moment.toDate(),
    dateFormat: 'DD, d MM yy',
    altFormat: 'yy-mm-dd',
    altField: '#start',
    onSelect: function () {
      start_moment = moment($('#start').val())
      end_moment = start_moment.clone().endOf('month')
      vars.start_date = start_moment.format('YYYY-MM-DD')
      vars.end_date = end_moment.format('YYYY-MM-DD')
      $('#enddatepicker').datepicker('setDate', end_moment.toDate())
      history.pushState(undefined, undefined, window.location.pathname + '?start_date=' + vars.start_date + '&end_date=' + vars.end_date)
    }
  })

  $('#ui-datepicker-div').wrap('<div class="admin-eventdatepicker"></div>')

  $('#enddatepicker').datepicker({
 	  	language: 'es',
 	  	defaultDate: end_moment.toDate(),
    dateFormat: 'DD, d MM yy',
    altFormat: 'yy-mm-dd',
    altField: '#end',
    onSelect: function () {
      end_moment = moment($('#end').val())
      vars.end_date = end_moment.format('YYYY-MM-DD')
      history.pushState(undefined, undefined, window.location.pathname + '?start_date=' + vars.start_date + '&end_date=' + vars.end_date)
    }
  })

  $('#ui-datepicker-div').wrap('<div class="admin-eventdatepicker"></div>')

  $('#startdatepicker').datepicker('setDate', start_moment.toDate())
  $('#enddatepicker').datepicker('setDate', end_moment.toDate())

  //
  // end initial display
  //

  //
  // event-driven actions
  //

  $('.report').click(function (e) {
    e.preventDefault()
    $('#report_form').attr('action', '/admin/report/' + $(this).attr('report_id') + '?start_date=' + vars.start_date + '&end_date=' + vars.end_date)
    $('#report_form').submit()
  })

  $('.ir').click(function (e) {
    e.preventDefault()
    location.href = $(this).attr('href')
  })
}) // jQuery
