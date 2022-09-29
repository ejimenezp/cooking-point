import React from 'react'
import Col from 'react-bootstrap/Col'

const TicketPill = ({ item }) => {
  let i = 0
  let description = ''
  while (!!item['linea' + i] && i < 10) {
    description += item['linea' + i] + ', '
    i++
  }
  description = description.slice(0, -2) // remove last comma

  return (
    <Col className="fs-5" md={{ span: 6, offset: 3 }}>
      <div className="d-flex p-1 align-items-baseline">
        {item.pago === 'cash' ? <i className="text-success bi bi-cash-coin"></i> : <i className="text-info bi bi-credit-card-2-back"></i>}
        <div className="ms-2 flex-grow-1">{description.substring(0, 17)}</div>
        <div className="ms-2">{parseFloat(item.total).toFixed(2)}</div>
      </div>
    </Col>
  )
}

export default TicketPill
