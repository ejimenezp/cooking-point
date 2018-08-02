/**
 * 
 */
window.$ = window.jQuery = require('jquery');

//require('bootstrap-sass');
require('jquery-serializejson');
require('print-this');


require('jquery-ui/ui/widgets/datepicker');

//
// function to access date in querystring
//
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return '';
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}


function refreshTicketTable(date) {

    var response = $.ajax({
        type: 'GET', 
        url: '/api/tienda/getTickets',
        data: {date : date},
        async: false,
        success: function(msg){
            if (msg.status == 'fail') {
                alert('Error al acceder a los tickets')
            }
         }
    }).responseText
    var ticket_list = JSON.parse(response)

    $("#ticket_table > tbody").empty()
    for (var j = 0; j < ticket_list.length; j++) {
        $('#ticket_table > tbody:last').append(
            '<tr><td>'+ 
            ticket_list[j].id +
            '</td><td>' + 
            ticket_list[j].fecha +
            '</td><td>' + 
            ticket_list[j].total +
            '</td><td>' + 
            ticket_list[j].pago +
            '</td><td>' + 
            ticket_list[j].quien +
            '</td><td>' + 
            ticket_list[j].articulo0 +
            '</td><td>' + 
            ticket_list[j].articulo1 +
            '</td><td>' + 
            ticket_list[j].articulo2 +
            '</td><td>' + 
            ticket_list[j].articulo3 +
            '</td><td>' + 
            ticket_list[j].more +
            '</td><td>' + 
                '<form role="form" action="/tienda/deleteticket"> \
                    <input type="hidden" name="date" value="'+ date + '"> \
                    <input type="hidden" name="id" value="'+ ticket_list[j].id + '"> \
                    <button type="submiy" class="btn btn-primary btn-sm">Delete</button> \
                </form>' +
            '</td></tr>');

    }
}


$( document ).ready(function() {

	$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	});



    $( "#admindatepicker" ).datepicker({
        dateFormat: "DD, d MM yy" ,
        altFormat: "yy-mm-dd",
        altField: "#realDate",
        firstDay: 1, // Start with Monday
        onClose: function (date) {
            if (ticket_pagado) {
                alert("Este ticket ya está pagado. Limpia antes de cambiar la fecha")
            } else {
                $("#pretty_date").html(date)
                refreshTicketTable($("#realDate").val())           
            }

        }
    })
    
    $('#ui-datepicker-div').wrap('<div class="admin-eventdatepicker"></div>');

    $( "#admindatepicker" ).datepicker("setDate", new Date(getParameterByName('date')));
    var pretty_date = $("input[name=pretty_date]").val()
    var ticket_date = $("input[name=date]").val()
    refreshTicketTable(ticket_date)           


    var ticket = {
		date 	: ticket_date,
		total	: 0,
		articulos: [],
        base4   : 0,
        iva4    : 0,
        base10  : 0,
        iva10   : 0,
        base21  :0,
        iva21   :0,
		pago	: ""
	}
	var articles = ""  // para imprimir los articulos en el ticket
	var ticket_pagado = false



	$("#pretty_date").html(ticket_date)

    $(".boton-articulo").click(function(){

        if (ticket.articulos.length == 10) {
            alert("Máximo 10 artículos por ticket")
            return true;
        }
    	if (ticket_pagado) {
    		alert("Este ticket ya está pagado. Limpia o recarga la página")
    		return true;
    	}
        var iva = $(this).data('iva')
        var pvp = $(this).data('pvp')
        var this_base = Number(pvp)/(1 + Number(iva)/100)
        var this_iva = pvp - this_base

        switch (iva) {
            case 4:
                ticket.base4 = ticket.base4 + this_base
                ticket.iva4 = ticket.iva4 + this_iva
                break;
            case 10:
                ticket.base10 = ticket.base10 + this_base
                ticket.iva10 = ticket.iva10 + this_iva
                break;
            case 21:
            default:
                ticket.base21 = ticket.base21 + this_base
                ticket.iva21 = ticket.iva21 + this_iva
        }

//    	articles = articles + '<tr><td>'+ $(this).data('nombre') + '</td><td>' + pvp +'</td></tr>'
        $('#items_table > tbody:last, #screen_table > tbody:last').append('<tr><td>'+ $(this).data('nombre') + '</td><td class="text-right">' + pvp +'</td></tr>');
        ticket.total = ticket.total + Number(pvp)

        var impuestos = ""

        // empty tax table before updating
        $("#tax_table > tbody").empty();

        if (ticket.base4) {
        	impuestos = impuestos + ticket.base4.toFixed(2) + ' &nbsp ' + '4' + '% &nbsp ' + ticket.iva4.toFixed(2) + '<br/>'
            $('#tax_table > tbody:last').append('<tr><td>'+ ticket.base4.toFixed(2) + '</td><td>' + '4' + '%</td><td>' + ticket.iva4.toFixed(2) +'</td></tr>');
        }
        if (ticket.base10) {
            impuestos = impuestos + ticket.base10.toFixed(2) + ' &nbsp ' + '10' + '% &nbsp ' + ticket.iva10.toFixed(2) + '<br/>'
            $('#tax_table > tbody:last').append('<tr><td>'+ ticket.base10.toFixed(2) + '</td><td>' + '10' + '%</td><td>' + ticket.iva10.toFixed(2) +'</td></tr>');
        }
        if (ticket.base21) {
            impuestos = impuestos + ticket.base21.toFixed(2) + ' &nbsp ' + '21' + '% &nbsp ' + ticket.iva21.toFixed(2) + '<br/>'
            $('#tax_table > tbody:last').append('<tr><td>'+ ticket.base21.toFixed(2) + '</td><td>' + '21' + '%</td><td>' + ticket.iva21.toFixed(2) +'</td></tr>');
        }

        $('.total').html(ticket.total.toFixed(2))

        // añadimos el artículo en la lista
        ticket.articulos.push($(this).data('id'))

    });


    $("#boton-limpiar").click(function(){
        ticket = {
            date    : ticket_date,
            total   : 0,
            articulos: [],
            base4   : 0,
            iva4    : 0,
            base10  : 0,
            iva10   : 0,
            base21  : 0,
            iva21   : 0,
            pago    : ""
        }
		articles = "";  // para imprimir los articulos en el ticket
    	ticket_pagado = false

        $("#tax_table > tbody").empty();
        $("#screen_table > tbody").empty();
        $("#items_table > tbody").empty();
        $('#ticket_id').html("--")
        $('.total').html(0)

	});



    $(".boton-pagar").click(function(){
    	if (ticket_pagado) {
    		alert("Este ticket ya está pagado. Limpia o recarga la página")
    	} else if (ticket.total != 0) {
	    	ticket.pago = $(this).data('pago')
            ticket.date = $("#realDate").val()
            $("#forma_pago").html(ticket.pago)
            $.ajax({
                type    : "POST",
                url     : "/tienda/addticket",
                data    : ticket,
                async   : false,
                success : function(result){
                    $('#ticket_id').html(result) }
            })
	    	ticket_pagado = true
            $("#receipt").printThis()
        }
    });

});
