import React from 'react'
import PropTypes from 'prop-types'
import { Week } from './Week'

import { addDays, startOfWeek, format, isSameMonth } from 'date-fns'

export { Month }

Month.propTypes = {
  first: PropTypes.instanceOf(Date),
  selectedDate: PropTypes.instanceOf(Date),
  availabilityFn: PropTypes.func,
  onClickFn: PropTypes.func
}

function Month ({ first, selectedDate, availabilityFn, onClickFn }) {
  function renderWeeks () {
    const weeks = []
    let day = startOfWeek(first, {weekStartsOn: 1})
    do {
      weeks.push(
        <Week
          key={format(day, 'yyyy-MM-dd')}
          startOfWeek={day}
          selectedDate={selectedDate}
          availabilityFn={availabilityFn}
          onClickFn={onClickFn}
        />
      )
      day = addDays(day, 7)
    } while (isSameMonth(first, day))

    return weeks
  }

  return (
    <div className='react-datepicker-month'>{renderWeeks()}</div>
  )
}
