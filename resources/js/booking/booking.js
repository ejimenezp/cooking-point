import 'core-js/stable'
import 'regenerator-runtime/runtime'
import React, { useState } from 'react'
import ReactDOM from 'react-dom'
import PropTypes from 'prop-types'
import { QueryClient, QueryClientProvider } from 'react-query'
// import { ReactQueryDevtools } from 'react-query/devtools'
import { Router, Redirect } from '@reach/router'

import ErrorBoundary from './Components/ErrorBoundary'

import AvailabilityPage from './AvailabilityPage'
import CustomerDetailsPage from './CustomerDetailsPage'
import BookingDetailsPage from './BookingDetailsPage'
import CancelBookingPage from './CancelBookingPage'

//
// Webpack generate empty css if dynamic import is used (expected to solve with 5.0)
// https://stackoverflow.com/questions/57137438/webpack-generating-empty-css-files-in-laravel-app-when-using-vue-router
//
// const AvailabilityPage = React.lazy(() => import('./AvailabilityPage.js'));
// const CustomerDetailsPage = React.lazy(() => import('./CustomerDetailsPage.js'));

const queryClient = new QueryClient()

function BookingRoot (props) {
  const data = JSON.parse(props.data)
  data.fixed_date = parseInt(data.fixed_date)
  data.hide_price = parseInt(data.hide_price)
  data.price = parseFloat(data.price)
  if (data.onlineclass) {
    data.tz = (typeof data.tz === 'undefined') ? Intl.DateTimeFormat().resolvedOptions().timeZone : data.tz
    if (data.type === 'PAELLA') {
      data.type = 'ONLINE-EVENING-PAELLA'
    }
  } else {
    data.tz = 'Europe/Madrid'
  }

  const [bkg, setBkg] = useState(data)

  function handleUpdateBkg (bkg) {
    const updatedBkg = Object.assign({}, bkg)
    updatedBkg.fixed_date = parseInt(updatedBkg.fixed_date)
    updatedBkg.hide_price = parseInt(updatedBkg.hide_price)
    updatedBkg.price = parseFloat(updatedBkg.price)
    setBkg(updatedBkg)
  }

  return (
    <QueryClientProvider client={queryClient}>
    {/*<ReactQueryDevtools initialIsOpen={false} />*/}
      <div className='col-12'>
        <ErrorBoundary>
          <Router>
            {bkg.locator === '' && <Redirect from='/booking' to='/booking/new/availability' noThrow />}
            {bkg.locator !== '' && <Redirect from='/booking' to={'/booking/' + bkg.locator} noThrow />}

            <AvailabilityPage path='/booking/new/availability' liftUp={handleUpdateBkg} bkg={bkg} />
            <AvailabilityPage path='/booking/:locator/availability' liftUp={handleUpdateBkg} bkg={bkg} />
            <CustomerDetailsPage path='/booking/new/customerdetails' liftUp={handleUpdateBkg} bkg={bkg} />
            <CustomerDetailsPage path='/booking/:locator/customerdetails' liftUp={handleUpdateBkg} bkg={bkg} />
            <BookingDetailsPage path='/booking/new/booking' liftUp={handleUpdateBkg} bkg={bkg} />
            <BookingDetailsPage path='/booking/:locator' liftUp={handleUpdateBkg} bkg={bkg} />
            <CancelBookingPage path='/booking/:locator/cancelbooking' liftUp={handleUpdateBkg} bkg={bkg} />
          </Router>
        </ErrorBoundary>
      </div>
    </QueryClientProvider>

  )
}

BookingRoot.propTypes = {
  data: PropTypes.string
}

const element = document.getElementById('BookingRoot')
ReactDOM.render(
  <BookingRoot data={element.getAttribute('data')} />, element
)
