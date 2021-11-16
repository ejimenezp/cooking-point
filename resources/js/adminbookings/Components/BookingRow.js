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

  function editButton () {
    var button
    if (userRole >= 3) {
      const buttonColor = row.info === '' ? 'btn-secondary' : 'btn-primary'
      button = '<button class="btn ' + buttonColor + ' btn-sm">Detalles</button>'
    } else if (row.info !== '') {
      button = '<button class="btn btn-primary btn-sm">+info</button>'
    } else {
      button = ''
    }
    return button
  }

  const registered = '' + row.adult + (row.child > 0) ? '+' + row.child : ''

  return (
    <tr className={calendareventTrClass} onClick={() => navigate('/adminbookings/booking/:id' + row.id)}>
      <td><span>{registered}</span></td>
      <td>{row.name}</td>
      <td>{row.status}</td>
      <td>{row.alergies}</td>
      <td>{row.comments}</td>
    </tr>
  )
}
