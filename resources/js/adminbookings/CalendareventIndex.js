import React, { useState, useEffect, Fragment } from 'react'
import PropTypes from 'prop-types'
import { format, addDays, subDays } from 'date-fns'
import { navigate } from '@reach/router'
import Modal from 'react-bootstrap/Modal'
import DatePicker from './Components/DatePicker/DatePicker'
// import { NavButtons } from './Components/NavButtons'
import CalendareventRow from './Components/CalendareventRow'
import EventDate from './Components/EventDate'
import { trackPromise } from 'react-promise-tracker'

const axios = require('axios').default

export default CalendareventIndex

CalendareventIndex.propTypes = {
  date: PropTypes.string,
  schedule: PropTypes.array,
  staff: PropTypes.array,
  propagateFn: PropTypes.func
}

function CalendareventIndex (props) {
  const [schedule, setSchedule] = useState(props.schedule)
  const [lastFetchedDate, setLastFetchedDate] = useState(props.date)
  const userRole = document.querySelector('meta[name="user_role"]').content

  const [show, setShow] = useState(false)
  const handleClose = () => setShow(false)
  const handleShow = () => setShow(true)

  useEffect(() => {
    const fetchSchedule = async () => {
      try {
        const result = await axios.get('/api/calendarevent/getschedule/' + props.date)
        setSchedule(result.data)
        setLastFetchedDate(props.date)
        props.propagateFn(result.data)
      } catch (error) {
        console.log(error)
      }
    }
    if (lastFetchedDate !== props.date) {
      console.log(props.date)
      trackPromise(fetchSchedule())
    }
  }, [props.date])

  function handleDateToday () {
    handleClose()
    navigate('/adminbookings/' + format(new Date(), 'yyyy-MM-dd'))
  }

  function handleDateChange (day) {
    handleClose()
    navigate('/adminbookings/' + format(new Date(day), 'yyyy-MM-dd'))
  }

  return (
    <Fragment>
      <div className="text-center">
        <button className="button_day_selector btn btn-primary" onClick={() => navigate('/adminbookings/' + format(subDays(new Date(props.date), 1), 'yyyy-MM-dd'))}>&lt;&lt;</button>
        <button className="button_day_selector btn btn-primary mx-1" onClick={handleShow}>calendario</button>
        <button className="button_day_selector btn btn-primary" onClick={() => navigate('/adminbookings/' + format(addDays(new Date(props.date), 1), 'yyyy-MM-dd'))}>&gt;&gt;</button>
      </div>
      <Modal show={show} onHide={handleClose} animation={false}>
        <div className='text-center mb-1'>
          <br/>
          <DatePicker
            selectedDate={new Date(props.date)}
            onClickFn={handleDateChange}
          />
          <br/>
          <button className="btn btn-primary my-1" onClick={handleDateToday}>hoy</button>
          <br/>
        </div>
      </Modal>
      <h1>
        <EventDate className="dateshown" date={props.date}/>
      </h1>

      <table className="table table-hover" id="calendarevent_table" style={{ minWidth: '80vw' }}>
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
              <CalendareventRow key={row.id} row={row} staff={props.staff} />
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
