import React, { useState, Fragment } from 'react'
import PropTypes from 'prop-types'
import { navigate } from '@reach/router'
// import { NavButtons } from './Components/NavButtons'

export default BookingView

BookingView.propTypes = {
  ceId: PropTypes.string,
  bkgId: PropTypes.string,
  schedule: PropTypes.array,
  uri: PropTypes.string
}

function BookingView (props) {
  const calendarevent = props.schedule.find((calendarevent) => calendarevent.id === parseInt(props.ceId))
  const bookings = calendarevent.bookings
  const [bkg, setBkg] = useState(bookings.find((b) => b.id === parseInt(props.bkgId)))

  const userRole = document.querySelector('meta[name="user_role"]').content

  function handleShowEvent () {
    navigate('/adminbookings/' + calendarevent.date + '/' + calendarevent.id)
  }

  function handlePrevBkg () {
    const bkgIndex = bookings.indexOf(bkg)
    if (bkgIndex > 0) {
      setBkg(bookings[bkgIndex - 1])
      navigate('/adminbookings/' + bkg.date + '/' + bkg.calendarevent_id + '/' + bookings[bkgIndex - 1].id)
    }
  }

  function handleNextBkg () {
    const bkgIndex = bookings.indexOf(bkg)
    if (bkgIndex < bookings.length - 1) {
      setBkg(bookings[bkgIndex + 1])
      navigate('/adminbookings/' + bkg.date + '/' + bkg.calendarevent_id + '/' + bookings[bkgIndex + 1].id)
    }
  }

  function handleChange (event) {
    setBkg({
      ...bkg,
      [event.target.name]: event.target.value,
      changed: 1
    })
  }

  return (
    <Fragment>
      <div className="text-center">
        <button className="button_day_selector btn btn-primary " onClick={handlePrevBkg}>&lt;&lt;</button>
        <button className="button_day_selector btn btn-primary mx-1" onClick={handleShowEvent}>{calendarevent.type}</button>
        <button className="button_day_selector btn btn-primary" onClick={handleNextBkg}>&gt;&gt;</button>
      </div>
      <h1>
        {bkg.adult}{(bkg.child > 0) && <span>+{bkg.child} </span>} {bkg.name}
      </h1>
      <table id="booking" className="table">
        <tbody>
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
              {bkg.status}
            </td>
          </tr>
          <tr>
            <td>
                Teléfono:
            </td>
            <td>
              {bkg.phone}
            </td>
          </tr>
          <tr>
            <td>
                Email:
            </td>
            <td>
              {bkg.email}
            </td>
          </tr>
          <tr>
            <td>
                Alergias:
            </td>
            <td>
              {bkg.food_requirements}
            </td>
          </tr>
          <tr>
            <td>
                Comentarios:
            </td>
            <td>
              {bkg.comments}
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
              {bkg.crm}
            </td>
          </tr>
          <tr className='details'>
            <td>
                Forma de pago:
            </td>
            <td>
              {bkg.pay_method}
            </td>
          </tr>
          <tr className='details'>
            <td>
                Fecha pago:
            </td>
            <td>
              {bkg.payment_date}
            </td>
          </tr>
          <tr className="price details ">
            <td>
                Precio:
            </td>
            <td>
              {bkg.price}
            </td>
          </tr>
          {userRole >= 3 && <Fragment>
            <tr className='details d-none'>
              <td>
                  IVA:
              </td>
              <td>
                <input type="checkbox" name="iva" value={bkg.iva} disabled />
              </td>
            </tr>
            <tr className='details'>
              <td>
                  Ocultar precio:
              </td>
              <td>
                <input type="checkbox" name="hide_price" checked={bkg.hide_price} disabled />
              </td>
            </tr>
            <tr className='details'>
              <td>
                  Fecha fija:
              </td>
              <td>
                <input type="checkbox" name="fixed_date" checked={bkg.fixed_date} disabled />
              </td>
            </tr>
            <tr className='details'>
              <td>
                  Factura:
              </td>
              <td>
                {bkg.invoice}
              </td>
            </tr>
          </Fragment>}
        </tbody>
      </table>
      <div className='btn btn-primary'onClick={() => navigate(props.uri + '/edit') }> Edit</div>
    </Fragment>
  )
}
