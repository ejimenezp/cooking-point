import React, { useState } from 'react'
import Col from 'react-bootstrap/Col'
import Row from 'react-bootstrap/Row'

export default NumericPad

function NumericPad ({ initialValue, liftUp, ...props }) {
  const [value, setValue] = useState(initialValue === '0.00' ? '0' : initialValue)

  const handleValue = (key) => {
    switch (key) {
      case 'clr':
        setValue('0')
        break
      case 'bksp':
        setValue(value.length > 1 ? value.slice(0, -1) : '0')
        break
      case 'ok':
        liftUp(parseFloat(value).toFixed(2))
        break
      case '.':
        setValue(value.indexOf(key) === -1 ? value + key : value)
        break
      default:
        setValue(value === '0' ? key : value + key)
    }
  }

  return (
    <>
      <Col className="my-1 rounded border border-primary bg-white w-100 p-3 fs-1 text-center lh-lg">
        <Row>
          <Col className="text-end">{value}</Col>
        </Row>
        <Row>
          <Col onClick={() => handleValue('1')}><div className="my-1 rounded border rounded-pill bg-gradient bg-warning">1</div></Col>
          <Col onClick={() => handleValue('2')}><div className="my-1 rounded border rounded-pill bg-gradient bg-warning">2</div></Col>
          <Col onClick={() => handleValue('3')}><div className="my-1 rounded border rounded-pill bg-gradient bg-warning">3</div></Col>
        </Row>
        <Row>
          <Col onClick={() => handleValue('4')}><div className="my-1 rounded border rounded-pill bg-gradient bg-warning">4</div></Col>
          <Col onClick={() => handleValue('5')}><div className="my-1 rounded border rounded-pill bg-gradient bg-warning">5</div></Col>
          <Col onClick={() => handleValue('6')}><div className="my-1 rounded border rounded-pill bg-gradient bg-warning">6</div></Col>
        </Row>
        <Row>
          <Col onClick={() => handleValue('7')}><div className="my-1 rounded border rounded-pill bg-gradient bg-warning">7</div></Col>
          <Col onClick={() => handleValue('8')}><div className="my-1 rounded border rounded-pill bg-gradient bg-warning">8</div></Col>
          <Col onClick={() => handleValue('9')}><div className="my-1 rounded border rounded-pill bg-gradient bg-warning">9</div></Col>
        </Row>
        <Row>
          <Col onClick={() => handleValue('.')}><div className="my-1 rounded border rounded-pill bg-gradient bg-warning">.</div></Col>
          <Col onClick={() => handleValue('0')}><div className="my-1 rounded border rounded-pill bg-gradient bg-warning">0</div></Col>
          <Col onClick={() => handleValue('bksp')}><div className="my-1 rounded border rounded-pill bg-gradient bg-light"><i className="fs-1 bi bi-backspace"></i></div></Col>
        </Row>
        <Row>
          <Col onClick={() => handleValue('clr')}><div className="my-1 rounded border rounded-pill bg-gradient bg-light">clr</div></Col>
          <Col onClick={() => handleValue('ok')}><div className="my-1 rounded border rounded-pill bg-gradient bg-success">OK</div></Col>
        </Row>
      </Col>
    </>
  )
}
