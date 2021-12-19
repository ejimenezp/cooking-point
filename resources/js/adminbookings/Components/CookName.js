import React from 'react'
import PropTypes from 'prop-types'

export default CookName 

CookName.propTypes = {
  staff: PropTypes.array,
  staff_id: PropTypes.number,
  secondstaff_id: PropTypes.number
}

function CookName (props) {
  const staff = props.staff

  const cookName = (id) => {
    if (staff === undefined) return ''
    for (var i = 0; i < staff.length; i++) {
      if (staff[i].id === parseInt(id)) {
        return staff[i].name
      }
    }
  }
  const secondStaffName = (parseInt(props.secondstaff_id) === 2 ? '' : ', ' + cookName(props.secondstaff_id))

  return (
    <span>{cookName(props.staff_id) + secondStaffName}</span>
  )
}
