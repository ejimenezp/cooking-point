//
// jquery for cashbox
//
require('./bootstrap');
var moment = require('moment');
require('moment/locale/es');

//
//
//	Variables globales
//
//

var conceptos = [];
var tickets = [];
var sesion_id;
var actualizar_tabla_sesiones;  // para saber si hacer history.back() o location.href
var estado; // para mostrar o no los botones de eliminar movimiento



//
//
// operaciones de inicialización ready()
//
//

$(document).ready(function() {

	if ($('#cashbox-index-page').length > 0) {
		// acciones solo para página de listado de sesiones
		get_sesiones(999999, 'desc');
	} else if ($('#sesion-page').length > 0) {
		// acciones solo para página de detalles de sesiones
		sesion_id = $('input[name=sesion_id]').val();
		$.ajax({
			type: 'GET', 	
		    url: '/api/sesion/get/' + sesion_id
		})
		.done(function(data) {
			estado = data.estado;
			var cabecera_estado;
			if (estado == 'ABIERTA') {
				cabecera_estado = 'Abierta - ';
				get_conceptos();
				get_tickets_tienda();
			} else {
				cabecera_estado = 'Cerrada - ';
				$('.enlace').css('color', '#dee2e6').click(function( event ) {
					event.stopImmediatePropagation(); 
				});
			}
			$('#cabecera').text(cabecera_estado + data.usuario + ' - ' + prettyd(data.fecha));
			$('#main-section div:not(:first-child)').hide(); // deja visible solo la primera opción
			refresh_detalles_sesion(false);
		});

	}

});




//
//
//	Funciones
//
//




//
//
// Usada para recuperar y actualizar los detalles mostrados de la sesion
//
//
function refresh_detalles_sesion(cambios = true)
{
	actualizar_tabla_sesiones = cambios;

	$.ajax({
		type: 'GET', 	
	    url: '/api/sesion/detalles/' + sesion_id
	})
	.done(function(data) {
		var tabla = '';
		var boton;
		$('#tabla-movimientos tbody').empty();
		data.forEach(function(item) {
			if (item.id != undefined && estado == 'ABIERTA') {  // es un movimiento
				boton = '<button class="btn btn-sm btn-primary boton-eliminar-movimiento" data-id="' + item.id + '">Eliminar</button>';
			} else {
				boton = '';
			}
			tabla += '<tr><td>' + item.descripcion + 
					'</td><td>' + prettyf(item.importe) +
					'</td><td>' + prettyf(item.saldo) +
					'</td><td>' + prettyf(item.descuadre) +
					'</td><td>' + prettyf(item.descuadre_acumulado) +
					'</td><td>' + boton +
					'</td></tr>'
		});
		$('#tabla-movimientos').append(tabla);
		$('#tabla-movimientos').show();

	});
}





//
//
// Pretty date
//
//
function prettyd(date)
{
	return moment(date).format('ddd D MMM HH:mm');
}




//
//
// Pretty float
//
//
function prettyf(amount)
{
	if (amount == null || amount == '') {
		return '-';
	} else {
		return parseFloat(amount).toFixed(2);
	}
}




//
//
// recupera todos los conceptos de pagos, cobros o ajustes para popular selects 
//
//
function get_conceptos()
{

	$.ajax({
		type: 'GET', 	
	    url: '/api/movimiento/getconceptos',
	})
	.done(function(data) {
		conceptos = JSON.parse(JSON.stringify(data));
		var select_compras = '';
		$('#select-compras').empty();
		$('#select-ventas').empty();
		$('#select-ajustes').empty()
		data.forEach(function(item) {
			if (item.tipo == 'COMPRA') {
				$('#select-compras').append('<option value="' + item.id +'" data-tipo="' + item.tipo +'" data-signo="' + item.signo +'">' + item.concepto +'</option>');							
			} else if (item.tipo == 'VENTA') {
				$('#select-ventas').append('<option value="' + item.id +'" data-tipo="' + item.tipo +'" data-signo="' + item.signo +'">' + item.concepto +'</option>');							
			} else if (item.tipo == 'AJUSTE') {
				$('#select-ajustes').append('<option value="' + item.id +'" data-tipo="' + item.tipo +'" data-signo="' + item.signo +'">' + item.concepto +'</option>');							
			} 
		});
		// inicializar los campos de descripción
		$('#tabla-compras input[name=descripcion]').val($('#select-compras').children().first().text());
		$('#tabla-ventas input[name=descripcion]').val($('#select-ventas').children().first().text());
		$('#tabla-ajustes input[name=descripcion]').val($('#select-ajustes').children().first().text());

	})
	.fail(function(jqXHR, textStatus, errorThrown ) {
	})

}




