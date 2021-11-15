import React from 'react'
import PropTypes from 'prop-types'
import { navigate } from '@reach/router'
import { format } from 'date-fns'
import { CookName } from './Components/CookName'

export { CalendareventRow }

CalendareventRow.propTypes = {
  row: PropTypes.object,
  options: PropTypes.object
}

function CalendareventRow (props) {
  const row = props.row
  const options = props.options
  const userRole = document.querySelector('meta[name="user_role"]').content

  const cookName = (id) => {
    if (options === undefined) return ''
    for (var i = 0; i < options.staff.length; i++) {
      if (options.staff[i].id === id) {
        return options.staff[i].name
      }
    }
  }
  const calendareventTrClass = (userRole >= 2) ? 'calendarevent_line' : ''
  var secondStaffName = (row.secondstaff_id === 2 ? '' : ', ' + cookName(row.secondstaff_id))

  return (
    <tr className={calendareventTrClass} onClick={() => navigate('/adminbookings/bookingindex/' + row.id)}>
      <td>{row.time.substring(0, 5)} ({format(new Date('1970-01-01T' + row.duration), 'h:mm')} hrs)</td>
      <td>{row.type}</td>
      <td>{(options !== undefined) && (cookName(row.staff_id) + secondStaffName)}</td>
      <td><CookName calendarevent={row} /></td>
    </tr>
  )
}
