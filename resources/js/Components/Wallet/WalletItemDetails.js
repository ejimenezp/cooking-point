import React, { useState, useEffect } from 'react'

import { useParams } from 'react-router-dom'
import { format } from 'date-fns'
import { es } from 'date-fns/locale'

import Row from 'react-bootstrap/Row'
import Col from 'react-bootstrap/Col'
import MyButton from '../MyButton'
import MyButtonGroup from '../MyButtonGroup'
import MyLink from '../MyLink'
import myFetch from '../myFetch'

import { useQuery } from 'react-query'

// And now we can use these
const WalletItem = () => {
  const { data, isLoading, error } = useQuery('wallet',
    () => myFetch('/api/wallet'),
    { staleTime: Infinity }
  )

  const { id } = useParams()

  const [item, setItem] = useState()

  useEffect(() => {
    if (typeof data !== 'undefined') {
      setItem(data.find(el => el.id === parseInt(id)))
    }
  }, [data, id])

  if (isLoading) return <span>Loading...</span>
  if (error) return <span>Error: {error.message}</span>

  if (typeof item !== 'undefined') {
    return (<>
      <h1>Detalle Operación</h1>
      <Row>
        <Col className="fs-5" md={{ span: 6, offset: 3 }}>
          <div className="d-flex p-1 align-items-baseline">
            {item.type === 'COMPRA' ? <i className="text-danger bi bi-basket"></i> : <i className="fs-2 text-success bi bi-cash"></i>}
            <div className="ms-2 fs-6 text-secondary">{item.staff},</div>
            <div className="ms-2 fs-6 text-secondary">{format(new Date(item.created_at), 'd LLLL', { locale: es })}</div>
          </div>
        </Col>
      </Row>
      <Row>
        <Col className="fs-5" md={{ span: 6, offset: 3 }}>
          <div>Operación:</div>
          <div className="text-secondary">{item.description}</div>
          <div>Importe:</div>
          <div className="text-secondary">{parseFloat(item.amount).toFixed(2)}</div>
          {!!item.receipt && <i className="fs-2 ms-2 bi bi-receipt"></i> }
        </Col>
        <Col>
          <MyButtonGroup>
            <MyButton><MyLink to='/admin/wallet'><i className="fs-1 bi bi-reply"></i></MyLink></MyButton>
            <MyButton><MyLink to={`/admin/wallet/${item.id}/edit`}><i className="fs-1 bi bi-pencil"></i></MyLink></MyButton>
            <MyButton ><MyLink to={`/admin/wallet/${item.id}/delete`}><i className="fs-1 bi bi-x-circle"></i></MyLink></MyButton>
          </MyButtonGroup>
        </Col>
      </Row>
    </>)
  } else {
    return (<>
      <h1>Detalle Operación</h1>
      <Col className="fs-5" md={{ span: 6, offset: 3 }}>
        <p>No encontrado</p>
        <MyButtonGroup>
          <MyButton><MyLink to='/admin/wallet'><i className="fs-1 bi bi-reply"></i></MyLink></MyButton>
        </MyButtonGroup>
      </Col>
    </>)
  }
}

export default WalletItem
