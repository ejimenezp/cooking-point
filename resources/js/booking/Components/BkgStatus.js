import React from 'react'
import PropTypes from 'prop-types'

export { BkgStatus }

BkgStatus.propTypes = {
  status: PropTypes.string
}

function BkgStatus (props) {
  const status = props.status
  return (
    <span className={'bkg-status bkg-status-' + status.toLowerCase()}>{status}</span>
  )
}
