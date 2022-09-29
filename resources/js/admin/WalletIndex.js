import React from 'react'

import MyButton from '../Components/MyButton'
import MyButtonGroup from '../Components/MyButtonGroup'
import MyLink from '../Components/MyLink'
import Wallet from '../Components/Wallet/Wallet'

// And now we can use these

const WalletIndex = () => {
  return (
    <>
      <Wallet />
      <MyButtonGroup>
        <MyButton><MyLink to='new'><i class="fs-1 bi bi-bag-plus-fill"></i></MyLink></MyButton>
      </MyButtonGroup>
    </>
  )
}

export default WalletIndex
