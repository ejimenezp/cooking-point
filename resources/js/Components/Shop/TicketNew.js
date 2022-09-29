import React, { useReducer } from 'react'
import { useParams } from 'react-router-dom'

import MyButton from '../MyButton'
import MyButtonGroup from '../MyButtonGroup'
import MyLink from '../MyLink'

import PriceList from '../Shop/PriceList'
import TicketDetails from '../Shop/TicketDetails'
import TicketInProgress from '../Shop/TicketInProgress'
import Checkout from '../Shop/Checkout'

// And now we can use these

function reducer (state, action) {
  switch (action.type) {
    case 'showPriceList':
      return { ...state, state: 'ADDING' }

    case 'addItems':
      state = {
        ...state,
        fecha: state.workingDate,
        articulos: action.payload
      }
      const total = state.articulos.reduce((a, b) => a + Number(b.price), 0)
      return { ...state, total: total, state: 'OPEN' }

    case 'cancel':
      if (state.articulos.length) {
        return state.pago ? { ...state, state: 'PAID' } : { ...state, state: 'OPEN' }
      } else {
        return { ...state, state: 'EMPTY' }
      }

    case 'clean':
      return { ...state, state: 'EMPTY', articulos: [] }

    case 'checkout':
      return { ...state, state: 'CHECKOUT' }

    case 'pay':
      return { ...state, ...action.payload, state: 'PAID' }

    default:
  }
}

const TicketNew = () => {
  const { workingDate } = useParams()
  const INITIAL_STATE = {
    staff: document.querySelector('meta[name="user_name"]').content,
    articulos: [],
    state: 'EMPTY',
    workingDate: workingDate
  }
  const [state, dispatch] = useReducer(reducer, INITIAL_STATE)

  const handleAddItems = (itemList) => {
    if (itemList.length) {
      dispatch({ type: 'addItems', payload: itemList })
    } else {
      dispatch({ type: 'clean' })
    }
  }

  const handlePaidTicket = (paidTicket) => {
    if (paidTicket != null) {
      dispatch({ type: 'pay', payload: paidTicket })
    } else {
      dispatch({ type: 'cancel' })
    }
  }

  return (
    <>
      {state.state === 'EMPTY' && <>
        <h1>Nueva venta</h1>
        <div className="fs-5 bg-info">Selecciona los productos</div>
        <MyButtonGroup>
          <MyButton variant="primary"><MyLink className="text-decoration-none text-reset" to={`/admin/shop/${workingDate}`}><i className="fs-1 bi bi-reply"></i></MyLink></MyButton>
          <MyButton onClick={() => dispatch({ type: 'showPriceList' })}><i className="fs-1 bi bi-list-ul"></i></MyButton>{' '}
        </MyButtonGroup>

      </>}
      {state.state === 'OPEN' && <>
        <h1>Nueva venta (pendiente pago)</h1>
        <TicketInProgress ticket={state} />
        <MyButtonGroup>
          <MyButton onClick={() => dispatch({ type: 'clean' })}><i className="fs-1 bi bi-x"></i></MyButton>{' '}
          <MyButton onClick={() => dispatch({ type: 'showPriceList' })}><i className="fs-1 bi bi-list-ul"></i></MyButton>{' '}
          <MyButton onClick={() => dispatch({ type: 'checkout' })}><i className="fs-1 bi bi-cash-coin"></i></MyButton>
        </MyButtonGroup>
      </>}
      {state.state === 'ADDING' && <PriceList itemList={state.articulos} liftUp={handleAddItems} /> }
      {state.state === 'CHECKOUT' && <Checkout ticket={state} liftUp={handlePaidTicket} /> }
      {state.state === 'PAID' && <>
        <h1>Ticket pagado</h1>
        <TicketInProgress ticket={state} />
        <MyButtonGroup>
          <MyButton><MyLink to={`/admin/shop/${workingDate}`}><i className="fs-1 bi bi-reply"></i></MyLink></MyButton>
        </MyButtonGroup>
      </>}
      {state.state === 'TICKET' && <>
        <TicketDetails ticket={state} />
        <MyButtonGroup>
          <MyButton><MyLink to={`/admin/shop/${workingDate}`}><i className="fs-1 bi bi-reply"></i></MyLink></MyButton>
        </MyButtonGroup>
      </>}
    </>
  )
}

export default TicketNew
