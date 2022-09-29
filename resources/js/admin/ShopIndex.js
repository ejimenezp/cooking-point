import React from 'react'

import MyButton from '../Components/MyButton'
import MyButtonGroup from '../Components/MyButtonGroup'
import MyLink from '../Components/MyLink'
import TicketList from '../Components/Shop/TicketList'

// And now we can use these

const ShopIndex = () => {
  return (
    <>
      <TicketList />
      <MyButtonGroup>
        <MyButton><MyLink to='datepicker'><i className="fs-1 bi bi-calendar-date"></i></MyLink></MyButton>
        <MyButton><MyLink to='new'><i className="fs-1 bi bi-cart-plus"></i></MyLink></MyButton>
      </MyButtonGroup>
    </>
  )
}

export default ShopIndex
