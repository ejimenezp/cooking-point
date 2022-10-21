import React, { useState, useEffect, Fragment } from 'react'
import PropTypes from 'prop-types'
import { navigate } from '@reach/router'
import { isBefore, differenceInHours } from 'date-fns'
import { useMediaQuery } from 'react-responsive'

import { MyModal } from './Components/Modal'
import { NavButtons } from './Components/NavButtons'
import { VoucherPrintOut } from './Components/VoucherPrintOut'
import { InquiryDetails } from './InquiryDetails'
import { CustomerDetails } from './CustomerDetails'
const axios = require('axios').default

export default BookingDetailsPage

BookingDetailsPage.propTypes = {
  liftUp: PropTypes.func,
  bkg: PropTypes.object
}

function BookingDetailsPage (props) {
  const localbkg = props.bkg
  const [showModal, setShowModal] = useState(false)
  const [modalContent, setModalContent] = useState('')
  const [showModalTPVOK, setShowModalTPVOK] = useState(localbkg.tpv_result === 'OK')
  const [showModalTPVKO, setShowModalTPVKO] = useState(localbkg.tpv_result === 'KO')
  const [showModalNOAVAILABILITY, setShowModalNOAVAILABILITY] = useState(localbkg.tpv_result === 'NOAVAILABILITY')
  const [isError, setIsError] = useState(false)
  const isMobile = useMediaQuery({ maxWidth: 575 })

  useEffect(() => {
    if (isMobile) window.scrollTo(0, 0)
  }, [])

  function handleEmailVoucher () {
    if (localbkg.email) {
      (async () => {
        setIsError(false)
        try {
          await axios.post('/api/booking/emailIt', localbkg)
          const modal = {}
          modal.header = '<h4>E-mail Sent</h4>'
          modal.body = '<p>You will receive it at <strong>' + localbkg.email + '</strong></p>'
          setModalContent(modal)
          setShowModal(true)
        } catch (error) {
          setIsError(true)
        }
      })()
    } else {
      const modal = {}
      modal.header = '<h4>No e-mail provided</h4>'
      modal.body = '<p>Please, fill in the e-mail in the Customer Details section.</p>'
      setModalContent(modal)
      setShowModal(true)
    }
  }

  useEffect(() => {
    if (localbkg.store) {
      const url = localbkg.locator ? '/api/booking/update' : '/api/booking/add'
      const storeBkg = async () => {
        setIsError(false)
        try {
          const result = await axios.post(url, { ...localbkg })
          result.data.store = false
          props.liftUp(result.data)
        } catch (error) {
          setIsError(true)
        }
      }
      storeBkg()
    }
  }, [])

  useEffect(() => {
    let title = `${localbkg.calendarevent.short_description} on ${localbkg.date} for ${localbkg.adult} `
    title += localbkg.adult > 1 ? 'adults' : 'adult'
    switch (localbkg.child) {
      case 0:
        break
      case 1:
        title += ' + 1 child'
        break
      default:
        title += ` + ${localbkg.child} children`
    }
    title += ` for ${localbkg.name}`
    document.title = title

    const stateObj = { foo: 'bar' }
    history.replaceState(stateObj, 'page 2', `/booking/${localbkg.locator}`)
  })

  function modalTPVOK () {
    if (!showModalTPVOK) {
      localbkg.tpv_result = ''
      return
    }
    const modal = {}
    modal.header = '<h4>Thank you for booking a class with us!</h4>'
    modal.body = `<p>We have sent a confirmation e-mail to</p><p style="font-weight:bold;text-align:center">${localbkg.email}</p><p>Please check your inbox to make sure you received it. If you can&apos;t find it, please check also the Spam/Junk e-mail folder.</p><p>You can modify your e-mail address at anytime with "Edit Customer Details" option.</p>`
    return (
      <MyModal text={modal} liftUp={() => setShowModalTPVOK(false)} />
    )
  }

  function modalTPVKO () {
    if (!showModalTPVKO) {
      localbkg.tpv_result = ''
      return
    }
    const modal = {}
    modal.header = '<h4>Payment Failure</h4>'
    modal.body = `<p>It seems the payment did not go through. Please, try it again.</p><p>We have sent you a recovery e-mail to the address below should you want to do it later. But, remember, the <span style="text-decoration:underline">booking is not confirmed yet</span>.</p><p style="font-weight:bold;text-align:center">${localbkg.email}</p><p>Please check your inbox to make sure you received it. If you can&apos;t find it, please check also the Spam/Junk e-mail folder.</p><p>You can modify your e-mail address at anytime with "Edit Customer Details" option.</p>`
    return (
      <MyModal text={modal} liftUp={() => setShowModalTPVKO(false)} />
    )
  }

  function modalNOAVAILABILITY () {
    if (!showModalNOAVAILABILITY) {
      localbkg.tpv_result = ''
      return
    }
    const modal = {}
    modal.header = '<h4>Seats No Longer Available</h4>'
    modal.body = '<p>It seems that it took you a long time to pay for the seats and now they are not available because someone else bought them.</p><p>Please choose "Change Class/Date" to find alternative classes.</p>'
    return (
      <MyModal text={modal} liftUp={() => setShowModalNOAVAILABILITY(false)} />
    )
  }

  function cancelable () {
    return ['CONFIRMED', 'PAID', 'PAY-ON-ARRIVAL'].includes(localbkg.status) &&
     isBefore(new Date(), new Date(localbkg.calendarevent.startdateatom))
  }

  function classChange () {
    if (localbkg.status !== 'PENDING' && differenceInHours(new Date(localbkg.calendarevent.startdateatom), new Date()) < 8) {
      const modal = {}
      modal.header = '<h4>Can&apos;t change the date</h4>'
      modal.body = '<p>The start of class is too close, so if you can&apos;t make it, please let us know by e-mail or phone.</p>'
      setModalContent(modal)
      setShowModal(true)
    } else {
      navigate(`/booking/${localbkg.locator}/availability`)
    }
  }

  return (
    <Fragment>
      {modalTPVOK()}
      {modalTPVKO()}
      {modalNOAVAILABILITY()}
      {showModal && <MyModal text={modalContent} liftUp={() => setShowModal(false)} />}

      <div className='row justify-content-center'>
        <div className='col-12'>
          {localbkg.status === 'PENDING' &&
            <Fragment>
              <h1 className='mt-0'>Checkout</h1>
              <p>You are about to book the following class:</p>
            </Fragment>}
          {['CONFIRMED', 'PAY-ON-ARRIVAL', 'PAID'].includes(localbkg.status) &&
            <Fragment>
              <h1 className='mt-0'>Booking Confirmation</h1>
              <p>These are the details of your booking:</p>
            </Fragment>}
          {localbkg.status === 'CANCELED' &&
            <Fragment>
              <h1 className='mt-0'>Booking Canceled</h1>
              <p>This booking is no longer valid.</p>
            </Fragment>}
        </div>
      </div>

      <InquiryDetails bkg={localbkg} />

      <CustomerDetails bkg={localbkg} />

      <NavButtons>
        {localbkg.locator && cancelable() &&
          <div className='btn btn-secondary' onClick={() => navigate(`/booking/${localbkg.locator}/cancelbooking`)}>Cancel Booking</div>}{' '}
        {localbkg.locator && localbkg.status !== 'PENDING' &&
          <div className='btn btn-secondary' onClick={() => (location.href = '/booking/forget')}>New Booking</div>}{' '}
        {localbkg.locator && !localbkg.fixed_date && localbkg.status !== 'CANCELED' &&
          <div className='btn btn-secondary' onClick={classChange}>Change Class/Date</div>}{' '}
        {localbkg.locator &&
          <div className='btn btn-secondary' onClick={() => navigate(`/booking/${localbkg.locator}/customerdetails`)}>Edit Customer Details</div>}{' '}
        {localbkg.locator && localbkg.status !== 'PENDING' && <VoucherPrintOut bkg={localbkg} />}{' '}
        {localbkg.locator && localbkg.status !== 'PENDING' &&
          <div className='btn btn-primary' onClick={handleEmailVoucher}>E-mail Booking</div>}{' '}
        {localbkg.status === 'PENDING' &&
          <div className='btn btn-primary' onClick={() => (location.href = '/pay/' + localbkg.id)}>Purchase</div>}
        {isError && alert('Error communicating with server, please reload page')}
      </NavButtons>

    </Fragment>
  )
}
