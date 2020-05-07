import React from 'react'
import PropTypes from 'prop-types'
import { Day } from './Day'
import { addDays, isSameDay, format } from 'date-fns'

export { Week }


Week.propTypes = {
  startOfWeek: PropTypes.instanceOf(Date),
  selectedDate: PropTypes.instanceOf(Date),
  availabilityFn: PropTypes.func,
  onClickFn: PropTypes.func
}

function Week ({ startOfWeek, selectedDate, availabilityFn, onClickFn }) {
  function renderDays () {
    const days = []
    return days.concat(
      [0, 1, 2, 3, 4, 5, 6].map(offset => {
        const day = addDays(startOfWeek, offset)
        return (
          <Day
            key={format(day, 'yyyy-MM-dd')}
            date={day}
            selected={isSameDay(day, selectedDate)}
            availabilityFn={availabilityFn}
            onClickFn={onClickFn}
          />
        )
      })
    )
  }
  return (
    <div className='react-datepicker-week'>{renderDays()}</div>
  )
}
