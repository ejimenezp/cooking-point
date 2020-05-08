import React, { useState, useEffect } from 'react'
import PropTypes from 'prop-types'
import { format, parseISO, isSameDay, isBefore, differenceInHours, startOfMonth, endOfMonth, addDays, subDays } from 'date-fns'
import { navigate } from '@reach/router'
import { InquiryDetailsEdit } from './InquiryDetails'
import DatePicker from './Components/DatePicker/DatePicker'
import { MyModal } from './Components/Modal'
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
  const now = new Date()

  const [data, setData] = useState([])
  const [url, setUrl] = useState(createUrl(localbkg.date))
  const [isError, setIsError] = useState(false)
  /** ddate: day selected on the datepicker */
  const [ddate, setDate] = useState(new Date(parseISO(props.bkg.date)))
  /** dday: pivot to navigate through months */
  const [dday, setDay] = useState(new Date(parseISO(localbkg.date)))

  const [modalContent, setModalContent] = useState('')
  const [showModal, setShowModal] = useState(false)

  function handleChange (bkg) {
    let b = Object.assign({}, localbkg)
    b = { ...b, ...bkg }
    b.store = true
    setBkg(b)
  }

  function valid () {
    const modal = {}
    modal.header = '<h4>Please check your data</h4>'
    modal.body = ''
    setShowModal(false)

    if (!available(new Date(localbkg.date))) { modal.body += 'Select a day with availability <br/>' }
    if (!localbkg.adult) { modal.body += 'Select number of guests (Min. 1 adult) <br/>' }
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
    const i = _.findIndex(data, (d) => isSameDay(d.day, day) && d.type === localbkg.type)
    if (i === -1) {
      return false
    }
    const event = data[i]
    const persons = localbkg.adult + localbkg.child
    if (isBefore(event.day, now)) return false
    if (persons > event.capacity - event.registered) return false
    if (differenceInHours(event.day, now) < 24 && event.registered === 0 && persons === 1) return false
    if (event.type === 'TAPAS' && event.registered === 0 && differenceInHours(event.day, now) < 8) return false
    if (event.type === 'PAELLA' && event.registered === 0 && differenceInHours(event.day, now) < 12) return false
    if (differenceInHours(event.day, now) < 2) return false
    return true
  }

  function createUrl (date) {
    const ldate = new Date(date)
    const intervalStart = format(subDays(startOfMonth(ldate), 37), 'yyyy-MM-dd')
    const intervalEnd = format(addDays(endOfMonth(ldate), 37), 'yyyy-MM-dd')
    return `/api/calendarevent/getavailability?start=${intervalStart}&end=${intervalEnd}`
  }

  function handleDateChange (day) {
    setDate(day)
    localbkg.date = format(day, 'yyyy-MM-dd')
    const event = data[_.findIndex(data, (d) => isSameDay(d.day, day) && d.type === localbkg.type)]
    localbkg.date = event.date
    localbkg.calendarevent_id = event.id
    localbkg.calendarevent = Object.assign({}, event)
    localbkg.store = true
  }

  function handleMonthChange (day) {
    setUrl(createUrl(day))
    setDay(day)
  }

  useEffect(() => {
    const fetchData = async () => {
      setIsError(false)
      try {
        const result = await axios(url)
        const aux = result.data.replace(/x06/g, '5')
        const clearData = JSON.parse(atob(aux))
        clearData.map(function (item) {
          item.day = new Date(parseISO(item.date + ' ' + item.time))
        })
        setData(clearData)
      } catch (error) {
        setIsError(true)
      }
    }
    setUrl(createUrl(dday))
    fetchData()
  }, [url])

  return (
    <div>
      {showModal && <MyModal text={modalContent} liftUp={() => setShowModal(false)} />}
      <div className='row'>
        <div className='col-12'>
          <h1>Booking</h1>
          {localbkg.status === 'PENDING' && <p>Select number of guests and class to check availability.</p>}
          {['CONFIRMED', 'GUARANTEE', 'PAID'].includes(localbkg.status) && <p>You can change class and booking date:</p>}
        </div>
      </div>
      <div className='row justify-content-center'>
        <div className='col-md-4'>
          <InquiryDetailsEdit liftUp={handleChange} bkg={localbkg} />
        </div>
        <div className='col-md-4'>
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