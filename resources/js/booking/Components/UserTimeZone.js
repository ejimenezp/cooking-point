import React, { useState, Fragment, useEffect } from 'react'
import PropTypes from 'prop-types'
import Select from 'react-select'

export { UserTimeZone }

const axios = require('axios').default

UserTimeZone.propTypes = {
  liftUp: PropTypes.func,
  timeZone: PropTypes.string

}

function UserTimeZone (props) {
  const [displaySelect, setDisplaySelect] = useState(false)
  const [selectTzOptions, setSelectTzOptions] = useState(JSON.parse(sessionStorage.getItem('selectTzOptions')))
  const [defaultTz, setDefaultTz] = useState(JSON.parse(sessionStorage.getItem('defaultValue')))
  const [isError, setIsError] = useState(false)
  const browserTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone
  let userTimeZone = props.timeZone

  if (!userTimeZone) {
    userTimeZone = browserTimeZone
  }

  function handleSelectTz (option) {
    setDefaultTz(option)
    sessionStorage.setItem('defaultTz', JSON.stringify(option))
    setDisplaySelect(false)
    props.liftUp(option.value)
  }

  useEffect(() => {
    const fetchData = async () => {
      setIsError(false)
      try {
        const result = await axios('/api/booking/timezones')
        var sel = []
        result.data.forEach(function (item) {
          const copy = { value: item.timezone, label: item.gmt }
          sel.push(copy)
        })
        setSelectTzOptions(sel)
        sessionStorage.setItem('selectTzOptions', JSON.stringify(sel))
        var i = _.findIndex(sel, (el) => el.value === userTimeZone)
        if (i === -1) {
          i = 0
        }
        setDefaultTz(sel[i])
        sessionStorage.setItem('defaultTz', JSON.stringify(sel[i]))
      } catch (error) {
        setIsError(true)
      }
    }
    const selectTzOptions = JSON.parse(sessionStorage.getItem('selectTzOptions'))
    const defaultTz = JSON.parse(sessionStorage.getItem('defaultTz'))
    if (selectTzOptions) {
      setSelectTzOptions(selectTzOptions)
      setDefaultTz(defaultTz)
    } else {
      fetchData()
    }
  }, [])

  return (
    <Fragment>
    <p><small>Times displayed in ({userTimeZone}) time <span className="badge btn-primary"><a onClick={ () => setDisplaySelect(!displaySelect) } >Change</a></span></small></p> 
    { displaySelect && <Select isSearchable={false} className='tz-select' options={selectTzOptions} value={defaultTz} onChange={handleSelectTz} /> }
    </Fragment>
  )
}
