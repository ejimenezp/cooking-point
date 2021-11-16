import React, { useState, useEffect } from 'react'
import PropTypes from 'prop-types'

const axios = require('axios').default

export { CookName }

CookName.propTypes = {
  calendarevent: PropTypes.object
}

function CookName (props) {
  const [staff, setStaff] = useState()
  const calendarevent = props.calendarevent

  useEffect(() => {
    const fetchStaff = async () => {
      try {
        const result = await axios.get('/api/staff/get')
        setStaff(result.data)
      } catch (error) {
        console.log(error)
      }
    }
    fetchStaff()
  }, [])

  const cookName = (id) => {
    if (staff === undefined) return ''
    for (var i = 0; i < staff.length; i++) {
      if (staff[i].id === id) {
        return staff[i].name
      }
    }
  }
  const secondStaffName = (calendarevent.secondstaff_id === 2 ? '' : ', ' + cookName(calendarevent.secondstaff_id))


  return (
    <span>{cookName(calendarevent.staff_id) + secondStaffName}</span>
  )
}
