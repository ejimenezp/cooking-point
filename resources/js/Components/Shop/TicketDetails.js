import React, { useState, useEffect } from 'react'

import { useParams } from 'react-router-dom'
import { format } from 'date-fns'
import { es } from 'date-fns/locale'

import Row from 'react-bootstrap/Row'
import Col from 'react-bootstrap/Col'

import MyButton from '../MyButton'
import MyButtonGroup from '../MyButtonGroup'
import MyLink from '../MyLink'

import { useQuery } from 'react-query'

import myFetch from '../myFetch'

// And now we can use these
const TicketDetails = () => {
  const { ticketId } = useParams()
  const { data, isLoading, error } = useQuery(`ticket-${ticketId}`,
    () => myFetch('/api/shop/ticket/' + ticketId),
    { staleTime: Infinity }
  )

  const [ticket, setTicket] = useState()

  useEffect(() => {
    if (typeof data !== 'undefined') {
      setTicket(data)
    }
  }, [data, ticketId])

  if (isLoading) return <span>Loading...</span>
  if (error) return <span>Error: {error.message}</span>

  if (typeof ticket !== 'undefined') {
    let i = 0
    var description = []
    while (!!ticket['linea' + i] && i < 10) {
      description.push(ticket['linea' + i])
      i++
    }

    return (<>
      <h1>Detalle Venta #{ticket.id}</h1>
      <Row>
        <Col className="fs-5" md={{ span: 6, offset: 3 }}>
          <div className="text-secondary">{ticket.staff}, {format(new Date(ticket.fecha), 'd LLLL', { locale: es })}</div>
          {description.map((line, index) => <div key={index} className="ms-2">{line}</div>)}
          <div className="fs-4">Total: <span className="text-secondary">{parseFloat(ticket.total).toFixed(2)} €</span></div>
          <div className="fs-4">Pagado con {ticket.pago === 'cash' ? <i className="fs-3 text-success bi bi-cash-coin"></i> : <i className="fs-3 text-info bi bi-credit-card-2-back"></i>}</div>

          <MyButtonGroup>
            <MyButton><MyLink to={`/admin/shop/${ticket.fecha}`}><i className="fs-1 bi bi-reply"></i></MyLink></MyButton>
            <MyButton><MyLink to={`/admin/shop/${ticket.fecha}/ticket/${ticket.id}/delete`}><i className="fs-1 bi bi-x-circle"></i></MyLink></MyButton>
          </MyButtonGroup>
        </Col>
      </Row>
    </>)
  } else {
    return (<>
      <p>No encontrado</p>
      <MyButton><MyLink to={'/admin/shop/'}><i className="fs-1 bi bi-reply"></i></MyLink></MyButton>
    </>)
  }
}

export default TicketDetails
