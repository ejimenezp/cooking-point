import React, { useState, useEffect } from 'react'

import { useQuery } from 'react-query'
import WalletItemPill from './WalletItemPill'

import myFetch from '../myFetch'
import MyLink from '../MyLink'

// And now we can use these
const Wallet = () => {
  const { data, isLoading, error } = useQuery('wallet',
    () => myFetch('/api/wallet'),
    { onSuccess: (data) => setWallet(data) }
  )

  useEffect(() => {
    if (typeof data !== 'undefined') {
      setWallet(data)
    }
  }, [data])

  const [wallet, setWallet] = useState()

  if (isLoading) return <span>Loading...</span>
  if (error) return <span>Error: {error.message}</span>

  return (
    <>
      <h1>Últimas Operaciones</h1>
      { !!wallet && wallet.map((item) => <MyLink key={item.id} to={`/admin/wallet/${item.id}`}><WalletItemPill item={item} /></MyLink>)}
    </>
  )
}

export default Wallet
