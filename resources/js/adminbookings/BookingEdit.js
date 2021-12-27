import React, { useState, useEffect, Fragment } from 'react'
import PropTypes from 'prop-types'
import { navigate } from '@reach/router'
// import { NavButtons } from './Components/NavButtons'
import { trackPromise } from 'react-promise-tracker'

const axios = require('axios').default

export default BookingEdit

BookingEdit.propTypes = {
  ceId: PropTypes.string,
  bkgId: PropTypes.string,
  schedule: PropTypes.array,
  sources: PropTypes.array,
  pricePlan: PropTypes.object,
  location: PropTypes.object,
  propagateFn: PropTypes.func
}

function BookingEdit (props) {
  const calendarevent = props.schedule.find((calendarevent) => calendarevent.id === parseInt(props.ceId))
  const bookings = calendarevent.bookings
  const isNewBooking = typeof props.bkgId === 'undefined'
  const emptyBkg = {
    calendarevent_id: props.ceId,
    date: calendarevent.date,
    type: calendarevent.type,
    source_id: 3,
    name: '',
    email: '',
    phone: '',
    adult: 1,
    child: 0,
    payment_date: '',
    food_requirements: '',
    comments: '',
    status: 'PENDING',
    pay_method: 'N/A',
    crm: 'NO',
    iva: 1,
    price: 0,
    hide_price: 0,
    fixed_date: 0
  }
  const [bkg, setBkg] = useState(isNewBooking ? emptyBkg : bookings.find((b) => b.id === parseInt(props.bkgId)))
  const [price, setPrice] = useState(0)
  const [pricePlan, setPricePlan] = useState({ source_id: bkg.source_id, type: bkg.type })

  const userRole = document.querySelector('meta[name="user_role"]').content

  useEffect(() => {
    setPrice(bkg.price)
  }, [bkg.price])

  useEffect(() => {
    const fetchPricePlan = async () => {
      try {
        const result = await axios.get('/api/priceplan/get', { params: { source_id: bkg.source_id, type: bkg.type } })
        setPricePlan({ ...pricePlan, ...result.data })
        setBkg({ ...bkg, iva: parseInt(result.data.iva) })
      } catch (error) {
        console.log('algo fue mal')
        console.log(error.response.data.error)
      }
    }
    fetchPricePlan()
  }, [bkg.source_id])

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
    let value = event.target.value
    if (event.target.type === 'checkbox') {
      value = !parseInt(bkg[event.target.name]) * 1
      setBkg({
        ...bkg,
        [event.target.name]: value,
        changed: 1
      })
    } else if (event.target.name === 'adult' && typeof pricePlan.adult !== 'undefined') {
      const newPrice = pricePlan.adult * value + pricePlan.child * bkg.child
      setPrice(newPrice)
      setBkg({
        ...bkg,
        price: newPrice,
        [event.target.name]: value,
        changed: 1
      })
    } else if (event.target.name === 'child' && typeof pricePlan.adult !== 'undefined') {
      const newPrice = pricePlan.adult * bkg.adult + pricePlan.child * value
      setPrice(newPrice)
      setBkg({
        ...bkg,
        price: newPrice,
        [event.target.name]: value,
        changed: 1
      })
    } else if (event.target.name === 'price') {
      setPrice(parseFloat(value))
      setBkg({
        ...bkg,
        [event.target.name]: value,
        changed: 1
      })
    } else {
      setBkg({
        ...bkg,
        [event.target.name]: value,
        changed: 1
      })
    }
  }

  function handleButtonSave () {
    if (bkg.changed) {
      trackPromise(
        (async () => {
          try {
            const result = await axios.post(isNewBooking ? '/api/booking/adminAdd' : '/api/booking/adminUpdate', bkg)
            setBkg(bkg)
            props.propagateFn(result.data)
          } catch (error) {
            console.log(error)
          }
        })()
      )
    }
    if (isNewBooking) {
      navigate('/adminbookings/' + bkg.date + '/' + bkg.calendarevent_id)
    } else {
      navigate('/adminbookings/' + bkg.date + '/' + bkg.calendarevent_id + '/' + bkg.id)
    }
  }

  function copyBookingLink () {
    var textArea = document.createElement('textarea')
    textArea.value = props.location.origin + '/booking/' + bkg.locator
    document.body.appendChild(textArea)
    textArea.select()
    try {
      document.execCommand('copy')
    } catch (err) {
      alert('Oops, unable to copy')
    }
    document.body.removeChild(textArea)
  }

  const adults = []
  for (let i = 1; i < 25; i++) adults.push(i)
  const children = []
  for (let i = 0; i < 25; i++) children.push(i)

  return (
    <Fragment>
      <div className="text-center">
        <button className="button_day_selector btn btn-primary " onClick={handlePrevBkg}>&lt;&lt;</button>
        <button className="button_day_selector btn btn-primary mx-1" onClick={() => navigate('/adminbookings/' + calendarevent.date + '/' + calendarevent.id)}>{calendarevent.type}</button>
        <button className="button_day_selector btn btn-primary" onClick={handleNextBkg}>&gt;&gt;</button>
      </div>
      <h1>
        {calendarevent.time.substring(0, 5)} {calendarevent.type}
      </h1>
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
              <select name="source_id" value={bkg.source_id} onChange={handleChange}>
                {props.sources && props.sources.map(source => (
                  <option key={source.id} value={source.id}>
                    {source.type + ' - ' + source.name}
                  </option>
                ))}
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
              {bkg.locator} <button className="btn btn-primary btn-sm" onClick={copyBookingLink}>Copiar</button>
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
              <input name="payment_date" type="text" value={bkg.payment_date || ''} onChange={handleChange} />
            </td>
          </tr>
          <tr className="price details ">
            <td>
                Precio:
            </td>
            <td>
              <input type="text" name="price" value={price || '0'} onChange={handleChange} />
            </td>
          </tr>
          {userRole >= 3 && <Fragment>
            <tr className='details'>
              <td>
                  IVA:
              </td>
              <td>
                <input type="checkbox" name="iva" value="1" checked={bkg.iva} onChange={handleChange} />
              </td>
            </tr>
            <tr className='details'>
              <td>
                  Ocultar precio:
              </td>
              <td>
                <input type="checkbox" name="hide_price" checked={parseInt(bkg.hide_price)} onChange={handleChange} />
              </td>
            </tr>
            <tr className='details'>
              <td>
                  Fecha fija:
              </td>
              <td>
                <input type="checkbox" name="fixed_date" checked={parseInt(bkg.fixed_date)} onChange={handleChange} />
              </td>
            </tr>
            <tr className='details'>
              <td>
                  Factura:
              </td>
              <td>
                <input type="text" name="invoice" value={bkg.invoice || ''} onChange={handleChange} />
              </td>
            </tr>
          </Fragment>}

          <tr className="booking_date_input details">
            <td>
                Fecha:
            </td>
            <td>
              <input type="text" id="booking_date_edit" onChange={handleChange} />
              <input type="hidden" name="date" id="bookingNewDate" onChange={handleChange} />
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
