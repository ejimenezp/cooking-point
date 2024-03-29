import React, { useState, useEffect } from 'react'
import Select from 'react-select'
import { zonedTimeToUtc } from 'date-fns-tz'
import PropTypes from 'prop-types'

const _ = require('lodash')
const axios = require('axios').default

export { ClassTypeDropdown }

ClassTypeDropdown.propTypes = {
  liftUp: PropTypes.func,
  onlineclass: PropTypes.number,
  userTimeZone: PropTypes.string,
  default: PropTypes.string
}

function ClassTypeDropdown (props) {
  const [isError, setIsError] = useState(false)
  const [selectOptions, setSelectOptions] = useState(JSON.parse(sessionStorage.getItem(props.onlineclass + props.userTimeZone + 'selectOptions')) || [])
  const [defaultClass, setDefaultClass] = useState({})

  function localTime (hour) {
    const showTimeZone = props.onlineclass ? props.userTimeZone : 'Europe/Madrid'
    const classTime = zonedTimeToUtc('2018-09-01 ' + hour, 'Europe/Madrid')
    const options = {
      hour: 'numeric',
      minute: 'numeric',
      hour12: true,
      timeZone: showTimeZone
    }
    const a = new Intl.DateTimeFormat('en-GB', options).format(classTime)
    return a
  }

  function handleSelectClass (option) {
    setDefaultClass(option)
    props.liftUp(option.value)
  }

  useEffect(() => {
    const fetchData = async () => {
      setIsError(false)
      try {
        const result = await axios(`/api/eventtype/bookable_by_clients?online=${props.onlineclass}`)
        var sel = []
        result.data.forEach(function (item) {
          const copy = { value: item.type, label: localTime(item.time) + ' ' + item.short_description }
          sel.push(copy)
        })
        setSelectOptions(sel)
        sessionStorage.setItem(props.onlineclass + props.userTimeZone + 'selectOptions', JSON.stringify(sel))
        var i = _.findIndex(sel, (el) => el.value === props.default)
        if (i === -1) {
          i = sel.length - 1
          props.liftUp(sel[i].value)
        }
        setDefaultClass(sel[i])
      } catch (error) {
        setIsError(true)
      }
    }
    const selectOptions = JSON.parse(sessionStorage.getItem(props.onlineclass + props.userTimeZone + 'selectOptions'))
    if (selectOptions) {
      setSelectOptions(selectOptions)
      var i = _.findIndex(selectOptions, (el) => el.value === props.default)
      if (i === -1) {
        i = selectOptions.length - 1
        props.liftUp(selectOptions[i].value)
      }
      setDefaultClass(selectOptions[i])
    } else {
      fetchData()
    }
  }, [props.onlineclass, props.userTimeZone])

  return (
    <Select className = 'classtype-select' options = { selectOptions } value = { defaultClass } onChange = { handleSelectClass } isSearchable = { false } />
  )
}
