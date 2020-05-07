import React from 'react'
import ReactDOM from 'react-dom'

class Clock extends React.Component {
  constructor (props) {
    super(props)
    this.state = { date: new Date() }
  }

  componentDidMount () {
    this.timerId = setInterval(() => this.tick(), 1000)
  }

  componentWillUnmount () {
    clearInterval(this.timerId)
  }

  tick () {
    this.setState({
      date: new Date()
    })
  }

  render () {
    return (
      <div>
        <h1>Hello, world!</h1>
        <h2>It is {this.state.date.toLocaleTimeString()}.</h2>
      </div>
    )
  }
}

class ActionLink extends React.Component {
  constructor (props) {
    super(props)
  }

  handleClick (nombre) {
    console.log('The link ' + nombre + ' was clicked')
  }

  render () {
    return (
      <a href='#' onClick={this.handleClick.bind(this, this.props.texto)}>
        {this.props.texto}
      </a>
    )
  }
}

function App () {
  return (
    <div>
      <Clock />
      <ActionLink texto='cliqueame' />

    </div>)
}

// ========================================

ReactDOM.render(
  <App />,
  document.getElementById('root')
)
