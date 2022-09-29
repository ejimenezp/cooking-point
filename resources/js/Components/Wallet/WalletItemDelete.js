import React from 'react'
import { useParams, useNavigate } from 'react-router-dom'
import { useQueryClient, useMutation } from 'react-query'

import myDelete from '../myDelete'
import MyButton from '../MyButton'
import MyButtonGroup from '../MyButtonGroup'
import MyLink from '../MyLink'

const WalletItemDelete = () => {
  const { id } = useParams()
  const queryClient = useQueryClient()
  const navigate = useNavigate()

  const mutation = useMutation((id) => myDelete(`/api/wallet/${id}`), {
    onMutate: async (id) => {
      // Cancel any outgoing refetches (so they don't overwrite our optimistic update)
      await queryClient.cancelQueries('wallet')

      // Snapshot the previous value
      const previouswallet = queryClient.getQueryData('wallet')
      const optimisticUpdate = previouswallet.filter((value, index, arr) => value.id !== parseInt(id))
      // Optimistically update to the new value
      return { optimisticUpdate }
    },
    // If the mutation fails, use the context returned from onMutate to roll back
    onError: (err, newTodo, context) => {
      alert('error con el ' + id)
      queryClient.setQueryData('wallet', context.previouswallet)
    },
    // Always refetch after error or success
    onSuccess: () => {
      navigate('/admin/wallet')
    }
  })

  return (<>
    <h1>¿Borrar Operación?</h1>
    <MyButtonGroup>
      <MyButton><MyLink to={`/admin/wallet/${id}`}><i className="fs-1 bi bi-reply"></i></MyLink></MyButton>
      <MyButton onClick={() => mutation.mutate(id)}><i className="fs-1 bi bi-check2"></i></MyButton>
    </MyButtonGroup>
  </>)
}

export default WalletItemDelete
