import React, { useState, Fragment } from 'react'
import PropTypes from 'prop-types'
import { format, addDays, subDays } from 'date-fns'
import { es } from 'date-fns/locale'
import { navigate } from '@reach/router'
// import { NavButtons } from './Components/NavButtons'
import { BookingRow } from './Components/BookingRow'
import { EventDate } from './Components/EventDate'

export default BookingIndex

BookingIndex.propTypes = {
  ceId: PropTypes.string,
  schedule: PropTypes.array
}

function BookingIndex (props) {
  const userRole = document.querySelector('meta[name="user_role"]').content
  const calendarevent = props.schedule.find((calendarevent) => calendarevent.id === parseInt(props.ceId))
  const bookings = calendarevent.bookings


  function handleShowDay () {
    navigate('/adminbookings/' + calendarevent.date)
  }

  return (
    <Fragment>
      <div className="text-center">
        <button className="button_day_selector btn btn-primary mr-1" >&lt;&lt;</button>
        <button className="button_day_selector btn btn-primary mr-1" onClick={handleShowDay}>{format(new Date(calendarevent.date), 'EEEE', { locale: es })}</button>
        <button className="button_day_selector btn btn-primary" >&gt;&gt;</button>
      </div>
      <h1>
        <EventDate className="dateshown" date={calendarevent.date}/>
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
      {userRole >= 3 && <button className="btn btn-primary">Nueva Reserva</button> }
    </Fragment>
  )

}
