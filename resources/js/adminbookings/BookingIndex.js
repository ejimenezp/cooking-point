import React, { useState, useEffect, Fragment } from 'react'
import PropTypes from 'prop-types'
import { format, addDays, subDays } from 'date-fns'
import { navigate } from '@reach/router'
// import { NavButtons } from './Components/NavButtons'
import { BookingRow } from './Components/BookingRow'
import { EventDate } from './Components/EventDate'

const axios = require('axios').default

export default BookingIndex

BookingIndex.propTypes = {
  id: PropTypes.string,
  options: PropTypes.object
}

function BookingIndex (props) {
  const [bookings, setBookings] = useState()
  const userRole = document.querySelector('meta[name="user_role"]').content

  useEffect(() => {
    const fetchBookings = async () => {
      try {
        const result = await axios.get('/api/booking/index/' + props.id)
        setBookings(result.data)
      } catch (error) {
        console.log(error)
      }
    }
    fetchBookings()
  }, [props.id])

  return (
    <Fragment>
      <div className="text-center">
        <button className="button_day_selector btn btn-primary" onClick={''}>&lt;&lt;</button>
        <button className="button_day_selector btn btn-primary" onClick={''}>Ahora</button>
        <button className="button_day_selector btn btn-primary" onClick={''}>&gt;&gt;</button>
      </div>
      <h1>
        <EventDate className="dateshown" date={'1979-02-28'}/>
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
          {bookings.map((row, index) => {
            return (
              <BookingRow key={index} row={row} options={props.options}/>
            )
          })
          }
        </tbody>}
      </table>
      {userRole >= 3 && <button className="btn btn-primary">Nueva Reserva</button> }
    </Fragment>
  )

}
