import React from 'react'
import PropTypes from 'prop-types'
import { navigate } from '@reach/router'
import { format } from 'date-fns'
import { CookName } from './CookName'

export { CalendareventRow }

CalendareventRow.propTypes = {
  staff: PropTypes.array,
  row: PropTypes.object
}

function CalendareventRow (props) {
  const row = props.row
  const userRole = document.querySelector('meta[name="user_role"]').content
  const calendareventTrClass = (userRole >= 2) ? 'calendarevent_line' : ''

  function editButton () {
    var button
    if (userRole >= 3) {
      const buttonColor = row.info === '' ? 'btn-secondary' : 'btn-primary'
      button = '<button class="btn ' + buttonColor + ' btn-sm">+</button>'
    } else if (row.info !== '') {
      button = '<button class="btn btn-primary btn-sm">+</button>'
    } else {
      button = ''
    }
    return button
  }

  return (
    <tr className={calendareventTrClass} onClick={() => navigate('/adminbookings/' + row.date + '/' + row.id)}>
      <td>{row.time.substring(0, 5)}<br/>({parseInt(row.duration)}{row.duration.substring(3, 4) > '0' ? ',5' : ''} hrs)</td>
      <td>{row.type}</td>
      <td><CookName staff={props.staff} staff_id={row.staff_id} secondstaff_id={row.secondstaff_id}/></td>
      <td>{row.registered}</td>
      <td dangerouslySetInnerHTML={ { __html: editButton() } }/>
    </tr>
  )
}
