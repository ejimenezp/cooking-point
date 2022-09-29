import React, { useState, useEffect } from 'react'
import { useQuery } from 'react-query'

import MyButton from '../MyButton'
import MyButtonGroup from '../MyButtonGroup'
import myFetch from '../myFetch'
import PriceListPill from './PriceListPill'

// And now we can use these
const PriceList = (props) => {
  const { data, isLoading, error } = useQuery('priceList',
    () => myFetch('/api/product'),
    {
      staleTime: Infinity,
      onSuccess: (data) => setPriceList(data)
    }
  )

  useEffect(() => {
    if (typeof data !== 'undefined') {
      setPriceList(data)
    }
  }, [data])

  const [priceList, setPriceList] = useState()
  const [itemList, setItemList] = useState(props.itemList)

  if (isLoading) return <span>Loading...</span>
  if (error) return <span>Error: {error.message}</span>

  function handleClick (product) {
    setItemList([...itemList, { id: product.id, description: product.description, price: product.price }])
  }

  function handleClose () {
    props.liftUp(itemList)
  }

  return (
    <>
      <h1>Productos</h1>
      { !!priceList && priceList.map((product) => <div key={product.id} onClick={() => handleClick(product)}><PriceListPill id={product.id} description={product.description} itemList={itemList} /></div>)}
      <MyButtonGroup>
        <MyButton onClick={() => setItemList([])}><i className="fs-1 bi bi-x"></i></MyButton>
        <MyButton onClick={handleClose}><i className="fs-1 bi bi-check2"></i></MyButton>
      </MyButtonGroup>
    </>
  )
}

export default PriceList
