import React from 'react'
import Col from 'react-bootstrap/Col'

const PriceListPill = ({ id, description, itemList }) => {
  const occurrencesInTheList = itemList.reduce((total, item) => total + Number(item.id === id), 0)
  return (
    <Col className="fs-5" md={{ span: 6, offset: 3 }}>
      <div className="d-flex p-1 align-items-baseline">
        <div className="ms-2 flex-grow-1">{description}</div>
        {!!occurrencesInTheList && <div className="bg-danger text-white rounded-circle px-2">{occurrencesInTheList}</div> }
      </div>
    </Col>
  )
}

export default PriceListPill