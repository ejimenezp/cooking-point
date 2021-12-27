import 'core-js/stable'
import 'regenerator-runtime/runtime'
import React, { useState, useEffect } from 'react'
import ReactDOM from 'react-dom'
import PropTypes from 'prop-types'
import { Router, Redirect } from '@reach/router'

import ErrorBoundary from '../booking/Components/ErrorBoundary'
import LoadingIndicator from './Components/LoadingIndicator'

import CalendareventIndex from './CalendareventIndex'
import BookingIndex from './BookingIndex'
import BookingView from './BookingView'
import BookingEdit from './BookingEdit'

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
  const [schedule, setSchedule] = useState(JSON.parse(props.param))
  const [staff, setStaff] = useState()
  const [sources, setSources] = useState()
  const [priceplans, setPriceplans] = useState()

  function handleUpdateSchedule (schedule) {
    setSchedule(schedule)
  }

  useEffect(() => {
    const fetchStaff = async () => {
      try {
        const result = await axios.get('/api/staff/get')
        setStaff(result.data)
      } catch (error) {
        console.log(error)
      }
    }
    const fetchSources = async () => {
      try {
        const result = await axios.get('/api/source/get')
        setSources(result.data)
      } catch (error) {
        console.log(error)
      }
    }
    fetchStaff()
    fetchSources()
  }, [])

  return (
    <div className='col-12'>
      <React.StrictMode>
        <Router>
          {/*          <Redirect from='/adminbookings/:d' to={'/adminbookings/' + schedule[0].date} noThrow />

          <CalendareventEdit path='/adminbookings/calendarevent/:id' id={id} />
*/}
          <BookingView path='/adminbookings/:daaa/:ceId/:bkgId' schedule={schedule} sources={sources} />
          <BookingEdit path='/adminbookings/:daaa/:ceId/:bkgId/edit'
            schedule={schedule}
            sources={sources}
            propagateFn={handleUpdateSchedule}
          />
          <BookingEdit path='/adminbookings/:daaa/:ceId/add'
            schedule={schedule}
            sources={sources}
            propagateFn={handleUpdateSchedule}
          />
          <BookingIndex path='/adminbookings/:daaa/:ceId' schedule={schedule} />
          <CalendareventIndex path='/adminbookings/:date' schedule={schedule} staff={staff} propagateFn={handleUpdateSchedule} />
        </Router>
      </React.StrictMode>
    </div>
  )
}

AdminBookingsRoot.propTypes = {
  param: PropTypes.string,
  date: PropTypes.string
}

const element = document.getElementById('AdminBookingsRoot')
ReactDOM.render(
  <div>
    <AdminBookingsRoot param={element.getAttribute('param')} date={element.getAttribute('date')} />
    <LoadingIndicator />
  </div>, element
)
