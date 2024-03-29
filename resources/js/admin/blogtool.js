
require('../bootstrap')
const $ = require('jquery')

require('@nobleclem/jquery-multiselect')

var moment = require('moment')
require('moment/locale/es')

function refreshUploadedimages (postid) {
  $.get('/api/blogtool/getimages/' + postid, function (uploaded) {
    var len = uploaded.length; var options = []
    var thumbnail_select = $('select[name=thumbnail_image]')
    thumbnail_select.empty()
    for (var i = 0; i < len; i++) {
      options.push({
        name: uploaded[i],
        value: uploaded[i],
        checked: false
      })
      thumbnail_select.append($('<option />').val(uploaded[i]).text(uploaded[i]))
    }
    $('#uploaded_images').multiselect('loadOptions', options)
  })
}

function refresh_related_posts (postid) {
  $.when($.get('/api/blogtool/index'),
    $.get('/api/blogtool/related/' + postid)
  ).done(function (index_jqXHR, related_jqHXR) {
    var posts = index_jqXHR[0]
    var related = related_jqHXR[0]
    var i; var index = -1; var options = []
    var len = posts.length
    for (i = 0; i < len; i++) {
      if (posts[i].id !== postid) {
        options.push({
          name: posts[i].shortname,
          value: String(posts[i].id),
          checked: false
        })
      }
    }
    len = related.length
    for (i = 0; i < len; i++) {
      index = options.findIndex(function (element) { return element.value == related[i] })
      if (index > -1) {
        options[index].checked = true
      }
    }
    $('#related_posts').multiselect('loadOptions', options)
  })
}

function refresh_post_index () {
  $.get('/api/blogtool/index', function (result) {
    $('#blogposts_table > tbody').empty()
    for (var j = 0; j < result.length; j++) {
      $('#blogposts_table > tbody:last').append(
        '<tr postid="' + result[j].id + '"><td onclick=\"location.href=\'/admin/blogtool/' + result[j].id + "\'\">" +
				result[j].id +
				"</td><td onclick=\"location.href=\'/admin/blogtool/" + result[j].id + "\'\">" +
				result[j].shortname +
				"</td><td onclick=\"location.href=\'/admin/blogtool/" + result[j].id + "\'\">" +
				result[j].title +
				"</td><td onclick=\"location.href=\'/admin/blogtool/" + result[j].id + "\'\">" +
				result[j].friendly_url +
				"</td><td onclick=\"location.href=\'/admin/blogtool/" + result[j].id + "\'\">" +
				result[j].status +
				'</td><td>' +
				'<i class="far fa-lg fa-clone button_post_duplicate" data-postid="' + result[j].id + '"></i>' +
				' ' +
				'<i class="fas fa-lg fa-arrow-circle-up button_post_up"></i>' +
				' ' +
				'<i class="fas fa-lg fa-arrow-circle-down button_post_down"></i>' +
				'</td></tr>'
      )
    }
  })
}

function refresh_post (id) {
  $.get('/api/blogtool/get/' + id, function (result) {
    $('input[name=id]').val(result.id)
    $('input[name=shortname]').val(result.shortname)
    $('input[name=title]').val(result.title)
    $('textarea[name=description]').val(result.description)
    $('input[name=friendly_url]').val(result.friendly_url)
    $('select[name=thumbnail_image]').val(result.thumbnail_image)
    $('textarea[name=thumbnail_description]').val(result.thumbnail_description)
    $('textarea[name=body]').val(result.body)
    $('input[name=status]').val(result.status)
    $('input[name=publishing_date]').val(result.publishing_date)
  })
}

//
//
// buttons handling (use .on() for dynamically created elements)
//
//

$(document).on('click', '.button_post_duplicate', function () {
  $.get('/api/blogtool/duplicate/' + $(this).data('postid'), function () {
    refresh_post_index()
  })
})

$(document).on('click', '.button_post_up, .button_post_down', function () {
  var row = $(this).parents('tr:first')
  if ($(this).is('.button_post_up')) {
    row.insertBefore(row.prev())
    $('#button_post_index_save').show()
  } else {
    row.insertAfter(row.next())
    $('#button_post_index_save').show()
  }
})

$('#button_post_index_save').click(function () {
  var order = []
  $('#blogposts_table tbody tr').each(function () {
    order.push($(this).attr('postid'))
  })

  $.ajax({
    type: 'POST',
    url: '/api/blogtool/savedisplayposition',
    data: { order: order },
    success: function () {
      $('#button_post_index_save').hide()
    }
  })
})

$('#button_post_index_toggle').click(function () {
  var status
  var newState; var current = $('#blogposts_table').data('toggle')
  if (current === 'ALL') {
    newState = 'PUBLISHED'
    $('#button_post_index_toggle').text('View: published')
    $('#blogposts_table tbody tr').each(function () {
      status = $(this).find('td:eq(4)').text()
      if (status !== 'PUBLISHED') {
        $(this).hide()
      }
    })
  } else {
    newState = 'ALL'
    $('#button_post_index_toggle').text('View: date')
    $('#blogposts_table tbody tr').each(function () {
      $(this).show()
    })
  }
  $('#blogposts_table').data('toggle', newState)
})

