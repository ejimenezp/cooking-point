import React, { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { useQuery, useMutation, useQueryClient } from 'react-query'
import { Formik, Form } from 'formik'
import * as Yup from 'yup'
import Col from 'react-bootstrap/Col'

import NumericPad from '../NumericPad/NumericPad'
import MyButton from '../MyButton'
import MyButtonGroup from '../MyButtonGroup'
import MyLink from '../MyLink'
import myFetch from '../myFetch'
import myPost from '../myPost'
import MyTextInput from '../MyTextInput'
import MyCheckbox from '../MyCheckbox'
import MySelect from '../MySelect'

const WalletItemNew = (props) => {
  const navigate = useNavigate()

  const { data, isLoading, error } = useQuery('shops',
    () => myFetch('/api/wallet/master'),
    {
      staleTime: Infinity,
      onSuccess: (data) => setShopList(data)
    }
  )

  const [shopList, setShopList] = useState()
  const [showNumericPad, setShowNumericPad] = useState(false)

  useEffect(() => {
    if (typeof data !== 'undefined') {
      setShopList(data)
    }
  }, [data])

  const queryClient = useQueryClient()
  const apiCall = (values) => myPost('/api/wallet', values)
  const initialValues = {
    type: 'COMPRA',
    predefinedShop: 'Granier',
    receipt: true, // added for our checkbox
    description: '',
    amount: '0',
    staff: document.querySelector('meta[name="user_name"]').content
  }

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
    // Always refetch after error or success:
    onSettled: () => {
      queryClient.invalidateQueries('wallet')
      navigate('/admin/wallet')
    },
    onSuccess: (result) => {
      const previousWallet = queryClient.getQueryData('wallet')
      const optimisticUpdate = [result.data, ...previousWallet]
      // Optimistically update to the new value
      queryClient.setQueryData('wallet', optimisticUpdate)
      navigate('/admin/wallet')
    }
  })

  if (isLoading) return <span>Loading...</span>
  if (error) return <span>Error: {error.message}</span>

  return (<>
    <h1>Nueva Operación</h1>

    <Col className="fs-5" md={{ span: 6, offset: 3 }}>

      <Formik
        enableReinitialize
        initialValues = {initialValues}
        validationSchema = {Yup.object({
          description: Yup.string()
            .max(32, 'Máximo 32 caracteres')
            .required('Elige una operación'),
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

              <MySelect label="Operación:" name="predefinedShop"
                onChange= { e => {
                  const value = e.target.value
                  setFieldValue('predefinedShop', value)
                  setFieldValue('type', shopList[value].type)
                  setFieldValue('description', shopList[value].description)
                  setFieldValue('receipt', !!shopList[value].defaultreceipt)
                }}>
                { !!shopList && shopList.map((shop, index) => <option key={index} value={index}>{shop.description}</option>) }
              </MySelect>

              <MyTextInput
                type="text"
                label="Detalles:"
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
            Hay Ticket
              </MyCheckbox>

              <MyButtonGroup>
                {!showNumericPad && <>
                  <MyButton><MyLink to='/admin/wallet'><i className="fs-1 bi bi-reply"></i></MyLink></MyButton>
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

export default WalletItemNew
