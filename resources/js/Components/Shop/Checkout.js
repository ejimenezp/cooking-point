import React from 'react'
import { useMutation } from 'react-query'

import MyButton from '../MyButton'
import MyButtonGroup from '../MyButtonGroup'
import myPost from '../myPost'

const Checkout = (props) => {
  const mutation = useMutation((ticket) => myPost('/api/shop/ticket/', ticket),
    { onSuccess: (result) => props.liftUp({ ...props.ticket, ...result.data }) })

  const checkout = (formaPago) => {
    if (!formaPago) {
      props.liftUp(null)
    } else {
      props.ticket.pago = formaPago
      mutation.mutate(props.ticket)
    }
  }

  return (
    <>
      <h1>Forma de pago</h1>
      <MyButtonGroup>
        <MyButton onClick={() => checkout('cash')}><i className="fs-1 bi bi-cash-coin"></i></MyButton>
        <MyButton onClick={() => checkout('credit card')}><i className="fs-1 bi bi-credit-card-2-back"></i></MyButton>
        <MyButton onClick={() => checkout(null)}><i className="fs-1 bi bi-reply"></i></MyButton>
      </MyButtonGroup>

    </>
  )
}

export default Checkout
