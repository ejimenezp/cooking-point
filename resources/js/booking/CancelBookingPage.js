import React, { useState } from 'react'
import PropTypes from 'prop-types'
import { differenceInHours } from 'date-fns'
import { navigate } from '@reach/router'
import { InquiryDetails } from './InquiryDetails'
import { NavButtons } from './Components/NavButtons'
const axios = require('axios').default

export default CancelBookingPage

CancelBookingPage.propTypes = {
  liftUp: PropTypes.func,
  bkg: PropTypes.object
}

function CancelBookingPage (props) {
  const localbkg = props.bkg
  const now = new Date()
  const [isError, setIsError] = useState(false)

  function handleButtonConfirm () {
    (async () => {
      setIsError(false)
      try {
        const result = await axios.post('/api/booking/cancelIt', localbkg)
        result.data.store = false
        props.liftUp(result.data)
        navigate('/booking/' + localbkg.locator)
      } catch (error) {
        setIsError(true)
      }
    })()
  }

  function handleButtonCancel () {
    navigate('/booking/' + localbkg.locator)
  }

  function cancelable () {
    return ['CONFIRMED', 'PAID', 'GUARANTEE'].includes(localbkg.status) &&
      (differenceInHours(new Date(localbkg.calendarevent.startdateatom), now) >= 24)
  }

  return (
    <div>
      {isError && alert('Error communicating with server, please reload page')}
      <div className='row'>
        <div className='col-12'>
          <h1>Booking</h1>
          {cancelable() && <p>You are about to cancel the following booking:</p>}
          {!cancelable() && <p>Your booking&apos;s details:</p>}
        </div>
      </div>

      <InquiryDetails bkg={localbkg} />

      <div className='row'>
        <div className='col-12'>
          <h2><br />Please note</h2>
          {cancelable() && <p>We will proceed to refund the total amount of your booking. Please note it will take a few days to receive it into your credit card. Thank you for your patience.</p>}
          {!cancelable() && <p>The start of class is too close, so there is not applicable refund. Should you have any comments, please let us know by e-mail or phone.</p>}
        </div>
      </div>

      <NavButtons>
        <div className='btn btn-secondary' onClick={handleButtonCancel}>Back</div>{' '}
        {cancelable() && <div className='btn btn-primary' onClick={handleButtonConfirm}>Confirm Cancellation</div>}
      </NavButtons>
    </div>
  )
}
