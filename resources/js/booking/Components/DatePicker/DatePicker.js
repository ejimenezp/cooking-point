import React, { useState } from 'react'
import PropTypes from 'prop-types'
import { Month } from './Month'
import { Header } from './Header'

import { startOfMonth, format } from 'date-fns'

export default DatePicker

DatePicker.propTypes = {
  selectedDate: PropTypes.instanceOf(Date),
  availabilityFn: PropTypes.func,
  changeMonthFn: PropTypes.func,
  onClickFn: PropTypes.func
}

function DatePicker ({ selectedDate, availabilityFn, changeMonthFn, onClickFn }) {
  const [first, setFirst] = useState(startOfMonth(selectedDate))

  function handleChangeMonthFn (newFirst) {
    setFirst(newFirst)
    changeMonthFn(newFirst)
  }

  return (
    <div className='react-datepicker react-datepicker-month-container'>

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
    </div>
  )
}