//
//
// recupera tickets de la tienda (cash) de los últimos días 
//
//
function get_tickets_tienda()
{
	$.ajax({
		type: 'GET', 	
	    url: '/api/movimiento/gettickets/' + sesion_id,
		})
	.done(function(data) {
		tickets = JSON.parse(JSON.stringify(data));		
		var select = '';
		$('#select-ventas-tienda').empty();
		data.forEach(function(item) {
			select += '<option value="' + item.id +'" data-importe="' + item.total +'"> Ticket #' + item.id +' (' + item.total +'€) </option>';			
		});
		$('#select-ventas-tienda').append(select);
        $("#select-ventas-tienda option:last").attr("selected", "selected");
	})
	.fail(function(jqXHR, textStatus, errorThrown ) {
	})
}



//
//
// recupera todas las sesiones
// en el futuro, haremos intervalos 
//
//
function get_sesiones(comienzo, direccion)
{

	$.ajax({
		type: 'POST', 
	    url: '/api/sesion/getlista',
	    data: {comienzo: comienzo, direccion: direccion}
		})
	.done(function(data) {
		sesiones = JSON.parse(JSON.stringify(data));		
		$('#sesiones > tbody').empty();	

		data.forEach(function(item) {
			var conteo_inicio = !item.efectivo_inicial ? ' style=\"background-color:coral;\"' : '';
			var conteo_final = !item.efectivo_final ? ' style=\"background-color:coral;\"' : '';

			$('#sesiones > tbody:last').append(
				'<tr data-id=\"'+item.id+'\"><td onclick=\"location.href=\'/admin/cashbox/'+ item.id +'\'\">'+ item.id +'</td>'+
				'<td onclick=\"location.href=\'/admin/cashbox/'+ item.id +'\'\">'+ prettyd(item.fecha) +'</td>'+
				'<td onclick=\"location.href=\'/admin/cashbox/'+ item.id +'\'\">'+ item.usuario +'</td>'+
				'<td onclick=\"location.href=\'/admin/cashbox/'+ item.id +'\'\">'+ item.estado +'</td>'+
				'<td onclick=\"location.href=\'/admin/cashbox/'+ item.id +'\'\"' + conteo_inicio + '>'+ prettyf(item.efectivo_sesion_al_inicio) +'</td>'+
				'<td onclick=\"location.href=\'/admin/cashbox/'+ item.id +'\'\">'+ prettyf(item.ventas) +'</td>'+
				'<td onclick=\"location.href=\'/admin/cashbox/'+ item.id +'\'\">'+ prettyf(item.compras) +'</td>'+
				// '<td onclick=\"location.href=\'/admin/cashbox/'+ item.id +'\'\">'+ prettyf(item.ajustes) +'</td>'+
				'<td onclick=\"location.href=\'/admin/cashbox/'+ item.id +'\'\"' + conteo_final + '>'+ prettyf(item.efectivo_sesion) +'</td>'+
				'<td onclick=\"location.href=\'/admin/cashbox/'+ item.id +'\'\">'+ prettyf(item.descuadre) +'</td>'+
				'<td onclick=\"location.href=\'/admin/cashbox/'+ item.id +'\'\">'+ prettyf(item.descuadre_acumulado) +'</td></tr>'
				);
		});

	})
	.fail(function(jqXHR, textStatus, errorThrown ) {
	})

}




//
//
// buttons handling (use .on() for dynamically created elements)
//
//

//
//
// events for classes
//
//
$(document).on('click', '.enlace', function() {
	$('#main-section').children().hide();
	var s = $(this).attr('section');
	$('#'+s).show();
});


$(document).on('click', '.mostrar-resumen', function() {
	$('#main-section').children().hide();
	refresh_detalles_sesion();
	$('#resumen').show();	
});


$(document).on('click', '.boton-vuelta-caja', function() {
	if (actualizar_tabla_sesiones) {
		location.href = '/admin/cashbox';
	} else {
		window.history.back();
	}
	return false;
});


$(document).on('click', '.boton-eliminar-movimiento', function() {

	$.ajax({
		type: 'POST', 	
	    url: '/api/movimiento/eliminar/' + $(this).data('id'),
		})
	.done(function(data) {
		refresh_detalles_sesion();
		$('#resumen').show();

	})
})
//
//
// events for concrete id's
//
//


$(document).on('click', '#boton-nueva-sesion', function() {

	$.ajax({
		type: 'GET', 	
	    url: '/api/sesion/getultimaabierta',
		})
	.done(function(data) {
		if(!data) {
			$('#modal-boton-nueva-sesion').trigger('click');
		} else {
			sesion_id = data.id;
			$('#modal-sesion-id').text(data);
			$('#modal-sesion-abierta').modal('show');
		}
	});
});

$(document).on('click', '#boton-continuar-sesion-abierta', function() {
	$('#modal-sesion-abierta').modal('hide');
	location.href = '/admin/cashbox/' + sesion_id;
	return false;
});





$(document).on('click', '#modal-boton-nueva-sesion', function() {

	var now = moment().format('YYYY-MM-DD HH:mm:ss');
	var user_name = $('meta[name=user_name]').attr('content');

	$.ajax({
		type: 'POST', 	
	    url: '/api/sesion/crear',
	    data: {fecha: now, usuario: user_name}
		})
	.done(function(data) {
		location.href = '/admin/cashbox/' + data;
		return false;
	});
})





