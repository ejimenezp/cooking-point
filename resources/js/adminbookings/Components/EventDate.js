import React from 'react'
import PropTypes from 'prop-types'
import { format } from 'date-fns'
import { es } from 'date-fns/locale'

export default EventDate

EventDate.propTypes = {
  date: PropTypes.string
}

function EventDate (props) {
  const ddate = new Date(props.date)

  return (
    <span>{format(ddate, 'EEEE, d MMMM', { locale: es })}</span>
  )
}
