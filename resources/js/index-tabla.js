import React, { Component } from 'react'
import ReactDOM from 'react-dom'

import '../sass/app.scss'

import Tabla from './components/booking/Tabla.js'

class BookingRoot extends Component {
  constructor (props) {
    super(props)
  }

  render () {
    return (
      <div>
        <h1>Esto es una tabla</h1>
        <Tabla filas={this.props.filas} />
      </div>
    )
  }
}
// ========================================

const filas = [{ id: 3, nombre: 'Antonio', estado: 'soltero', edad: 21 },
  { id: 4, nombre: 'Luis', estado: 'soltero', edad: 33 },
  { id: 5, nombre: 'Pedro', estado: 'casado', edad: 45 }
]

ReactDOM.render(
  <BookingRoot filas={filas} />,
  document.getElementById('root')
)
