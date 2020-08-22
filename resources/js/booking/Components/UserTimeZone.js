import React, { useState, Fragment } from 'react'
import PropTypes from 'prop-types'
import Select from 'react-select'

export { UserTimeZone }

UserTimeZone.propTypes = {
  liftUp: PropTypes.func,
  timeZone: PropTypes.string

}

function UserTimeZone (props) {
  const [wantChange, setWantChange] = useState(false)
  const browserTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone
  let userTimeZone = props.timeZone

  if (!userTimeZone)
    userTimeZone = browserTimeZone

  function handleSelectTz (option) {
    props.liftUp(option.value)
  }


  return (
    <Fragment>
    <p><small>Schedules in your local time ({userTimeZone}) <a href="">Change</a></small></p> 
    { <Select options={selectTzOptions} defaultValue={selectTzOptions.find(el => el.label.indexOf(userTimeZone) > -1)} onChange={handleSelectTz} /> }
    </Fragment>
  )
}


const selectTzOptions = [{
    "value": "America/Anchorage",
    "label": "(GMT -9:00) Alaska"
  },
  {
    "value": "America/Los_Angeles",
    "label": "(GMT -8:00) Pacific Time (US & Canada)"
  },
  {
    "value": "America/Colorado",
    "label": "(GMT -7:00) Mountain Time (US & Canada)"
  },
  {
    "value": "America/Chicago",
    "label": "(GMT -6:00) Central Time (US & Canada), Mexico City"
  },
  {
    "value": "America/New_York",
    "label": "(GMT -5:00) Eastern Time (US & Canada), Bogota, Lima"
  },
  {
    "value": "America/Caracas",
    "label": "(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz"
  },
  {
    "value": "America/Buenos_Aires",
    "label": "(GMT -3:00) Brazil, Buenos Aires, Georgetown"
  },
  {
    "value": "Europe/London",
    "label": "(GMT) Western Europe Time, London, Lisbon, Casablanca"
  },
  {
    "value": "Europe/Madrid",
    "label": "(GMT +1:00) Brussels, Copenhagen, Madrid, Paris"
  },
  {
    "value": "Africa/Johannesburg",
    "label": "(GMT +2:00) Kaliningrad, South Africa"
  },
  {
    "value": "Europe/Moscow",
    "label": "(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg"
  },
  {
    "value": "Asia/Dubai",
    "label": "(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi"
  },
  {
    "value": "Asia/Kolkata",
    "label": "(GMT +5:30) Bombay, Calcutta, Madras, New Delhi"
  },
  {
    "value": "Asia/Bangkok",
    "label": "(GMT +7:00) Bangkok, Hanoi, Jakarta"
  },
  {
    "value": "Asia/Shanghai",
    "label": "(GMT +8:00) Beijing, Perth, Singapore, Hong Kong"
  },
  {
    "value": "Asia/Tokyo",
    "label": "(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk"
  },
  {
    "value": "Australia/Darwin",
    "label": "(GMT +9:30) Adelaide, Darwin"
  },
  {
    "value": "Australia/Sydney",
    "label": "(GMT +10:00) Eastern Australia, Guam, Vladivostok"
  },
  {
    "value": "Pacific/Auckland",
    "label": "(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka"
  }
]
