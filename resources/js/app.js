/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.$ = window.jQuery = require('jquery')
require('bootstrap')
require('lazysizes')
// import a plugin
require('lazysizes/plugins/parent-fit/ls.parent-fit')

// window.Vue = require('vue');

// *
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });

// to allow sass mixins for different browsers
document.documentElement.setAttribute('data-browser', navigator.userAgent)

///
/// jquery for page slideshows
///

//
//
// jQuery main function
//
//

$(document).ready(function () {

  $(document).click(function (event) {
    const target = event.target.closest('.menu-strips')
    if (target !== null) {
      document.getElementById('dropdown-content').classList.toggle('dropdown-content-slide-in')
    } else if ($('#dropdown-content').hasClass("dropdown-content-slide-in")) {
      document.getElementById('dropdown-content').classList.toggle('dropdown-content-slide-in')
      // $('.menu-strips').click()
    }
  })

}) // end jQuery

// to make divs clickable
$('.all-clickable').click(function () {
  window.location = $(this).find('a').attr('href')
  return false
})

// to display pulldown menus on smartphones
// $('.menu-strips').click(function (e) {
//   document.getElementById('dropdown-content').classList.toggle('dropdown-content-slide-in')
// })

// to highlight selected menubar option
$('.cp-navbar li a[href="' + window.location.pathname + '"]').addClass('active')

// to highlight selected menubar option, on smartphone navbar
$('#dropdown-content a[href="' + window.location.pathname + '"]').parent().addClass('active')
$('#dropdown-content li').focusin(function () {
  $('#dropdown-content .active').removeClass('active')
  $(this).addClass('active')
})



//
// private-events' page call to action
//
$('.email-us').css('cursor', 'pointer')

$('.email-us').click(function () {
  window.open('mailto:info@cookingpoint.es', 'newwindow')
  return false
})
