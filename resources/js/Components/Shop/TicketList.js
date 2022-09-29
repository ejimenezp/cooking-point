import React, { useState, useEffect } from 'react'
import { useParams } from 'react-router-dom'
import { format } from 'date-fns'
import { es } from 'date-fns/locale'

import { useQuery } from 'react-query'
import TicketPill from './TicketPill'

import myFetch from '../myFetch'
import MyLink from '../MyLink'

// And now we can use these
const TicketList = () => {
  const { workingDate } = useParams()

  const { data, isLoading, error } = useQuery(`ticketlist-${workingDate}`,
    () => myFetch('/api/shop/' + workingDate),
    { onSuccess: (data) => setTicketList(data) }
  )

  useEffect(() => {
    if (typeof data !== 'undefined') {
      setTicketList(data)
    }
  }, [data])

  const [ticketList, setTicketList] = useState()

  if (isLoading) return <span>Loading...</span>
  if (error) return <span>Error: {error.message}</span>

  return (
    <>
      <h1>Ventas {format(new Date(workingDate), 'd LLLL', { locale: es })}</h1>
      { !!ticketList && ticketList.map((item) => <MyLink key={item.id} to={`/admin/shop/${item.fecha}/ticket/${item.id}`}><TicketPill item={item} /></MyLink>)}
    </>
  )
}

export default TicketList
