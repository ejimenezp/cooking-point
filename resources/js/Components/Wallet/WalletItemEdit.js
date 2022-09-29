import React, { useState, useEffect } from 'react'
import { useNavigate, useParams } from 'react-router-dom'
import { useMutation, useQuery, useQueryClient } from 'react-query'
import Col from 'react-bootstrap/Col'
import { Formik, Form } from 'formik'
import * as Yup from 'yup'

import NumericPad from '../NumericPad/NumericPad'
import MyButton from '../MyButton'
import MyButtonGroup from '../MyButtonGroup'
import MyLink from '../MyLink'
import myFetch from '../myFetch'
import myPut from '../myPut'
import MyTextInput from '../MyTextInput'
import MyCheckbox from '../MyCheckbox'

const WalletItemEdit = (props) => {
  const navigate = useNavigate()
  const { data, isLoading, error } = useQuery('wallet',
    () => myFetch('/api/wallet'),
    { staleTime: Infinity }
  )

  const { id } = useParams()

  const [item, setItem] = useState()
  const [updatedIndex, setUpdatedIndex] = useState()
  const [showNumericPad, setShowNumericPad] = useState(false)

  useEffect(() => {
    if (typeof data !== 'undefined') {
      setItem(data.find(el => el.id === parseInt(id)))
      setUpdatedIndex(data.findIndex(item => item.id === parseInt(id)))
    }
  }, [data, id])

  const queryClient = useQueryClient()
  const apiCall = (values) => myPut(`/api/wallet/${values.id}`, values)

  const mutation = useMutation(apiCall, {
    onMutate: async (walletItem) => {
      // Cancel any outgoing refetches (so they don't overwrite our optimistic update)
      await queryClient.cancelQueries('wallet')

      // Snapshot the previous value
      const previousWallet = queryClient.getQueryData('wallet')
      // Return a context object with the snapshotted value
      return { previousWallet }
    },
    // If the mutation fails, use the context returned from onMutate to roll back
    onError: (err, newTodo, context) => {
      queryClient.setQueryData('wallet', context.previousWallet)
    },
    onSuccess: (result) => {
      const previousWallet = queryClient.getQueryData('wallet')
      previousWallet[updatedIndex].description = result.data.description
      previousWallet[updatedIndex].amount = result.data.amount
      previousWallet[updatedIndex].receipt = !!result.data.receipt

      // Optimistically update to the new value
      queryClient.setQueryData('wallet', previousWallet)
      navigate('/admin/wallet/' + result.data.id)
    }
  })

  if (isLoading) return <span>Loading...</span>
  if (error) return <span>Error: {error.message}</span>

  if (typeof item !== 'undefined') {
    item.receipt = !!item.receipt
    return (
      <>
        <h1>Editar Operación</h1>

        <Col className="fs-5" md={{ span: 6, offset: 3 }}>

          <Formik
            enableReinitialize
            initialValues = {item}
            validationSchema = {Yup.object({
              description: Yup.string()
                .max(32, 'Máximo 32 caracteres')
                .required('Introduce los detalles'),
              amount: Yup.number()
                .positive('Introduce un importe')
                .required('Introduce un importe')
            })}
            onSubmit={(values, { setSubmitting }) => {
              mutation.mutate(values)
            }}
          >
            {props => {
              const {
                values,
                dirty,
                isSubmitting,
                handleChange,
                handleSubmit,
                handleReset,
                setFieldValue
              } = props
              return (
                <Form>
                  {showNumericPad && <NumericPad initialValue={values.amount} liftUp={(value) => { setShowNumericPad(false); setFieldValue('amount', value) }} />}
                  <MyTextInput
                    type="hidden"
                    name="staff"
                  />

                  <MyTextInput
                    type="text"
                    label="Operación:"
                    name="description"
                    placeholder="detalles..."
                  />

                  <label htmlFor="Importe">Importe:</label><br/>
                  <label htmlFor="Importe" className="border rounded border-secondary p-1" onClick={() => setShowNumericPad(true)}>{parseFloat(values.amount).toFixed(2)}</label>
                  <MyTextInput
                    type="hidden"
                    name="amount"
                  />

                  <MyCheckbox name="receipt">
              Hay Ticket<i className="ms-2 bi bi-receipt"></i>
                  </MyCheckbox>

                  <MyButtonGroup>
                    {!showNumericPad && <>
                      <MyButton><MyLink to={`/admin/wallet/${values.id}`}><i className="fs-1 bi bi-reply"></i></MyLink></MyButton>
                      <MyButton type="submit"><i className="fs-1 bi bi-check2"></i></MyButton>
                    </>
                    }
                  </MyButtonGroup>
                </Form>)
            }}
          </Formik>
        </Col >
      </>
    )
  }
}

export default WalletItemEdit
