import React, { useState, useEffect, Fragment } from 'react'
import PropTypes from 'prop-types'
import { format, parseISO, isSameDay, startOfMonth, endOfMonth, addDays, subDays } from 'date-fns'
import { useMediaQuery } from 'react-responsive'
import { utcToZonedTime } from 'date-fns-tz'
import { navigate } from '@reach/router'
import { useQuery } from 'react-query'
import { InquiryDetailsEdit } from './InquiryDetails'
import DatePicker from './Components/DatePicker/DatePicker'
import { MyModal } from './Components/Modal'
import myFetch from '../Components/myFetch'
import { NavButtons } from './Components/NavButtons'

const _ = require('lodash')
const axios = require('axios').default

export default AvailabilityPage

AvailabilityPage.propTypes = {
  liftUp: PropTypes.func,
  bkg: PropTypes.object
}

function AvailabilityPage (props) {
  const [localbkg, setBkg] = useState(Object.assign({}, props.bkg))
  const isMobile = useMediaQuery({ maxWidth: 575 })

  const [data, setData] = useState([])
  const [url, setUrl] = useState(createUrl(localbkg.date))
  /** ddate: day selected on the datepicker */
  const [ddate, setDate] = useState(utcToZonedTime(parseISO(props.bkg.date), props.bkg.tz))
  /** dday: pivot to navigate through months */
  const [dday, setDay] = useState(new Date(parseISO(localbkg.date)))

  const [modalContent, setModalContent] = useState('')
  const [showModal, setShowModal] = useState(false)

  useEffect(() => {
    if (isMobile) window.scrollTo(0, 0)
  }, [])

  function handleChange (bkg) {
    let b = Object.assign({}, localbkg)
    handleDateChange(utcToZonedTime(parseISO(bkg.date), bkg.tz))
    setUrl(createUrl(dday))
    b = { ...b, ...bkg }
    b.store = true
    setBkg(b)
  }

  function valid () {
    const modal = {}
    modal.header = '<h4>Please check your data</h4>'
    modal.body = ''
    setShowModal(false)

    if (typeof localbkg.calendarevent === 'undefined' ||
      !available(utcToZonedTime(parseISO(localbkg.calendarevent.startdateatom), localbkg.tz))) { modal.body += 'Select a day with availability <br/>' }
    if (localbkg.onlineclass) {
      if (localbkg.adult < 2) { modal.body += 'For online classes, guests must be at least 2 adult<br/>' }
    } else {
      if (!localbkg.adult) { modal.body += 'Select number of guests (Min. 1 adult) <br/>' }
    }
    const filter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/
    if (localbkg.email && !filter.test(localbkg.email)) { modal.body += 'Enter a valid e-mail <br/>' }

    if (modal.body !== '') {
      setModalContent(modal)
      setShowModal(true)
      return false
    }
    return true
  }

  function handleButtonContinue () {
    if (valid()) {
      props.liftUp(localbkg)
      navigate('/booking/new/customerdetails')
    }
  }

  function handleButtonSave () {
    if (valid()) {
      props.liftUp(localbkg)
      navigate('/booking/' + localbkg.locator)
    }
  }

  function handleButtonCancel () {
    navigate('/booking/' + localbkg.locator)
  }

  function available (day) {
    const i = _.findIndex(data, (d) => isSameDay(utcToZonedTime(parseISO(d.startdateatom), localbkg.tz), day) && d.type === localbkg.type)
    if (i === -1) {
      return false
    }
    return data[i].available
  }

  function createUrl (date) {
    const ldate = new Date(date)
    const intervalStart = format(subDays(startOfMonth(ldate), 6), 'yyyy-MM-dd')
    const intervalEnd = format(addDays(endOfMonth(ldate), 6), 'yyyy-MM-dd')
    return `/api/calendarevent/getavailability?online=${localbkg.onlineclass}&start=${intervalStart}&end=${intervalEnd}&persons=${localbkg.adult + localbkg.child}`
  }

  function handleDateChange (day) {
    setDate(day)
    const event = data[_.findIndex(data, (d) => isSameDay(utcToZonedTime(parseISO(d.startdateatom), localbkg.tz), day) && d.type === localbkg.type)]
    if (typeof event !== 'undefined') {
      localbkg.date = event.startdateatom
      localbkg.calendarevent_id = event.id
      localbkg.calendarevent = Object.assign({}, event)
    }
    localbkg.store = true
  }

  function handleMonthChange (day) {
    setUrl(createUrl(day))
    setDay(day)
  }

  const { result, isLoading, isError } = useQuery(url,
    () => myFetch(url),
    {
      onSuccess: (result) => {
        const aux = result.replace(/x06/g, '5')
        const clearData = JSON.parse(atob(aux))
        // const clearData = result.data
        setData(clearData)
      }
    }
  )

  // useEffect(() => {
  //   if (typeof result !== 'undefined') {
  //     const aux = result.replace(/x06/g, '5')
  //     const clearData = JSON.parse(atob(aux))
  //     // const clearData = result.data
  //     setData(clearData)
  //   }
  // }, [result])

  return (
    <div>
      {showModal && <MyModal text={modalContent} liftUp={() => setShowModal(false)} />}
      <div className='row'>
        <div className='col-12'>
          {localbkg.status === 'PENDING' &&
            <Fragment>
              <h1 className='mt-0'>New Booking</h1>
              <p className='mb-0'>Select number of guests and class to check availability.</p>
            </Fragment>
          }
          { ['CONFIRMED', 'PAY-ON-ARRIVAL', 'PAID'].includes(localbkg.status) &&
            <Fragment>
              <h1 className='mt-0'>Your Booking</h1>
              <p>You can change class and booking date:</p>
            </Fragment>
          }
        </div>
      </div>
      <div className='row justify-content-center'>
        <div className='col-12 col-lg-6'>
          <InquiryDetailsEdit liftUp={handleChange} bkg={localbkg} />
        </div>
        <div className='col-12 col-sm-8 col-md-6 col-lg-5'>
          {isError && <div>Something went wrong... please, reload the page</div>}
          {!isError && (
            <div className='text-center'>
              <DatePicker
                selectedDate={ddate}
                availabilityFn={available}
                changeMonthFn={handleMonthChange}
                onClickFn={handleDateChange}
              />
            </div>
          )}
        </div>
      </div>
      <NavButtons>
        {!localbkg.locator && <div className='btn btn-primary' onClick={handleButtonContinue}>Continue</div>}
        {localbkg.locator && <div className='btn btn-secondary' onClick={handleButtonCancel}>Cancel</div>}{' '}
        {localbkg.locator && <div className='btn btn-primary' onClick={handleButtonSave}>Save</div>}
      </NavButtons>
    </div>
  )
}
