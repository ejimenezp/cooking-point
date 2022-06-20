import React from 'react'
import PropTypes from 'prop-types'
import { MyModal } from './Modal'

class ErrorBoundary extends React.Component {
  constructor (props) {
    super(props)
    this.state = { error: null, errorInfo: null }

    if (this.props.showError === false) {
      this.state.error = null
      this.state.errorInfo = null
    }
  }

  componentDidCatch (error, info) {
    this.setState({ error: error, errorInfo: info })
  }

  render () {
    if (this.state.errorInfo) {
      const modal = {}
      modal.header = '<h4>Something wen&apos;t wrong internally</h4>'
      modal.body = 'Please, reload the page'

      return (
        <MyModal text={modal} liftUp={() => this.setState({ error: null, errorInfo: null })} />
      )
    } else {
      return this.props.children
    }
  }
}

export default ErrorBoundary

ErrorBoundary.propTypes = {
  showError: PropTypes.bool,
  children: PropTypes.object
}
