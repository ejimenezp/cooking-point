import 'core-js/stable'
import 'regenerator-runtime/runtime'
import React, { useState, useEffect } from 'react'
import ReactDOM from 'react-dom'
import PropTypes from 'prop-types'
import { Router, Redirect } from '@reach/router'

import ErrorBoundary from '../booking/Components/ErrorBoundary'

import CalendareventIndex from './CalendareventIndex'
import BookingIndex from './BookingIndex'

const axios = require('axios').default

// import AvailabilityPage from './AvailabilityPage'
// import CustomerDetailsPage from './CustomerDetailsPage'
// import BookingDetailsPage from './BookingDetailsPage'
// import CancelBookingPage from './CancelBookingPage'

//
// Webpack generate empty css if dynamic import is used (expected to solve with 5.0)
// https://stackoverflow.com/questions/57137438/webpack-generating-empty-css-files-in-laravel-app-when-using-vue-router
//
// const AvailabilityPage = React.lazy(() => import('./AvailabilityPage.js'));
// const CustomerDetailsPage = React.lazy(() => import('./CustomerDetailsPage.js'));

function AdminBookingsRoot (props) {
  const any = props.any
  const [options, setOptions] = useState()
  // const data = JSON.parse(props.data)
  // data.fixed_date = parseInt(data.fixed_date)
  // data.hide_price = parseInt(data.hide_price)
  // data.price = parseFloat(data.price)
  // if (data.onlineclass) {
  //   data.tz = (typeof data.tz === 'undefined') ? Intl.DateTimeFormat().resolvedOptions().timeZone : data.tz
  //   if (data.type === 'PAELLA') {
  //     data.type = 'ONLINE-EVENING-PAELLA'
  //   }
  // } else {
  //   data.tz = 'Europe/Madrid'
  // }

  // const [bkg, setBkg] = useState(data)

  // function handleUpdateBkg (bkg) {
  //   const updatedBkg = Object.assign({}, bkg)
  //   updatedBkg.fixed_date = parseInt(updatedBkg.fixed_date)
  //   updatedBkg.hide_price = parseInt(updatedBkg.hide_price)
  //   updatedBkg.price = parseFloat(updatedBkg.price)
  //   setBkg(updatedBkg)
  // }


  return (
    <div className='col-12'>
      <ErrorBoundary>
        <Router>
          <Redirect from='/adminbookings' to={'/adminbookings/' + any} noThrow />

{/*          <CalendareventEdit path='/adminbookings/calendarevent/:id' id={id} />
          <BookingEdit path='/adminbookings/booking/:id' id={id} /> 
*/}
          <BookingIndex path='/adminbookings/bookingindex/:id' id={any} />
          <CalendareventIndex path='/adminbookings/:date' date={any} options={options} />
        </Router>
      </ErrorBoundary>
    </div>
  )
}

AdminBookingsRoot.propTypes = {
  date: PropTypes.string
}

const element = document.getElementById('AdminBookingsRoot')
ReactDOM.render(
  <AdminBookingsRoot any={element.getAttribute('any')} />, element
)
