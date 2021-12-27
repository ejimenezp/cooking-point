import React from 'react'
import { usePromiseTracker } from 'react-promise-tracker'

import PropTypes from 'prop-types'

export default LoadingIndicator

LoadingIndicator.propTypes = {
  row: PropTypes.object
}

function LoadingIndicator (props) {
  const { promiseInProgress } = usePromiseTracker()
  return (
    promiseInProgress &&
    <div className='loadingIndicator'>Cargando</div>
  )
}