$(document).on('click', '#boton-pagina-mas', function() {

	get_sesiones($('#sesiones tbody tr:last').data('id'), 'asc');
})





$(document).on('click', '#boton-pagina-menos', function() {

	get_sesiones($('#sesiones tbody tr:first').data('id'), 'desc');
})




// evento para cambiar el campo descripcion de las compras o ventas
$(document).on('change', '#select-compras, #select-ventas', function() {
	descripcion = $(this).children(':selected').text();
	$(this).parent().next().find('input[name=descripcion]').val(descripcion);
	$(this).parent().next().next().find('input[name=importe]').val('0');
	$(this).parent().next().next().next().find('input[name=ticket_id]').prop('checked', true);
});





$(document).on('click', '#boton-anadir-compras', function() {

	var importe = $('#tabla-compras input[name=importe]').val();
	if (importe == 0)
		return;

	var mov = {};
	mov.sesion_id = sesion_id;
	mov.descripcion = $('#tabla-compras input[name=descripcion]').val();
	mov.ticket = $('#tabla-compras input[type=checkbox]').is(':checked');
	mov.tipo = $('#select-compras').children(':selected').data('tipo');
	mov.importe = importe * $('#select-compras').children(':selected').data('signo');

	$.ajax({
		type: 'POST', 	
	    url: '/api/movimiento/crear',
	    data: mov
		})
	.done(function(data) {
		$('#main-section').children().hide();
		refresh_detalles_sesion();
		$('#resumen').show();

	})
})



$(document).on('click', '#boton-anadir-ventas', function() {


	var importe = $('#tabla-ventas input[name=importe]').val();
	if (importe == 0)
		return;

	var mov = {};
	mov.sesion_id = sesion_id;
	mov.descripcion = $('#tabla-ventas input[name=descripcion]').val();
	mov.tipo = $('#select-ventas').children(':selected').data('tipo');
	mov.importe = importe * $('#select-ventas').children(':selected').data('signo');

	$.ajax({
		type: 'POST', 	
	    url: '/api/movimiento/crear',
	    data: mov
		})
	.done(function(data) {
		$('#main-section').children().hide();
		refresh_detalles_sesion();
		$('#resumen').show();

	})
})




$(document).on('click', '#boton-anadir-ventas-tienda', function() {

	var mov = {};
	mov.sesion_id = sesion_id;
	mov.descripcion = 'Tienda ticket #' + $('#select-ventas-tienda').val();
	mov.tipo = 'VENTA';
	mov.importe = $('#select-ventas-tienda').children(':selected').data('importe');
	mov.ticket_tienda = $('#select-ventas-tienda').val();

	$.ajax({
		type: 'POST', 	
	    url: '/api/movimiento/crear',
	    data: mov
		})
	.done(function(data) {
		$('#main-section').children().hide();
		refresh_detalles_sesion();
		$('#resumen').show();
		get_tickets_tienda();

	})
})







$(document).on('click', '#boton-contar-efectivo-inicial', function() {

	var mov = {};
	mov.sesion_id = sesion_id;
	mov.importe = $('#tabla-efectivo-inicial input[name=importe]').val();

	$.ajax({
		type: 'POST', 	
	    url: '/api/sesion/setefectivoinicial',
	    data: mov
		})
	.done(function(data) {
		$('#main-section').children().hide();
		refresh_detalles_sesion();
		$('#resumen').show();
	})
})



$(document).on('click', '#boton-contar-efectivo-final', function() {

	var mov = {};
	mov.sesion_id = sesion_id;
	mov.importe = $('#tabla-efectivo-final input[name=importe]').val();

	$.ajax({
		type: 'POST', 	
	    url: '/api/sesion/setefectivofinal',
	    data: mov
		})
	.done(function(data) {
		$('#main-section').children().hide();
		refresh_detalles_sesion();
		$('#resumen').show();
	})
})



$(document).on('click', '#boton-eliminar-sesion', function() {

	$.ajax({
		type: 'POST', 	
	    url: '/api/sesion/eliminar/' + sesion_id,
		})
	.done(function(data) {
		location.href = '/admin/cashbox';
		return false;
	})
	.fail(function(data) {
		$('.modal-admin-title').html('Error');
		$('.modal-admin-body').html(data.responseJSON);
		$('#modal-admin').modal('show');
	})
})



$(document).on('click', '#boton-cerrar-sesion', function() {

	$.ajax({
		type: 'POST', 	
	    url: '/api/sesion/cerrar/' + sesion_id,
		})
	.done(function(data) {
		$('#main-section').children().hide();
		refresh_detalles_sesion();
		$('#resumen').show();
	})
})

$(document).on('click', '#boton-recalcular-caja', function() {

	$.ajax({
		type: 'POST', 	
	    url: '/api/sesion/recalcularcaja/' + sesion_id,
		})
	.done(function(data) {
		location.href = '/admin/cashbox';
		return false;
	})
	.fail(function(data) {
		$('.modal-admin-title').html('Error');
		$('.modal-admin-body').html(data.responseJSON);
		$('#modal-admin').modal('show');
	})
})