$('#button_post_update').click(function () {
  var request = {}

  request.id = $('input[name=id]').val()
  request.shortname = $('input[name=shortname]').val()
  request.title = $('input[name=title]').val()
  request.description = $('textarea[name=description]').val()
  request.friendly_url = $('input[name=friendly_url]').val()
  request.thumbnail_image = $('select[name=thumbnail_image]').val()
  request.thumbnail_description = $('textarea[name=thumbnail_description]').val()
  request.body = $('textarea[name=body]').val()
  request.status = $('input[name=status]').val()
  request.related = $('#related_posts').val()
  request.publishing_date = $('input[name=publishing_date]').val()

  $.ajax({
    type: 'POST',
    url: '/api/blogtool/update',
    data: request,
    success: function () {
      refresh_post($('#post-edit-page').attr('postid'))
      refreshUploadedimages($('#post-edit-page').attr('postid'))
    },
    error: function (jqXHR, textStatus, errorThrown) {
      refresh_post($('#post-edit-page').attr('postid'))
      $('.modal_admin_title').html('Error')
      $('.modal_admin_body').html(jqXHR.responseJSON + '<br/>')
      $('#modal_admin').modal('show')
    }
  })
})

$('#button_post_publish').click(function () {
  var errormsg = ''
  if (!$('input[name=shortname]').val()) errormsg += 'Shortname is empty<br/>'
  if (!$('input[name=title]').val()) errormsg += 'Title is empty<br/>'
  if (!$('textarea[name=description]').val()) errormsg += 'Description is empty<br/>'
  if (!$('input[name=friendly_url]').val()) errormsg += 'Friendly URL is empty<br/>'
  if (!$('select[name=thumbnail_image]').val()) errormsg += 'Thumbnail image is empty<br/>'
  if (!$('textarea[name=thumbnail_description]').val()) errormsg += 'Thumbnail description is empty<br/>'
  if (!$('textarea[name=body]').val()) errormsg += 'Body is empty<br/>'
  if (!$('input[name=publishing_date]').val()) errormsg += 'Publishing date is empty<br/>'
  var pubday = moment($('input[name=publishing_date]').val())
  if (!pubday.isValid()) errormsg += 'Wrong publishing date format (yyyy-mm-dd)<br/>'

  if ($('input[name=status]').val() === 'EDITING') errormsg += '<br/>Save and preview before publishing<br/>'
  if ($('input[name=status]').val() === 'PUBLISHED') errormsg += 'Already published<br/>'

  if (errormsg.length) {
    $('.modal_admin_title').html('Error')
    $('.modal_admin_body').html('Check following errors before publishing:<br/><br/>' + errormsg)
    $('#modal_admin').modal('show')
    return
  }

  $.get('/api/blogtool/publish/' + $('#post-edit-page').attr('postid'), function () {
    refresh_post($('#post-edit-page').attr('postid'))
  })
})

$('#button_post_delete').click(function () {
  $('#modal_post_delete').modal('show')
})

$('#modal_button_post_delete').click(function () {
  $.get('/api/blogtool/delete/' + $('#post-edit-page').attr('postid'), function () {
    location.href = '/admin/blogtool'
  })
})

$('#button_remove_images').click(function () {
  if (!$('#uploaded_images').val().length) {
    $('.modal_admin_title').html('Error')
    $('.modal_admin_body').html('No files to remove')
    $('#modal_admin').modal('show')
    return
  }
  $.ajax({
    type: 'POST',
    url: '/api/blogtool/removeimages',
    data: { images: $('#uploaded_images').val() },
    success: function () {
      refreshUploadedimages($('#post-edit-page').attr('postid'))
    }
  })
})

$('#button_upload_image').click(function (e) {
  e.preventDefault()
  var image = $('input[name=image]')
  var formData = new FormData()

  formData.append('id', $('#post-edit-page').attr('postid'))
  formData.append('file', image[0].files[0])

  $.ajax({
    type: 'POST',
    url: '/api/blogtool/uploadimage',
    processData: false,
    contentType: false,
    data: formData,
    success: function () {
      refreshUploadedimages($('#post-edit-page').attr('postid'))
    }
  })
})

//
// comienzo del jquery(document).ready

$(document).ready(function ($) {
  $('#related_posts').multiselect()
  $('#uploaded_images').multiselect()

  var postid = $('#post-edit-page').attr('postid')

  if ($('#post-index-page').length > 0) {
    // acciones solo para página de listado de posts
    refresh_post_index()
  } else if ($('#post-edit-page').length > 0) {
    // acciones solo para página de detalles de post
    refresh_post(postid)
    refresh_related_posts(postid)
    refreshUploadedimages(postid)
  }

  $(':input')
    .change(function () {
      $('input[name=status]').val('EDITING')
    })
}) // jQuery
