import React from 'react'
import PropTypes from 'prop-types'
import { format, addMonths, subMonths } from 'date-fns'

export { Header }

Header.propTypes = {
  first: PropTypes.instanceOf(Date),
  changeMonthFn: PropTypes.func
}

function Header ({ first, changeMonthFn }) {
  const days = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'].map((day) =>
    <div key={day} className='react-datepicker-day-name'>{day}</div>)
  return (
    <div className='react-datepicker-header'>
      <div className='react-datepicker-current-month'>{format(first, 'LLLL yyyy')}</div>
      <button
        className='react-datepicker-navigation react-datepicker-navigation-previous'
        onClick={() => changeMonthFn(subMonths(first, 1))}
      />
      <button
        className='react-datepicker-navigation react-datepicker-navigation-next'
        onClick={() => changeMonthFn(addMonths(first, 1))}
      />
      <div className='react-datepicker-day-names'>
        {days}
      </div>

    </div>
  )
}
