import React from 'react'
import { useParams, useNavigate } from 'react-router-dom'
import { useQueryClient, useMutation } from 'react-query'

import MyButton from '../MyButton'
import MyButtonGroup from '../MyButtonGroup'
import MyLink from '../MyLink'
import myDelete from '../myDelete'

const TicketDelete = () => {
  const { workingDate, ticketId } = useParams()
  const queryClient = useQueryClient()
  const navigate = useNavigate()

  const mutation = useMutation((id) => myDelete(`/api/shop/ticket/${id}`), {
    onMutate: async (id) => {
      // Cancel any outgoing refetches (so they don't overwrite our optimistic update)
      await queryClient.cancelQueries(`ticketlist-${workingDate}`)

      // Snapshot the previous value
      const previoushistory = queryClient.getQueryData(`ticketlist-${workingDate}`)
      const optimisticUpdate = previoushistory.filter((value, index, arr) => value.id !== parseInt(ticketId))
      // Optimistically update to the new value
      queryClient.setQueryData(`ticketlist-${workingDate}`, optimisticUpdate)
      navigate(`/admin/shop/${workingDate}`)
    },
    // If the mutation fails, use the context returned from onMutate to roll back
    onError: (err, newTodo, context) => {
      queryClient.setQueryData(`ticketlist-${workingDate}`, context.previoushistory)
    },
    // Always refetch after error or success
    onSettled: () => {
      queryClient.invalidateQueries(`ticketlist-${workingDate}`)
      navigate(`/admin/shop/${workingDate}`)
    }
  })

  return (<>
    <h1>Borrar venta?</h1>
    <MyButtonGroup>
      <MyButton><MyLink to={`/admin/shop/${workingDate}/ticket/${ticketId}`}><i className="fs-1 bi bi-reply"></i></MyLink></MyButton>
      <MyButton onClick={() => mutation.mutate(ticketId)}><i className="fs-1 bi bi-check2"></i></MyButton>
    </MyButtonGroup>

  </>)
}

export default TicketDelete
