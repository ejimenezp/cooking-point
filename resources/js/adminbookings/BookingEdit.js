import React, { useState, useEffect, Fragment } from 'react'
import PropTypes from 'prop-types'
import { format, addDays, subDays } from 'date-fns'
import { navigate } from '@reach/router'
// import { NavButtons } from './Components/NavButtons'
import { BookingRow } from './Components/BookingRow'
import { EventDate } from './Components/EventDate'

const axios = require('axios').default

export default BookingEdit

BookingEdit.propTypes = {
  ceId: PropTypes.string,
  bkgId: PropTypes.string,
  schedule: PropTypes.array,
  propagateFn: PropTypes.func
}

function BookingEdit (props) {
  const calendarevent = props.schedule.find((calendarevent) => calendarevent.id === parseInt(props.ceId))
  const bookings = calendarevent.bookings
  const [bkg, setBkg] = useState(bookings.find((b) => b.id === parseInt(props.bkgId)))

  const userRole = document.querySelector('meta[name="user_role"]').content

  function handleChange (event) {
    setBkg({
      ...bkg,
      [event.target.name]: event.target.value,
      changed: 1
    })
  }

  function handleButtonSave () {
    if (bkg.changed) {
      (async () => {
        try {
          const result = await axios.post('/api/booking/adminUpdate', bkg)
          props.propagateFn(result.data)
        } catch (error) {
          console.log(error)
        }
      })()
    }
    navigate('/adminbookings/' + bkg.date + '/' + bkg.calendarevent_id)
  }

  const adults = []
  for (let i = 1; i < 25; i++) adults.push(i)
  const children = []
  for (let i = 0; i < 25; i++) children.push(i)

  return (
    <Fragment>
      <table id="booking" className="table">
        <tbody>
          <tr>
            <td>
                Nombre:
            </td>
            <td>
              <input name='name' type='text' value={bkg.name || ''} onChange={handleChange} />
            </td>
          </tr>
          <tr>
            <td>
                Fuente:
            </td>
            <td>
              <select id="sourcelist" name="source_id">
              </select>
            </td>
          </tr>
          <tr>
            <td>
                Estado:
            </td>
            <td>
              <select name="status" value={bkg.status} onChange={handleChange}>
                <option value="PAID">PAID</option>
                <option value="CONFIRMED">CONFIRMED</option>
                <option value="PAY-ON-ARRIVAL">PAY-ON-ARRIVAL</option>
                <option value="PENDING">PENDING</option>
                <option value="CANCELED">CANCELED</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>
                Teléfono:
            </td>
            <td>
              <input name='phone' type='text' value={bkg.phone || ''} onChange={handleChange} />
            </td>
          </tr>
          <tr>
            <td>
                Email:
            </td>
            <td>
              <input name='email' type='email' value={bkg.email || ''} onChange={handleChange} />
            </td>
          </tr>
          <tr>
            <td>
                Adultos:
            </td>
            <td>
              <select name="adult" value={bkg.adult} onChange={handleChange}>
                {adults.map(option => (
                  <option key={option} value={option}>
                    {option}
                  </option>
                ))}
                <option value="0">0</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>
                Niños:
            </td>
            <td>
              <select name="child" value={bkg.child} onChange={handleChange}>
                {children.map(option => (
                  <option key={option} value={option}>
                    {option}
                  </option>
                ))}
              </select>
            </td>
          </tr>
          <tr>
            <td>
                Alergias:
            </td>
            <td>
              <textarea rows='3' name='food_requirements' value={bkg.food_requirements || ''} onChange={handleChange} />
            </td>
          </tr>
          <tr>
            <td>
                Comentarios:
            </td>
            <td>
              <textarea rows='3' name='comments' value={bkg.comments || ''} onChange={handleChange} />
            </td>
          </tr>
          <tr className='details'>
            <td>
                Referencia:
            </td>
            <td>
              {bkg.locator} <button id="button_booking_copy" className="btn btn-primary btn-sm">Copiar</button>
            </td>
          </tr>
          <tr className='details'>
            <td>
                Seguimiento:
            </td>
            <td>
              <select name="crm" value={bkg.crm} onChange={handleChange}>
                <option value="YES">SÍ</option>
                <option value="NO">NO MOLESTAR</option>
                <option value="PAYMENT_KO">FALLO PAGO TARJETA</option>
                <option value="REMINDED">ENVIADO RECORDATORIO</option>
                <option value="REVIEW_ASKED">SOLICITADA REVIEW</option>
              </select>
            </td>
          </tr>
          <tr className='details'>
            <td>
                Forma de pago:
            </td>
            <td>
              <select name="pay_method" value={bkg.pay_method} onChange={handleChange}>
                <option value="ONLINE">ONLINE</option>
                <option value="CARD">TARJETA</option>
                <option value="CASH">EFECTIVO</option>
                <option value="TRANSFER">TRANSFERENCIA</option>
                <option value="PAYPAL">PAYPAL</option>
                <option value="N/A">(no aplica)</option>
              </select>
            </td>
          </tr>
          <tr className='details'>
            <td>
                Fecha pago:
            </td>
            <td>
              <input name="payment_date" type="text" value={bkg.payment_date} onChange={handleChange} />
            </td>
          </tr>
          <tr className="price details ">
            <td>
                Precio:
            </td>
            <td>
              <input type="text" name="price" value={bkg.price} onChange={handleChange} />
            </td>
          </tr>
          {userRole >= 3 && <Fragment>
            <tr className='details d-none'>
              <td>
                  IVA:
              </td>
              <td>
                <input type="checkbox" name="iva" value={bkg.iva} onChange={handleChange} />
              </td>
            </tr>
            <tr className='details'>
              <td>
                  Ocultar precio:
              </td>
              <td>
                <input type="checkbox" name="hide_price" value="1" onChange={handleChange} />
              </td>
            </tr>
            <tr className='details'>
              <td>
                  Fecha fija:
              </td>
              <td>
                <input type="checkbox" name="fixed_date" value={bkg.fixed_date} onChange={handleChange} />
              </td>
            </tr>
            <tr className='details'>
              <td>
                  Factura:
              </td>
              <td>
                <input type="text" name="invoice" value={bkg.invoice} onChange={handleChange} />
              </td>
            </tr>
          </Fragment>}

          <tr className="booking_date_input details">
            <td>
                Fecha:
            </td>
            <td>
              <input type="text" id="booking_date_edit" />
              <input type="hidden" name="date" id="bookingNewDate" />
            </td>
          </tr>
          <tr className="booking_date_input details">
            <td>
                Evento:
            </td>
            <td>
              <select id="dayeventlist" name="type">
              </select>
            </td>
          </tr>
        </tbody>
      </table>
      <div className='btn btn-primary' onClick={handleButtonSave}>Save</div>
    </Fragment>
  )
}
