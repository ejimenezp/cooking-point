/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 195);
/******/ })
/************************************************************************/
/******/ ({

/***/ 195:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(196);


/***/ }),

/***/ 196:
/***/ (function(module, exports) {


//
// Function: showModalBooking
// helper function to streamline modal showing and subsequent actions
// (copied from bookings.js)
//
function showModalBooking(tthis, title, body, show_cancel, action) {
	var new_modal = 'modal_contactoeventos_' + tthis.id;
	var new_modal_id = '#' + new_modal;

	$(new_modal_id).remove();
	$('#modal_contactoeventos').clone().attr('id', new_modal).insertAfter('#modal_contactoeventos');

	$(new_modal_id).find('.modal_contactoeventos_title').html(title);
	$(new_modal_id).find('.modal_contactoeventos_body').html(body);
	if (show_cancel) {
		$(new_modal_id).find('.btn-cancel').removeClass('hidden');
	} else {
		$(new_modal_id).find('.btn-cancel').addClass('hidden');
	}
	$(new_modal_id).find('.btn-ok').unbind('click').click(action);
	$(new_modal_id).modal('show');
}

//
// Function: validateContactoForm
// validates input fields and returns accordingly
// (copied from booking.js)
//
function validateContactoForm() {
	var modal_title = 'Error en el formulario';
	var modal_body = '';
	var show_it = false;

	if ($("textarea[name=message]").val() == '') {
		modal_body += 'Rellena tu nombre. Lo usaremos para dirigirnos a ti.<br/>';
		show_it = true;
	}
	if ($("input[name=email]").val() == '') {
		modal_body += 'Rellena tu e-mail. Escribe uno válido.<br/>';
		show_it = true;
	}
	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var mail = $("input[name=email]").val();
	if (mail != "" && !filter.test(mail)) {
		modal_body += 'Escribe un e-mail válido.<br/>';
		show_it = true;
	}
	if ($("textarea[name=message]").val() == '') {
		modal_body += 'Escribe un mensaje. Dinos algo sobre el evento que quieres organizar.<br/>';
		show_it = true;
	}

	if (show_it) {
		$('.modal_contactoeventos_title').html(modal_title);
		$('.modal_contactoeventos_body').html(modal_body);
		$('#modal_contactoeventos').modal('show');
		return false;
	}
	return true;
}

// Event snippet for solicitar info eventos conversion page
// In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->

function gtag_report_conversion(url) {
	var callback = function callback() {
		if (typeof url != 'undefined') {
			window.location = url;
		}
	};
	gtag('event', 'conversion', {
		'send_to': 'AW-985592263/lSg_CPW5gX4Qx-P71QM',
		'event_callback': callback
	});
	return false;
}

$(document).ready(function () {

	$('#button_contacto_form').click(function () {

		if (!validateContactoForm()) {
			return false;
		}

		var response = $.ajax({
			type: 'POST',
			url: '/api/contact/contactoeventos',
			data: $("#form_contactoeventos").serialize(),
			dataType: 'json',
			async: false
		}).responseText;

		if (response == 'ok') {
			showModalBooking(this, 'Solicitud Recibida', 'Gracias por contactarnos. En breve recibirás noticias nuestras.', false, function () {
				gtag_report_conversion('/eventos-privados-madrid');
			});
		} else {
			showModalBooking(this, 'Ups! ', 'Parece que hay problemas. Por favor, envíanos un correo a info@cookingpoint.es', false, function () {});
		}
	});
}); // end jQuery

/***/ })

/******/ });