import React, { Fragment } from 'react'
import PropTypes from 'prop-types'
import { format } from 'date-fns'
import { es } from 'date-fns/locale'
import { navigate } from '@reach/router'
import { NavButtons } from './Components/NavButtons'
import BookingRow from './Components/BookingRow'

export default BookingIndex

BookingIndex.propTypes = {
  ceId: PropTypes.string,
  schedule: PropTypes.array,
  uri: PropTypes.string
}

function BookingIndex (props) {
  const userRole = document.querySelector('meta[name="user_role"]').content
  const calendarevent = props.schedule.find((calendarevent) => calendarevent.id === parseInt(props.ceId))
  const bookings = calendarevent.bookings

  function handlePrevEvent () {
    const ceIndex = props.schedule.indexOf(calendarevent)
    if (ceIndex > 0) {
      navigate('/adminbookings/' + calendarevent.date + '/' + props.schedule[ceIndex - 1].id)
    }
  }

  function handleNextEvent () {
    const ceIndex = props.schedule.indexOf(calendarevent)
    if (ceIndex < props.schedule.length - 1) {
      navigate('/adminbookings/' + calendarevent.date + '/' + props.schedule[ceIndex + 1].id)
    }
  }

  return (
    <Fragment>
      <div className="text-center">
        <button className="button_day_selector btn btn-primary " onClick={handlePrevEvent}>&lt;&lt;</button>
        <button className="button_day_selector btn btn-primary mx-1" onClick={() => navigate('/adminbookings/' + calendarevent.date)}>{format(new Date(calendarevent.date), 'EEEE', { locale: es })}</button>
        <button className="button_day_selector btn btn-primary" onClick={handleNextEvent}>&gt;&gt;</button>
      </div>
      <h1>
        {calendarevent.time.substring(0, 5)} {calendarevent.type} Reg {calendarevent.registered} Avail {calendarevent.availablecovid}
      </h1>

      <table className="table table-hover" id="calendarevent_table">
        <thead>
          <tr>
            <th>Pax</th>
            <th>Nombre</th>
            <th>Status</th>
            <th>Alergias</th>
            <th>Coment.</th>
          </tr>
        </thead>
        {bookings !== undefined &&
        <tbody>
          {bookings.map((row) => {
            return (
              <BookingRow key={row.id} row={row} />
            )
          })
          }
        </tbody>}
      </table>
      {userRole >= 3 &&
        <NavButtons id='foo'>
          <></>
          <div className='btn btn-primary' onClick={() => navigate(props.uri + '/add')}>Nueva Reserva</div>
        </NavButtons>
      }
    </Fragment>
  )
}
