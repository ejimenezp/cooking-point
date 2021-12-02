import React from 'react'
import PropTypes from 'prop-types'
import { navigate } from '@reach/router'
import { format } from 'date-fns'

export { BookingRow }

BookingRow.propTypes = {
  row: PropTypes.object
}

function BookingRow (props) {
  const row = props.row
  const userRole = document.querySelector('meta[name="user_role"]').content
  const calendareventTrClass = (userRole >= 2) ? 'calendarevent_line' : ''

  return (
    <tr className={calendareventTrClass} onClick={() => navigate('/adminbookings/' + row.date + '/' + row.calendarevent_id + '/' + row.id)}>
      <td>{row.adult}{(row.child > 0) && <span>+{row.child} </span>}</td>
      <td>{row.name}</td>
      <td>{row.status}</td>
      <td>{row.alergies}</td>
      <td>{row.comments}</td>
    </tr>
  )
}
