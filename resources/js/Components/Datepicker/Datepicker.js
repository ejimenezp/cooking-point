import React, { useState } from 'react'
import PropTypes from 'prop-types'
import { startOfMonth, format } from 'date-fns'
import Col from 'react-bootstrap/Col'

import MyButton from '../MyButton'
import MyButtonGroup from '../MyButtonGroup'
import { Month } from './Month'
import { Header } from './Header'
import './DatePicker.scss'

export default DatePicker

DatePicker.propTypes = {
  selectedDate: PropTypes.instanceOf(Date),
  availabilityFn: PropTypes.func,
  onClickFn: PropTypes.func
}

function DatePicker ({ selectedDate, availabilityFn, onClickFn }) {
  const [first, setFirst] = useState(startOfMonth(selectedDate))

  function handleChangeMonthFn (newFirst) {
    setFirst(newFirst)
  }

  return (

    <>
      <Col md={{ span: 6, offset: 3 }} className="rounded border border-primary">

        <Header
          first={first}
          changeMonthFn={handleChangeMonthFn}
        />

        <Month
          key={format(first, 'yyyy-MM-dd')}
          first={first}
          selectedDate={selectedDate}
          availabilityFn={availabilityFn}
          onClickFn={onClickFn}
        />
      </Col>
      <MyButtonGroup>
        <MyButton onClick={() => onClickFn(new Date())}><i className="fs-1 bi bi-calendar-event"></i></MyButton>
      </MyButtonGroup>
    </>

  )
}
