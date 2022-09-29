import React from 'react'
import PropTypes from 'prop-types'
import { format } from 'date-fns'
import Col from 'react-bootstrap/Col'

const TicketInProgress = ({ ticket }) => {
  if (typeof ticket === 'undefined' || !ticket.articulos.length) return

  return (
    <Col className="fs-5" md={{ span: 6, offset: 3 }}>
      <div className="fs-4 fw-bold">Sale Receipt</div>
      <div className="text-secondary mb-3">{format(new Date(ticket.fecha), 'cccc, d MMMM yyyy')}</div>

      {(ticket.articulos).map((product, i) => <div key={i} className="d-flex"><div className="flex-grow-1">{product.description}</div><div>{product.price}</div></div>)}
      <div className="mt-2 d-flex fw-bold"><div className="flex-grow-1">Total</div><div>{parseFloat(ticket.total).toFixed(2)}</div></div>
      {ticket.pago ?
        <div className="mt-3 d-flex fw-bold">
          <div className="flex-grow-1">Paid with:</div>
          <div>{ticket.pago === 'cash' ? <i className="fs-3 text-success bi bi-cash-coin"></i> : <i className="fs-1 text-info bi bi-credit-card-2-back"></i>}</div>
        </div>
        : <div className="mt-3 d-flex bg-info">Selecciona método de pago</div>}
    </Col>
  )
}

TicketInProgress.propTypes = {
  ticket: PropTypes.object
}

export default TicketInProgress
