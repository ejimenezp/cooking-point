import React, { useState, useEffect, Fragment } from 'react'
import PropTypes from 'prop-types'
import { format, addDays, subDays } from 'date-fns'
import { navigate } from '@reach/router'
// import { NavButtons } from './Components/NavButtons'
import { CalendareventRow } from './Components/CalendareventRow'
import { EventDate } from './Components/EventDate'

const axios = require('axios').default

export default CalendareventIndex

CalendareventIndex.propTypes = {
  date: PropTypes.string,
  schedule: PropTypes.array,
  propagateFn: PropTypes.func
}

function CalendareventIndex (props) {
  const [schedule, setSchedule] = useState(props.schedule)
  const userRole = document.querySelector('meta[name="user_role"]').content

  useEffect(() => {
    const fetchSchedule = async () => {
      try {
        const result = await axios.get('/api/calendarevent/getschedule/' + props.date)
        setSchedule(result.data)
        props.propagateFn(result.data)
      } catch (error) {
        console.log(error)
      }
    }
    fetchSchedule()
  }, [props.date])

  function handleDateUp () {
    navigate('/adminbookings/' + format(addDays(new Date(props.date), 1), 'yyyy-MM-dd'))
  }

  function handleDateDown () {
    navigate('/adminbookings/' + format(subDays(new Date(props.date), 1), 'yyyy-MM-dd'))
  }

  function handleDateToday () {
    navigate('/adminbookings/' + format(new Date(), 'yyyy-MM-dd'))
  }

  return (
    <Fragment>
      <div className="text-center">
        <button className="button_day_selector btn btn-primary mr-1" onClick={handleDateDown}>&lt;&lt;</button>
        <button className="button_day_selector btn btn-primary mr-1" onClick={handleDateToday}>Hoy</button>
        <button className="button_day_selector btn btn-primary" onClick={handleDateUp}>&gt;&gt;</button>
      </div>
      <h1>
        <EventDate className="dateshown" date={props.date}/>
      </h1>

      <table className="table table-hover" id="calendarevent_table">
        <thead>
          <tr>
            <th>Hora</th>
            <th>Tipo</th>
            <th>Chef</th>
            <th>Pax</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          {schedule.map((row) => {
            return (
              <CalendareventRow key={row.id} row={row} />
            )
          })
          }
        </tbody>
      </table>
      {userRole >= 3 && <button className="btn btn-primary button_calendarevent_edit" data-i="-1">Nuevo Evento</button> }
      <div className="gutter"></div>
    </Fragment>
  )
}
