import React from 'react'
import { useNavigate, useParams } from 'react-router-dom'
import { format } from 'date-fns'

import Datepicker from '../Components/Datepicker/Datepicker'

const ShopDatepicker = () => {
  const navigate = useNavigate()
  const { workingDate } = useParams()

  return (
    <Datepicker selectedDate={new Date(workingDate)} onClickFn={(day) => navigate('/admin/shop/' + format(day, 'yyyy-MM-dd')) }/>
  )
}

export default ShopDatepicker
