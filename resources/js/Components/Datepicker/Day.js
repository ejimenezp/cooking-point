import React from 'react'
import PropTypes from 'prop-types'
import classnames from 'classnames'
import { getDate } from 'date-fns'

export { Day }

Day.propTypes = {
  date: PropTypes.instanceOf(Date),
  selected: PropTypes.bool,
  availabilityFn: PropTypes.func,
  onClickFn: PropTypes.func
}

function Day ({ date, selected, availabilityFn, onClickFn }) {
  const day = getDate(date)

  function getClassNames (date) {
    return classnames(
      'react-datepicker-day',
      {
        'react-datepicker-day-selected': selected
      }
    )
  }

  return (
    <div className={getClassNames(date)} onClick={() => onClickFn(date) }>{day}</div>
  )
}
