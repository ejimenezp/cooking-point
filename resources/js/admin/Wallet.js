import React from 'react'
import { Outlet } from 'react-router-dom'

const Wallet = () => {
  return (
    <>
      <h1>Caja</h1>
      <Outlet />
    </>
  )
}

export default Wallet
