import React from 'react'
import Button from 'react-bootstrap/Button'

export default function TicketListItem (props) {
  const ticket = props.item

  return (
  	<>
      <div onClick={() => props.liftUp()}>{ticket.id} {ticket.fecha} {ticket.total}</div>
      <Button key={ticket.id} onClick={props.deleteFn}>Delete</Button>
    </>
  )
};
