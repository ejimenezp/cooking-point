import React from 'react'
import Col from 'react-bootstrap/Col'

const WalletItemPill = ({ item }) => {
  return (
    <Col className="fs-5" md={{ span: 6, offset: 3 }}>
      <div className="d-flex p-1 align-items-baseline">
        {item.type === 'COMPRA' ? <i className="text-danger bi bi-basket"></i> : <i className="text-success bi bi-cash"></i>}
        <div className="ms-2 flex-grow-1">{item.description.substring(0, 15)}</div>
        {!!item.receipt && <i className="ms-2 bi bi-receipt"></i> }
        <div className="ms-2">{parseFloat(item.amount).toFixed(2)}</div>
      </div>
    </Col>
  )
}

export default WalletItemPill
