import React from 'react'
import PropTypes from 'prop-types'
import { navigate } from '@reach/router'
import { format } from 'date-fns'
import { CookName } from './CookName'

export { CalendareventRow }

CalendareventRow.propTypes = {
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
      button = '<button class="btn ' + buttonColor + ' btn-sm">Detalles</button>'
    } else if (row.info !== '') {
      button = '<button class="btn btn-primary btn-sm">+info</button>'
    } else {
      button = ''
    }
    return button
  }

  return (
    <tr className={calendareventTrClass} onClick={() => navigate('/adminbookings/' + row.date + '/' + row.id)}>
      <td>{row.time.substring(0, 5)} ({format(new Date('1970-01-01T' + row.duration), 'h:mm')} hrs)</td>
      <td>{row.type}</td>
      <td><CookName calendarevent={row} /></td>
      <td>{row.registered}</td>
      <td dangerouslySetInnerHTML={ { __html: editButton() } }/>
    </tr>
  )
}
