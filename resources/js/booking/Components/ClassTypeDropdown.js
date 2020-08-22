import React, { useState, useEffect } from 'react'
import Select from 'react-select'
import { utcToZonedTime, zonedTimeToUtc } from 'date-fns-tz'
import PropTypes from 'prop-types'

const axios = require('axios').default

export { ClassTypeDropdown }

ClassTypeDropdown.propTypes = {
  liftUp: PropTypes.func,
  default: PropTypes.string
}

function ClassTypeDropdown (props) {
  const [isError, setIsError] = useState(false)
  const [selectOptions, setSelectOptions] = useState([])
  const [defaultValue, setDefaultValue] = useState({})

  function localTime (hour) {
    const showTimeZone = props.onlineclass ? props.userTimeZone : 'Europe/Madrid'
    const classTime = zonedTimeToUtc('2018-09-01 ' + hour, 'Europe/Madrid')
    const options = {
      hour: "numeric",
      minute: "numeric",
      hour12: true,
      timeZone: showTimeZone
    }
    const a = new Intl.DateTimeFormat(props.userLanguage, options).format(classTime)
    return a
  }

  function handleSelectClass (option) {
    setDefaultValue(option)
    props.liftUp(option.value)
  }

  useEffect(() => {
    const fetchData = async () => {
      setIsError(false)
      try {
        const result = await axios(`/api/eventtype/bookable_by_clients?online=${props.onlineclass}`)
        var sel = []
        result.data.forEach( function (item) {
          const copy = {value : item.type , label: item.short_description + ' ' + localTime(item.time)}
          sel.push(copy)
        })
        setSelectOptions(sel)
        const def = sel.find((el) => el.value === props.default)
        if (!def) {
          def = sel[0]
        }
        setDefaultValue(def)
      } catch (error) {
        setIsError(true)
      }
    }
    fetchData()
  }, [props.onlineclass, props.userTimeZone])

  return (
    <Select options={selectOptions} value={defaultValue} onChange={handleSelectClass} />
  )
}
