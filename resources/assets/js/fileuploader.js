require('./bootstrap');
// require('jquery-serializejson')
require('@nobleclem/jquery-multiselect')




// 
// helper functions to upload files
//


function refresh_uploaded_files() {
	$.get('/api/upload/getfiles/', function (uploaded) {
		var len = uploaded.length, options = [];
		for (var i = 0; i < len; i++) {
			options.push({
				name : uploaded[i],
				value: uploaded[i],
				checked: false});
		}
		$('#uploaded_files').multiselect( 'loadOptions', options);
	})
}

$('#button_preview_file').click(function() {
	if (!$('#uploaded_files').val().length) {
		$('.modal_admin_title').html('Error');
		$('.modal_admin_body').html('No files to preview');
		$('#modal_admin').modal('show');
	} else {
		$.ajax({
			type: 'POST', 
			url: '/api/upload/previewfile',
			data: {fichero: $('#uploaded_files').val()[0]},
			success: function(result) {
						$('textarea[name=preview]').val(result);
			}
		});		
	}
});


$('#button_upload_file').click(function(e) {
    e.preventDefault();
    var image = $('input[name=file]')
    var form_data = new FormData()

    form_data.append('file', image[0].files[0])

	$.ajax({
		type: 'POST', 
		url: '/api/upload/uploadfile',
		processData: false,
	    contentType: false,
		data: form_data,
		success: function () {
			refresh_uploaded_files()
		}
	})
})


$('#button_remove_files').click(function() {
	if (!$('#uploaded_files').val().length) {
		$('.modal_admin_title').html('Error');
		$('.modal_admin_body').html('No files to remove');
		$('#modal_admin').modal('show');
	} else {
		$.ajax({
			type: 'POST', 
			url: '/api/upload/removefiles',
			data: {ficheros: $('#uploaded_files').val()},
			success: function() {
				refresh_uploaded_files();
			}
		});		
	}
});


$('#button_import_staffing').click(function() {
	$.ajax({
		type: 'POST', 	
		data: {fichero: $('#uploaded_files').val()[0]},
	    url: '/api/upload/importstaffing'
		})
	.done(function() {
		location.href = '/admin/report';
		return false;
	})
	.fail(function(data) {
		$('.modal-admin-title').html('Error');
		$('.modal-admin-body').html(data.responseJSON);
		$('#modal-admin').modal('show');
	});
});

//
// Begin jquery(document).ready
//

jQuery(document).ready(function($) {

	$('#uploaded_files').multiselect();
	refresh_uploaded_files();

}) // jQuery
